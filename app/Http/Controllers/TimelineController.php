<?php

namespace App\Http\Controllers;

use App\Models\TimelineEvent;
use App\Services\SupabaseStorageService;
use Illuminate\Http\Request;

class TimelineController extends Controller
{
    protected SupabaseStorageService $storage;

    public function __construct(SupabaseStorageService $storage)
    {
        $this->storage = $storage;
    }

    public function timeline()
    {
        $events = TimelineEvent::orderBy('event_date', 'desc')->get();
        return view('timeline', compact('events'));
    }

    public function index()
    {
        $events = TimelineEvent::orderBy('event_date', 'desc')->get();
        return view('admin.timeline.index', compact('events'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_date' => 'required|date',
            'photo' => 'nullable|image|max:5120',
        ]);

        $data = $request->only(['title', 'description', 'event_date']);

        if ($request->hasFile('photo')) {
            $result = $this->storage->upload($request->file('photo'));
            $data['photo_url'] = $result['url'];
            $data['photo_path'] = $result['path'];
        }

        TimelineEvent::create($data);

        return back()->with('success', 'Event berhasil ditambahkan!');
    }

    public function update(Request $request, TimelineEvent $timelineEvent)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_date' => 'required|date',
            'photo' => 'nullable|image|max:5120',
        ]);

        $data = $request->only(['title', 'description', 'event_date']);

        if ($request->hasFile('photo')) {
            if ($timelineEvent->photo_path) {
                $this->storage->delete($timelineEvent->photo_path);
            }
            $result = $this->storage->upload($request->file('photo'));
            $data['photo_url'] = $result['url'];
            $data['photo_path'] = $result['path'];
        }

        $timelineEvent->update($data);

        return back()->with('success', 'Event berhasil diupdate!');
    }

    public function destroy(TimelineEvent $timelineEvent)
    {
        if ($timelineEvent->photo_path) {
            $this->storage->delete($timelineEvent->photo_path);
        }
        $timelineEvent->delete();

        return back()->with('success', 'Event berhasil dihapus!');
    }
}