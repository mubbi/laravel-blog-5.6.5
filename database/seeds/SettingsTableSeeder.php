<?php

use App\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->truncate();

        Setting::create([
            'setting_name' => 'blog_title',
            'setting_value' => 'Laravel Blog',
            'description' => 'Website Title'
        ]);
        Setting::create([
            'setting_name' => 'blog_subtitle',
            'setting_value' => 'A Simple Blog With PHP Laravel',
            'description' => 'Website Sub Title'
        ]);
        Setting::create([
            'setting_name' => 'per_page_posts',
            'setting_value' => '10',
            'description' => 'Number of blog posts to show on 1 page'
        ]);
        Setting::create([
            'setting_name' => 'per_page_comments',
            'setting_value' => '10',
            'description' => 'Number of comments to show on 1 page'
        ]);
    }
}
