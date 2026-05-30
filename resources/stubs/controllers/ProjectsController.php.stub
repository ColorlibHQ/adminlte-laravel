<?php

namespace App\Http\Controllers\AdminLte;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Requests\AdminLte\StoreProjectRequest;
use App\Http\Requests\AdminLte\UpdateProjectRequest;
use App\Models\Project;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ProjectsController extends Controller
{
    use AuthorizesRequests;

    public function index(): View
    {
        $this->authorize('viewAny', Project::class);

        $projects = Project::latest()->paginate(12);

        return view('adminlte.projects.index', compact('projects'));
    }

    public function store(StoreProjectRequest $request): RedirectResponse
    {
        $this->authorize('create', Project::class);

        Project::create($request->validated());

        return redirect()->route('adminlte.projects.index')
            ->with('status', __('adminlte.project_created'));
    }

    public function update(UpdateProjectRequest $request, Project $project): RedirectResponse
    {
        $this->authorize('update', $project);

        $project->update($request->validated());

        return redirect()->route('adminlte.projects.index')
            ->with('status', __('adminlte.project_updated'));
    }

    public function destroy(Project $project): RedirectResponse
    {
        $this->authorize('delete', $project);

        $project->delete();

        return redirect()->route('adminlte.projects.index')
            ->with('status', __('adminlte.project_deleted'));
    }
}
