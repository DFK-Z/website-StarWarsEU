<?php

namespace App\Http\Controllers;

use App\Models\Timeline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TimelineController extends Controller
{
    /**
     * Список всех событий хронологии
     */
    public function index(Request $request)
    {
        $query = Timeline::query();

        // Фильтрация по типу
        if ($request->has('type') && $request->type != 'all') {
            $query->where('type', $request->type);
        }

        $timeline = $query->orderBy('year_start')->paginate(15);
        $types = ['novel', 'comic', 'movie', 'game', 'other'];
        $selectedType = $request->get('type', 'all');

        return view('chronology.index', compact('timeline', 'types', 'selectedType'));
    }

    /**
     * Страница одного события
     */
    public function show(Timeline $timeline)
    {
        return view('chronology.show', compact('timeline'));
    }

    /**
     * Форма создания
     */
    public function create()
    {
        return view('chronology.create');
    }

    /**
     * Сохранение
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:novel,comic,movie,game,other',
            'year_start' => 'required|numeric|min:-10000|max:10000',
            'year_end' => 'nullable|numeric|min:-10000|max:10000',
            'era' => 'nullable|string|max:255',
            'author' => 'nullable|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = $request->except(['image']);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('chronology', 'public');
            $data['image'] = $path;
        }

        Timeline::create($data);

        return redirect()->route('chronology.index')
            ->with('success', 'Событие "' . $request->title . '" успешно создано!');
    }

    /**
     * Форма редактирования
     */
    public function edit(Timeline $timeline)
    {
        return view('chronology.edit', compact('timeline'));
    }

    /**
     * Обновление
     */
    public function update(Request $request, Timeline $timeline)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:novel,comic,movie,game,other',
            'year_start' => 'required|numeric|min:-10000|max:10000',
            'year_end' => 'nullable|numeric|min:-10000|max:10000',
            'era' => 'nullable|string|max:255',
            'author' => 'nullable|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = $request->except(['image']);

        if ($request->hasFile('image')) {
            if ($timeline->image) {
                Storage::disk('public')->delete($timeline->image);
            }
            $path = $request->file('image')->store('chronology', 'public');
            $data['image'] = $path;
        }

        $timeline->update($data);

        return redirect()->route('chronology.index')
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

        return redirect()->route('chronology.index')
            ->with('success', 'Событие успешно удалено!');
    }
}
