<?php

namespace Tests\Feature\AdminLte;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectsTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_from_the_projects_index(): void
    {
        $this->get(route('adminlte.projects.index'))
            ->assertRedirect(route('login'));
    }

    public function test_an_authenticated_user_can_view_the_projects_index(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('adminlte.projects.index'))
            ->assertOk();
    }

    public function test_an_authenticated_user_can_create_a_project(): void
    {
        $this->actingAs(User::factory()->create())
            ->post(route('adminlte.projects.store'), [
                'name' => 'New Project',
                'description' => 'A short description.',
                'status' => 'active',
                'progress' => 40,
                'due_date' => now()->addMonth()->toDateString(),
            ])
            ->assertRedirect(route('adminlte.projects.index'));

        $this->assertDatabaseHas('adminlte_projects', [
            'name' => 'New Project',
            'status' => 'active',
            'progress' => 40,
        ]);
    }

    public function test_an_authenticated_user_can_update_a_project(): void
    {
        $project = Project::factory()->create(['name' => 'Old Name']);

        $this->actingAs(User::factory()->create())
            ->put(route('adminlte.projects.update', $project), [
                'name' => 'Updated Name',
                'description' => 'Updated description.',
                'status' => 'completed',
                'progress' => 100,
                'due_date' => now()->addMonth()->toDateString(),
            ])
            ->assertRedirect(route('adminlte.projects.index'));

        $this->assertDatabaseHas('adminlte_projects', [
            'id' => $project->id,
            'name' => 'Updated Name',
            'status' => 'completed',
            'progress' => 100,
        ]);
    }

    public function test_an_authenticated_user_can_delete_a_project(): void
    {
        $project = Project::factory()->create();

        $this->actingAs(User::factory()->create())
            ->delete(route('adminlte.projects.destroy', $project))
            ->assertRedirect(route('adminlte.projects.index'));

        $this->assertDatabaseMissing('adminlte_projects', [
            'id' => $project->id,
        ]);
    }
}
