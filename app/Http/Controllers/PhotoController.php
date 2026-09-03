<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Services\SupabaseStorageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\View\View;

class PhotoController extends Controller
{
    protected SupabaseStorageService $storage;

    public function __construct(SupabaseStorageService $storage)
    {
        $this->storage = $storage;
    }

    public function gallery(): View
    {
        $photos = Photo::where('status', 'approved')->latest()->get();

        return view('gallery', compact('photos'));
    }

    public function index(): View
    {
        $pending = Photo::where('status', 'pending')->latest()->get();
        $approved = Photo::where('status', 'approved')->latest()->get();

        return view('admin.photos.index', compact('pending', 'approved'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'photo' => 'required|image|max:5120',
            'caption' => 'nullable|string|max:255',
        ]);

        /** @var UploadedFile $photo */
        $photo = $request->file('photo');
        $result = $this->storage->upload($photo);

        Photo::create([
            'url' => $result['url'],
            'path' => $result['path'],
            'caption' => $request->caption,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Foto berhasil dikirim, menunggu approval admin!');
    }

    public function approve(Photo $photo): RedirectResponse
    {
        $photo->update(['status' => 'approved']);

        return back()->with('success', 'Foto disetujui!');
    }

    public function reject(Photo $photo): RedirectResponse
    {
        $this->storage->delete($photo->path);
        $photo->delete();

        return back()->with('success', 'Foto ditolak & dihapus!');
    }

    public function destroy(Photo $photo): RedirectResponse
    {
        $this->storage->delete($photo->path);
        $photo->delete();

        return back()->with('success', 'Foto dihapus!');
    }
}
