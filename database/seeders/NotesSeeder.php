<?php

namespace Database\Seeders;

use App\Models\Notes;
use Illuminate\Database\Seeder;

class NotesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Notes::factory()
            ->count(5)
            ->create();
    }
}
