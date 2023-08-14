<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WebsiteSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('website_settings')->insert([
            [
                'label' => "home_banner",
                'value' => "sdafas.jpg",
            ],
            [
                'label' => "home_banner_2",
                'value' => "",
            ],
            [
                'label' => "home_banner_3",
                'value' => "",
            ],
            [
                'label' => "slider_1",
                'value' => "slider_1_1642056675.jpg",
            ],
            [
                'label' => "slider_2",
                'value' => "slider_2_1642056711.jpg",
            ],
            [
                'label' => "slider_3",
                'value' => "slider_3_1642056726.jpg",
            ],
            [
                'label' => "slider_1_mob",
                'value' => "slider_1_mob_1645535640.jpg",
            ],
            [
                'label' => "slider_2_mob",
                'value' => "slider_2_mob_1629353536.jpg",
            ],
            [
                'label' => "slider_3_mob",
                'value' => "slider_3_mob_1629353543.jpg",
            ],
        ]);
    }
}
