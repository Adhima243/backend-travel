<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE `blog_posts` MODIFY `cover_image` LONGTEXT NULL");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE `blog_posts` MODIFY `cover_image` VARCHAR(255) NULL");
    }
};
