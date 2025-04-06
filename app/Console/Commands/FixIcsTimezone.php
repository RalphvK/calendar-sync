<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use ICal\ICal;
use DateTime;
use DateTimeZone;

use App\Helpers\WindowsTimezoneHelper;

class FixIcsTimezone extends Command
{
    protected $signature = 'ics:fix-timezone {userId}';
    protected $description = 'Fetch .ics file, fix timezone, and save corrected .ics file';

    public function handle()
    {
        $userId = $this->argument('userId');
        $user = \App\Models\User::find($userId);

        if (!$user || !$user->ics_url) {
            $this->error('User not found or ICS URL not set.');
            return 1;
        }

        $sources = $user->sources;

        foreach ($sources as $source) {
            if ($source->type !== 'ics' || !$source->ics_url) {
                $this->error("Source {$source->id} is not a valid ICS source.");
                continue;
            }

            $response = Http::get($source->ics_url);
            if (!$response->ok()) {
                $this->error("Failed to fetch the .ics file for source {$source->id}.");
                continue;
            }

            $icsContent = $response->body();

            // Modify the timezone in the .ics content
            try {
                // Parse the VTIMEZONE block to determine the original timezone
                preg_match('/BEGIN:VTIMEZONE.*?TZID:([^\\n]+).*?END:VTIMEZONE/s', $icsContent, $matches);
                $originalTimezone = isset($matches[1]) ? trim($matches[1]) : 'Europe/Amsterdam';

                // Create DateTimeZone objects for the original and target timezones
                $originalTz = null;
                try {
                    $originalTz = new DateTimeZone($originalTimezone);
                } catch (\Exception $e) {
                    // try using App\Helpers\WindowsTimezoneHelper
                    try {
                        $originalTz = new DateTimeZone(WindowsTimezoneHelper::convertToTZID($originalTimezone));
                    } catch (\Exception $e) {
                        // Fallback to Europe/Amsterdam if the timezone is invalid
                        $this->warn("Unknown or bad timezone '{$originalTimezone}', falling back to UTC.");
                        $originalTz = new DateTimeZone('UTC');
                    }
                }
                $targetTz = new DateTimeZone('UTC');

                // Adjust event times to the target timezone
                $updatedIcsContent = preg_replace_callback(
                    '/DTSTART(?:;[^:]+)?:([0-9T]+)/',
                    function ($match) use ($originalTz, $targetTz) {
                        $date = new DateTime($match[1], $originalTz);
                        $date->setTimezone($targetTz);
                        return 'DTSTART:' . $date->format('Ymd\THis');
                    },
                    $icsContent
                );

                $updatedIcsContent = preg_replace_callback(
                    '/DTEND(?:;[^:]+)?:([0-9T]+)/',
                    function ($match) use ($originalTz, $targetTz) {
                        $date = new DateTime($match[1], $originalTz);
                        $date->setTimezone($targetTz);
                        return 'DTEND:' . $date->format('Ymd\THis');
                    },
                    $updatedIcsContent
                );

                // Remove the VTIMEZONE block and replace TZID with the target timezone
                $updatedIcsContent = preg_replace(
                    [
                        '/BEGIN:VTIMEZONE.*?END:VTIMEZONE/s', // Match VTIMEZONE blocks
                        '/TZID=[^:;]+/', // Match timezone definitions
                    ],
                    [
                        '', // Remove VTIMEZONE blocks
                        'TZID=Europe/Amsterdam', // Replace with Europe/Amsterdam
                    ],
                    $updatedIcsContent
                );

                // Extract the random string and filename from the URL
                $parsedUrl = parse_url($source->ics_url);
                $pathParts = explode('/', ltrim($parsedUrl['path'], '/'));
                $randomString = $pathParts[2]; // First part of the path
                $filename = end($pathParts); // Last part of the path (filename)

                // Save the updated .ics file to public storage
                $path = "ics/{$userId}/{$randomString}{$filename}";
                Storage::disk('public')->put($path, $updatedIcsContent);

                // Update the source record with the converted file path
                $source->converted_ics_path = $path;
                $source->last_converted = now();
                $source->save();

                $this->info("Updated .ics file saved to: " . Storage::disk('public')->path($path));
            } catch (\Exception $e) {
                $this->error('Failed to process the .ics file: ' . $e->getMessage());
            }
        }

        return 0;
    }
}
