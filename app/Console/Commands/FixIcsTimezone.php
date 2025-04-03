<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use ICal\ICal;

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

        // Fetch the .ics file
        $response = Http::get($user->ics_url);
        if (!$response->ok()) {
            $this->error('Failed to fetch the .ics file.');
            return 1;
        }

        $icsContent = $response->body();

        // Modify the timezone in the .ics content
        try {
            // Replace all timezone-related information with Europe/Amsterdam
            $updatedIcsContent = preg_replace(
                [
                    '/TZID=[^:;]+/', // Match timezone definitions
                    '/BEGIN:VTIMEZONE.*?END:VTIMEZONE/s', // Match VTIMEZONE blocks
                ],
                [
                    'TZID=Europe/Amsterdam', // Replace with Europe/Amsterdam
                    '', // Remove VTIMEZONE blocks
                ],
                $icsContent
            );

            // Extract the random string and filename from the URL
            $parsedUrl = parse_url($user->ics_url);
            $pathParts = explode('/', ltrim($parsedUrl['path'], '/'));
            $randomString = $pathParts[2]; // First part of the path
            $filename = end($pathParts); // Last part of the path (filename)

            // Save the updated .ics file to public storage
            $path = "ics/{$userId}/{$randomString}{$filename}";
            Storage::disk('public')->put($path, $updatedIcsContent);

            $this->info("Updated .ics file saved to: " . Storage::disk('public')->url($path));
            return 0;
        } catch (\Exception $e) {
            $this->error('Failed to process the .ics file: ' . $e->getMessage());
            return 1;
        }
    }
}
