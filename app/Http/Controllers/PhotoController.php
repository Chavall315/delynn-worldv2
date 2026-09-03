<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Services\SupabaseStorageService;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    protected SupabaseStorageService $storage;

    public function __construct(SupabaseStorageService $storage)
    {
        $this->storage = $storage;
    }

    public function gallery()
    {
        $photos = Photo::where('status', 'approved')->latest()->get();
        return view('gallery', compact('photos'));
    }

    public function index()
    {
        $pending = Photo::where('status', 'pending')->latest()->get();
        $approved = Photo::where('status', 'approved')->latest()->get();
        return view('admin.photos.index', compact('pending', 'approved'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|max:5120',
            'caption' => 'nullable|string|max:255',
        ]);

        $result = $this->storage->upload($request->file('photo'));

        Photo::create([
            'url' => $result['url'],
            'path' => $result['path'],
            'caption' => $request->caption,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Foto berhasil dikirim, menunggu approval admin!');
    }

    public function approve(Photo $photo)
    {
        $photo->update(['status' => 'approved']);
        return back()->with('success', 'Foto disetujui!');
    }

    public function reject(Photo $photo)
    {
        $this->storage->delete($photo->path);
        $photo->delete();
        return back()->with('success', 'Foto ditolak & dihapus!');
    }

    public function destroy(Photo $photo)
    {
        $this->storage->delete($photo->path);
        $photo->delete();
        return back()->with('success', 'Foto dihapus!');
    }
}