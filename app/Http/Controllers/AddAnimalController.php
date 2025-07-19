<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Animal;
use App\Models\Cage;

class AddAnimalController extends Controller
{
    public function show()
    {
        $cages = Cage::withCount('animals')->get();
        return view('addBox', compact('cages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'species' => 'required|string',
            'name' => 'required|string',
            'age' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'cage_id' => 'required|integer|exists:cages,id',
            'image' => 'required|image|max:1024',
        ]);
        $cage = Cage::withCount('animals')->find($request->cage_id);
        if ($cage->animals_count >= $cage->capacity) {
            return back()->withErrors(['cage_id' => 'В выбранной клетке нет свободных мест.'])->withInput();
        }
        $path = $request->file('image')->store('img', 'public');
        Animal::create([
            'species' => $request->species,
            'name' => $request->name,
            'age' => $request->age,
            'description' => $request->description,
            'cage_id' => $request->cage_id,
            'image' => 'storage/' . $path,
        ]);
        return back()->with('success', 'Животное успешно добавлено!');
    }
} 