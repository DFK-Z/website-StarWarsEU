<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Models\Timeline;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->get('q');

        if (empty($query)) {
            return redirect('/');
        }

        // Поиск в персонажах
        $characters = Character::where('name', 'LIKE', "%{$query}%")
            ->orWhere('alias', 'LIKE', "%{$query}%")
            ->limit(10)
            ->get();

        // Поиск в хронологии
        $timeline = Timeline::where('title', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->limit(10)
            ->get();

        return view('search.index', compact('query', 'characters', 'timeline'));
    }
}
