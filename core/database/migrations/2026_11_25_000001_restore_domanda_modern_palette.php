<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Only repair the known stale palette. Later edits in the dashboard must stay intact.
        DB::table('settings')
            ->where('theme_name', 'modern')
            ->where('style_color1', '#333399')
            ->where('style_color2', '#339933')
            ->where('style_color3', '#cccccc')
            ->where('style_color4', '#999999')
            ->update([
                'style_color2' => '#000066',
                'style_color3' => '#339933',
                'style_color4' => '#FFCC00',
            ]);

        Cache::forget('_Loader_Web_Settings_modern');
    }

    public function down(): void
    {
        // Palette values may have been edited since the migration ran.
    }
};
