<?php

namespace App\Http\Controllers;

use App\Models\Timeline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TimelineController extends Controller
{
    /**
     * Список всех событий с фильтрацией
     */
    public function index(Request $request)
    {
        $query = Timeline::orderBy('year');

        // Фильтрация по типу
        if ($request->has('type') && $request->type != 'all') {
            $query->where('type', $request->type);
        }

        $timeline = $query->get();

        // Группируем по годам для отображения
        $grouped = $timeline->groupBy('year');

        // Получаем список всех типов для фильтра
        $types = [
            'all' => 'Все',
            'novel' => '📖 Романы',
            'comic' => '📚 Комиксы',
            'movie' => '🎬 Фильмы',
            'game' => '🎮 Игры',
            'event' => '⚔️ События',
        ];

        $currentType = $request->get('type', 'all');

        return view('timeline.index', compact('grouped', 'types', 'currentType'));
    }

    /**
     * Страница одного события
     */
    public function show(Timeline $timeline)
    {
        return view('timeline.show', compact('timeline'));
    }

    /**
     * Форма создания (только для админа)
     */
    public function create()
    {
        return view('timeline.create');
    }

    /**
     * Сохранение
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'year' => 'required|integer|min:-10000|max:10000',
            'type' => 'required|in:novel,comic,movie,game,event',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = $request->except(['image']);
        $data['slug'] = Timeline::generateSlug($request->title);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('timeline', 'public');
            $data['image'] = $path;
        }

        Timeline::create($data);

        return redirect()->route('timeline.index')
            ->with('success', 'Событие "' . $request->title . '" успешно создано!');
    }

    /**
     * Форма редактирования (только для админа)
     */
    public function edit(Timeline $timeline)
    {
        return view('timeline.edit', compact('timeline'));
    }

    /**
     * Обновление
     */
    public function update(Request $request, Timeline $timeline)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'year' => 'required|integer|min:-10000|max:10000',
            'type' => 'required|in:novel,comic,movie,game,event',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = $request->except(['image']);

        if ($request->hasFile('image')) {
            if ($timeline->image) {
                Storage::disk('public')->delete($timeline->image);
            }
            $path = $request->file('image')->store('timeline', 'public');
            $data['image'] = $path;
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
