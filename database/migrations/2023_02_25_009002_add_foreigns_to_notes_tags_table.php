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
        Schema::table('notes_tags', function (Blueprint $table) {
            $table
                ->foreign('notes_id')
                ->references('id')
                ->on('notes')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('tags_id')
                ->references('id')
                ->on('tags')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notes_tags', function (Blueprint $table) {
            $table->dropForeign(['notes_id']);
            $table->dropForeign(['tags_id']);
        });
    }
};
