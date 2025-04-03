<?php

namespace App\Helpers;

class WindowsTimezoneHelper
{
  /**
   * Convert a Windows timezone to the first TZID.
   *
   * @param string $windowsTimezone
   * @return string|null
   */
  public static function convertToTZID(string $windowsTimezone): ?string
  {
    // Load the mapping array from the configuration file
    $mapping = config('windows-tzid-mapping-array');

    // Search for the Windows timezone in the mapping
    foreach ($mapping as $entry) {
      if (isset($entry['windows']) && $entry['windows'] === $windowsTimezone) {
        // Return the first TZID if it exists
        return $entry['TZID'][0] ?? null;
      }
    }

    // Return null if no match is found
    return null;
  }
}
