<?php

namespace App\Http\Controllers;

use App\Models\Character;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CharacterController extends Controller
{
    /**
     * Список всех персонажей
     */
    public function index()
    {
        $characters = Character::orderBy('name')->paginate(12);
        return view('characters.index', compact('characters'));
    }

    /**
     * Страница одного персонажа
     */
    public function show(Character $character)
    {
        return view('characters.show', compact('character'));
    }

    /**
     * Форма создания персонажа
     */
    public function create()
    {
        return view('characters.create');
    }

    /**
     * Сохранение нового персонажа
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'alias' => 'nullable|string|max:255',
            'lightsaber_color' => 'nullable|string|in:blue,green,red,purple,yellow,orange,white,black,pink,cyan,gold',
            'alias_lightsaber_color' => 'nullable|string|in:blue,green,red,purple,yellow,orange,white,black,pink,cyan,gold',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'planet' => 'nullable|string|max:255',
            'birth_year' => 'nullable|numeric|min:-10000|max:10000',
            'death_year' => 'nullable|numeric|min:-10000|max:10000',
            'race' => 'nullable|string|max:255',
            'gender' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'quotes' => 'nullable|array',
            'quotes.*' => 'nullable|string|max:500',
        ]);

        $data = $request->except(['image', 'quotes']);
        $data['slug'] = Character::generateSlug($request->name);
        $data['quotes'] = array_filter($request->quotes ?? []);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('characters', 'public');
            $data['image'] = $path;
        }

        Character::create($data);

        return redirect()->route('characters.index')
            ->with('success', 'Персонаж "' . $request->name . '" успешно создан!');
    }

    /**
     * Форма редактирования
     */
    public function edit(Character $character)
    {
        return view('characters.edit', compact('character'));
    }

    /**
     * Обновление персонажа
     */
    public function update(Request $request, Character $character)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'alias' => 'nullable|string|max:255',
            'lightsaber_color' => 'nullable|string|in:blue,green,red,purple,yellow,orange,white,black,pink,cyan,gold',
            'alias_lightsaber_color' => 'nullable|string|in:blue,green,red,purple,yellow,orange,white,black,pink,cyan,gold',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'planet' => 'nullable|string|max:255',
            'birth_year' => 'nullable|numeric|min:-10000|max:10000',
            'death_year' => 'nullable|numeric|min:-10000|max:10000',
            'race' => 'nullable|string|max:255',
            'gender' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'quotes' => 'nullable|array',
            'quotes.*' => 'nullable|string|max:500',
        ]);

        $data = $request->except(['image', 'quotes']);
        $data['quotes'] = array_filter($request->quotes ?? []);

        if ($request->hasFile('image')) {
            if ($character->image) {
                Storage::disk('public')->delete($character->image);
            }
            $path = $request->file('image')->store('characters', 'public');
            $data['image'] = $path;
        }

        $character->update($data);

        return redirect()->route('characters.index')
            ->with('success', 'Персонаж "' . $request->name . '" успешно обновлён!');
    }

    /**
     * Удаление персонажа
     */
    public function destroy(Character $character)
    {
        if ($character->image) {
            Storage::disk('public')->delete($character->image);
        }
        $character->delete();

        return redirect()->route('characters.index')
            ->with('success', 'Персонаж успешно удалён!');
    }
}
