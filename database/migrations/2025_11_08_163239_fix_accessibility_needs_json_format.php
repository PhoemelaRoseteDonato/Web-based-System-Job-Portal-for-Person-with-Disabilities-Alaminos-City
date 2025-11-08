<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Fix existing non-JSON data in accessibility_needs column
        $profiles = DB::table('pwd_profiles')
            ->whereNotNull('accessibility_needs')
            ->get();

        foreach ($profiles as $profile) {
            // Check if the value is already valid JSON
            $decoded = json_decode($profile->accessibility_needs);
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                // Not valid JSON, convert it
                $jsonValue = json_encode(['notes' => $profile->accessibility_needs]);
                
                DB::table('pwd_profiles')
                    ->where('id', $profile->id)
                    ->update(['accessibility_needs' => $jsonValue]);
            }
        }

        // Do the same for assistive_devices if it exists and has text data
        $profiles = DB::table('pwd_profiles')
            ->whereNotNull('assistive_devices')
            ->get();

        foreach ($profiles as $profile) {
            // Check if the value is already valid JSON
            $decoded = json_decode($profile->assistive_devices);
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                // Not valid JSON, convert it
                $jsonValue = json_encode(['devices' => $profile->assistive_devices]);
                
                DB::table('pwd_profiles')
                    ->where('id', $profile->id)
                    ->update(['assistive_devices' => $jsonValue]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Optionally convert back to text (not recommended as data may be lost)
        // We'll leave this empty as reverting JSON to text can cause data loss
    }
};
