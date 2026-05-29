<?php

namespace App\Http\Controllers\AdminLte;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileManagerController extends Controller
{
    private string $disk = 'public';

    public function index(Request $request): View
    {
        $path = trim($request->get('path', ''), '/');

        $directories = collect(Storage::disk($this->disk)->directories($path));
        $files = collect(Storage::disk($this->disk)->files($path))
            ->map(fn ($file) => [
                'name' => basename($file),
                'path' => $file,
                'size' => Storage::disk($this->disk)->size($file),
                'modified' => Storage::disk($this->disk)->lastModified($file),
            ]);

        return view('adminlte.file-manager.index', compact('directories', 'files', 'path'));
    }

    public function upload(Request $request): RedirectResponse
    {
        $request->validate([
            'file' => ['required', 'file', 'max:10240'],
            'path' => ['nullable', 'string'],
        ]);

        $request->file('file')->store($request->get('path', ''), $this->disk);

        return back()->with('status', __('adminlte.upload'));
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validate(['path' => ['required', 'string']]);

        Storage::disk($this->disk)->delete($request->get('path'));

        return back()->with('status', __('adminlte.delete_message'));
    }
}
