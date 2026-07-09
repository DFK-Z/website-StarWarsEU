<?php

namespace App\Http\Controllers;

use App\Models\Timeline;
use App\Models\Character;
use App\Models\Planet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TimelineController extends Controller
{
    /**
     * Список событий с фильтрацией
     */
    public function index(Request $request)
    {
        $query = Timeline::query();

        if ($request->has('type') && $request->type != 'all') {
            $query->where('type', $request->type);
        }

        $timelines = $query->orderBy('year')->paginate(15);
        $selectedType = $request->get('type', 'all');

        return view('timeline.index', compact('timelines', 'selectedType'));
    }

    /**
     * Страница события
     */
    public function show(Timeline $timeline)
    {
        return view('timeline.show', compact('timeline'));
    }

    /**
     * Форма создания
     */
    public function create()
    {
        $characters = Character::orderBy('name')->get();
        $planets = Planet::orderBy('name')->get();
        return view('timeline.create', compact('characters', 'planets'));
    }

    /**
     * Сохранение
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'year' => 'required|numeric|min:-10000|max:10000',
            'type' => 'required|in:novel,comic,game,movie,general',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'description' => 'nullable|string',
            'character_id' => 'nullable|exists:characters,id',
            'planet_id' => 'nullable|exists:planets,id',
        ]);

        $data = $request->except('image');
        $data['slug'] = Timeline::generateSlug($request->title);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('timelines', 'public');
        }

        Timeline::create($data);

        return redirect()->route('timeline.index')
            ->with('success', 'Событие "' . $request->title . '" успешно создано!');
    }

    /**
     * Форма редактирования
     */
    public function edit(Timeline $timeline)
    {
        $characters = Character::orderBy('name')->get();
        $planets = Planet::orderBy('name')->get();
        return view('timeline.edit', compact('timeline', 'characters', 'planets'));
    }

    /**
     * Обновление
     */
    public function update(Request $request, Timeline $timeline)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'year' => 'required|numeric|min:-10000|max:10000',
            'type' => 'required|in:novel,comic,game,movie,general',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'description' => 'nullable|string',
            'character_id' => 'nullable|exists:characters,id',
            'planet_id' => 'nullable|exists:planets,id',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            if ($timeline->image) {
                Storage::disk('public')->delete($timeline->image);
            }
            $data['image'] = $request->file('image')->store('timelines', 'public');
        }

        $timeline->update($data);

        return redirect()->route('timeline.index')
            ->with('success', 'Событие "' . $request->title . '" успешно обновлено!');
    }

    /**
     * Удаление
     */
    public function destroy(Timeline $timeline)
    {
        if ($timeline->image) {
            Storage::disk('public')->delete($timeline->image);
        }
        $timeline->delete();

        return redirect()->route('timeline.index')
            ->with('success', 'Событие успешно удалено!');
    }
}
