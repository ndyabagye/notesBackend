<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Tags;
use App\Models\Notes;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TagsAllNotesTest extends TestCase
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
    public function it_gets_tags_all_notes(): void
    {
        $tags = Tags::factory()->create();
        $notes = Notes::factory()->create();

        $tags->allNotes()->attach($notes);

        $response = $this->getJson(
            route('api.all-tags.all-notes.index', $tags)
        );

        $response->assertOk()->assertSee($notes->title);
    }

    /**
     * @test
     */
    public function it_can_attach_all_notes_to_tags(): void
    {
        $tags = Tags::factory()->create();
        $notes = Notes::factory()->create();

        $response = $this->postJson(
            route('api.all-tags.all-notes.store', [$tags, $notes])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $tags
                ->allNotes()
                ->where('notes.id', $notes->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_all_notes_from_tags(): void
    {
        $tags = Tags::factory()->create();
        $notes = Notes::factory()->create();

        $response = $this->deleteJson(
            route('api.all-tags.all-notes.store', [$tags, $notes])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $tags
                ->allNotes()
                ->where('notes.id', $notes->id)
                ->exists()
        );
    }
}
