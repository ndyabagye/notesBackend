<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Tags;
use App\Models\Notes;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NotesAllTagsTest extends TestCase
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
    public function it_gets_notes_all_tags(): void
    {
        $notes = Notes::factory()->create();
        $tags = Tags::factory()->create();

        $notes->allTags()->attach($tags);

        $response = $this->getJson(
            route('api.all-notes.all-tags.index', $notes)
        );

        $response->assertOk()->assertSee($tags->title);
    }

    /**
     * @test
     */
    public function it_can_attach_all_tags_to_notes(): void
    {
        $notes = Notes::factory()->create();
        $tags = Tags::factory()->create();

        $response = $this->postJson(
            route('api.all-notes.all-tags.store', [$notes, $tags])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $notes
                ->allTags()
                ->where('tags.id', $tags->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_all_tags_from_notes(): void
    {
        $notes = Notes::factory()->create();
        $tags = Tags::factory()->create();

        $response = $this->deleteJson(
            route('api.all-notes.all-tags.store', [$notes, $tags])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $notes
                ->allTags()
                ->where('tags.id', $tags->id)
                ->exists()
        );
    }
}
