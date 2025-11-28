<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    public function index()
    {
        $photos = auth()->user()->photos()->paginate(12);
        return view('photos.index', compact('photos'));
    }

    public function create()
    {
        return view('photos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:51200',
        ]);

        $file = $request->file('photo');
        $path = $file->store('photos', 'public');

        Photo::create([
            'name' => $file->hashName(),
            'path' => $path,
            'original_name' => $file->getClientOriginalName(),
            'size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('photos.index')->with('success', 'Foto berhasil diupload!');
    }

    public function show(Photo $photo)
    {
        $this->authorize('view', $photo);
        return view('photos.show', compact('photo'));
    }

    public function destroy(Photo $photo)
    {
        $this->authorize('delete', $photo);

        Storage::disk('public')->delete($photo->path);
        $photo->delete();

        return redirect()->route('photos.index')->with('success', 'Foto berhasil dihapus!');
    }

    public function image($id)
    {
        $photo = Photo::findOrFail($id);
        $this->authorize('view', $photo);

        $file = Storage::disk('public')->get($photo->path);

        return response($file, 200)->header('Content-Type', $photo->mime_type);
    }

    public function download($id)
    {
        $photo = Photo::findOrFail($id);
        $this->authorize('view', $photo);

        $filePath = Storage::disk('public')->path($photo->path);

        return response()->download($filePath, $photo->original_name);
    }
}
