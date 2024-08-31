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
        Schema::table('movie_person', function (Blueprint $table) {
            $table->renameColumn('cast_id', 'person_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('movie_person', function (Blueprint $table) {
            $table->renameColumn('person_id', 'cast_id');
        });
    }
};
