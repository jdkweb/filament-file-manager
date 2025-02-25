<?php

namespace Jdkweb\FilamentFileManager\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Jdkweb\FilamentFileManager\Http\Resources\FolderResource;
use Jdkweb\FilamentFileManager\Http\Resources\FoldersResource;
use Jdkweb\FilamentFileManager\Http\Resources\MediaResource;
use Jdkweb\FilamentFileManager\Models\Folder;

class FolderController extends Controller
{
    public function index(Request $request)
    {
        $folders = config('filament-file-manager.model.folder')::query();

        if ($request->has('search')) {
            $folders->where('name', 'like', '%'.$request->search.'%');
        }

        return response()->json([
            'data' => config('filament-file-manager.api.resources.folders')::collection($folders->paginate(10))
        ], 200);
    }

    public function show(int $id)
    {
        $folder = Folder::query()->findOrFail($id);

        return response()->json([
            'data' => config('filament-file-manager.api.resources.folder')::make($folder)
        ], 200);
    }
}
