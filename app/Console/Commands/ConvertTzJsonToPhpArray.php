<?php

// filepath: /Users/Ralph/repos/projects/calendar-sync/app/Console/Commands/ConvertJsonToPhpArray.php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ConvertTzJsonToPhpArray extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ics:tz-json-php';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Convert a JSON file to a PHP array and save it as a PHP file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Path to the JSON file
        $jsonFilePath = base_path('docs/windows-timezones/windows-tzid-mapping-arrays.json');

        // Check if the JSON file exists
        if (!File::exists($jsonFilePath)) {
            $this->error("JSON file not found at: $jsonFilePath");
            return 1;
        }

        // Read the JSON file
        $jsonContent = File::get($jsonFilePath);

        // Decode the JSON content into a PHP array
        $phpArray = json_decode($jsonContent, true);

        // Check if decoding was successful
        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->error('Error decoding JSON: ' . json_last_error_msg());
            return 1;
        }

        // Path to save the PHP array file in the config folder
        $outputFilePath = config_path('windows-tzid-mapping-array.php');

        // Ensure the directory exists
        if (!file_exists(dirname($outputFilePath))) {
            mkdir(dirname($outputFilePath), 0755, true);
        }

        // Convert the PHP array to a string
        $outputContent = "<?php\n\nreturn " . var_export($phpArray, true) . ";\n";

        // Write the PHP array to a file
        file_put_contents($outputFilePath, $outputContent);

        $this->info("PHP array has been successfully written to: $outputFilePath");

        return 0;
    }
}