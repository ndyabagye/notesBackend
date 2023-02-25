<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Notes;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NotesTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create(['email' => 'admin@admin.com']);

        Sanctum::actingAs($user, [], 'web');

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_gets_all_notes_list(): void
    {
        $allNotes = Notes::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.all-notes.index'));

        $response->assertOk()->assertSee($allNotes[0]->title);
    }

    /**
     * @test
     */
    public function it_stores_the_notes(): void
    {
        $data = Notes::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.all-notes.store'), $data);

        $this->assertDatabaseHas('notes', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_notes(): void
    {
        $notes = Notes::factory()->create();

        $user = User::factory()->create();

        $data = [
            'user_id' => $this->faker->randomNumber,
            'title' => $this->faker->text(255),
            'description' => $this->faker->text,
            'color' => $this->faker->text(9),
            'user_id' => $user->id,
        ];

        $response = $this->putJson(
            route('api.all-notes.update', $notes),
            $data
        );

        $data['id'] = $notes->id;

        $this->assertDatabaseHas('notes', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_notes(): void
    {
        $notes = Notes::factory()->create();

        $response = $this->deleteJson(route('api.all-notes.destroy', $notes));

        $this->assertModelMissing($notes);

        $response->assertNoContent();
    }
}
