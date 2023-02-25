<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Notes;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserAllNotesTest extends TestCase
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
    public function it_gets_user_all_notes(): void
    {
        $user = User::factory()->create();
        $allNotes = Notes::factory()
            ->count(2)
            ->create([
                'user_id' => $user->id,
            ]);

        $response = $this->getJson(route('api.users.all-notes.index', $user));

        $response->assertOk()->assertSee($allNotes[0]->title);
    }

    /**
     * @test
     */
    public function it_stores_the_user_all_notes(): void
    {
        $user = User::factory()->create();
        $data = Notes::factory()
            ->make([
                'user_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.all-notes.store', $user),
            $data
        );

        $this->assertDatabaseHas('notes', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $notes = Notes::latest('id')->first();

        $this->assertEquals($user->id, $notes->user_id);
    }
}
