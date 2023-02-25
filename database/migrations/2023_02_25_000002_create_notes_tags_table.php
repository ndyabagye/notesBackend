<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('notes_tags', function (Blueprint $table) {
            $table->unsignedBigInteger('notes_id');
            $table->unsignedBigInteger('tags_id');
            $table->bigIncrements('note_tags_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notes_tags');
    }
};
