<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('review_tag', function (Blueprint $table) {
            $table->primary(['review_id','tag_id']);
            $table->foreignId('review_id')->constrained('reviews');
            $table->foreignId('tag_id')->constrained('tags');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('review_tag');
    }
};
