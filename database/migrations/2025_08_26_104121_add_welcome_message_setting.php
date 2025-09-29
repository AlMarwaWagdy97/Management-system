<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        $settingId = DB::table('settings')->where('key', 'general')->value('id');

        if ($settingId) {
            DB::table('settings_values')->updateOrInsert(
                ['setting_id' => $settingId, 'key' => 'welcome_message_ar'],
                [
                    'value' => ' ',
                    'type' => 0, 
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );

            DB::table('settings_values')->updateOrInsert(
                ['setting_id' => $settingId, 'key' => 'welcome_message_en'],
                [
                    'value' => ' ',
                    'type' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }

    public function down()
    {
        $settingId = DB::table('settings')->where('key', 'general')->value('id');
        
        if ($settingId) {
            DB::table('settings_values')
                ->where('setting_id', $settingId)
                ->whereIn('key', ['welcome_message_ar', 'welcome_message_en'])
                ->delete();
        }
    }
};