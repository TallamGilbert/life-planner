<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // General Settings
            ['key' => 'app_name', 'value' => 'Life Planner', 'type' => 'string', 'group' => 'general'],
            ['key' => 'app_description', 'value' => 'Manage your budget, habits, and meals', 'type' => 'string', 'group' => 'general'],
            ['key' => 'maintenance_mode', 'value' => '0', 'type' => 'boolean', 'group' => 'general'],
            
            // Demo Settings
            ['key' => 'demo_enabled', 'value' => '1', 'type' => 'boolean', 'group' => 'demo'],
            ['key' => 'demo_duration_hours', 'value' => '1', 'type' => 'integer', 'group' => 'demo'],
            ['key' => 'demo_auto_cleanup', 'value' => '1', 'type' => 'boolean', 'group' => 'demo'],
            
            // User Settings
            ['key' => 'allow_registration', 'value' => '1', 'type' => 'boolean', 'group' => 'users'],
            ['key' => 'require_email_verification', 'value' => '0', 'type' => 'boolean', 'group' => 'users'],
            
            // Email Settings
            ['key' => 'admin_email', 'value' => 'admin@lifeplanner.com', 'type' => 'string', 'group' => 'email'],
            ['key' => 'send_welcome_email', 'value' => '1', 'type' => 'boolean', 'group' => 'email'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}