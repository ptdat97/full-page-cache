<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        if (! Schema::hasTable('full_page_caches')) {
            Schema::create('full_page_caches', function (Blueprint $table) {
                $table->id();
                $table->string('name', 255);
                $table->string('status', 60)->default('published');
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('full_page_caches_translations')) {
            Schema::create('full_page_caches_translations', function (Blueprint $table) {
                $table->string('lang_code');
                $table->foreignId('full_page_caches_id');
                $table->string('name', 255)->nullable();

                $table->primary(['lang_code', 'full_page_caches_id'], 'full_page_caches_translations_primary');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('full_page_caches');
        Schema::dropIfExists('full_page_caches_translations');
    }
};
