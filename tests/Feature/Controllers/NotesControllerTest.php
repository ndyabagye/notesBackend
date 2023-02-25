<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Notes;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NotesControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_all_notes(): void
    {
        $allNotes = Notes::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('all-notes.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.all_notes.index')
            ->assertViewHas('allNotes');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_notes(): void
    {
        $response = $this->get(route('all-notes.create'));

        $response->assertOk()->assertViewIs('app.all_notes.create');
    }

    /**
     * @test
     */
    public function it_stores_the_notes(): void
    {
        $data = Notes::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('all-notes.store'), $data);

        $this->assertDatabaseHas('notes', $data);

        $notes = Notes::latest('id')->first();

        $response->assertRedirect(route('all-notes.edit', $notes));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_notes(): void
    {
        $notes = Notes::factory()->create();

        $response = $this->get(route('all-notes.show', $notes));

        $response
            ->assertOk()
            ->assertViewIs('app.all_notes.show')
            ->assertViewHas('notes');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_notes(): void
    {
        $notes = Notes::factory()->create();

        $response = $this->get(route('all-notes.edit', $notes));

        $response
            ->assertOk()
            ->assertViewIs('app.all_notes.edit')
            ->assertViewHas('notes');
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

        $response = $this->put(route('all-notes.update', $notes), $data);

        $data['id'] = $notes->id;

        $this->assertDatabaseHas('notes', $data);

        $response->assertRedirect(route('all-notes.edit', $notes));
    }

    /**
     * @test
     */
    public function it_deletes_the_notes(): void
    {
        $notes = Notes::factory()->create();

        $response = $this->delete(route('all-notes.destroy', $notes));

        $response->assertRedirect(route('all-notes.index'));

        $this->assertModelMissing($notes);
    }
}
