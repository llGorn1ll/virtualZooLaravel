<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Animal;
use Illuminate\Support\Facades\Session;

class AnimalController extends Controller
{
    public function show(Request $request)
    {
        $animal_id = $request->query('id');
        $animal = Animal::find($animal_id);
        if (!$animal) {
            return response('<p>Животное не найдено.</p>', 404);
        }
        return view('animal', compact('animal'));
    }

    public function update(Request $request)
    {
        $animal_id = $request->query('id');
        $animal = Animal::find($animal_id);
        $request->validate([
            'species' => 'required|string',
            'name' => 'required|string',
            'age' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:1024',
        ]);
        $animal->species = $request->species;
        $animal->name = $request->name;
        $animal->age = $request->age;
        $animal->description = $request->description;
        if ($request->hasFile('image')) {
            if ($animal->image && file_exists(public_path($animal->image))) {
                @unlink(public_path($animal->image));
            }
            $path = $request->file('image')->store('img', 'public');
            $animal->image = 'storage/' . $path;
        }
        $animal->save();
        return redirect('animal.php?id=' . $animal_id)->with('edit_success', 'Информация о животном обновлена!');
    }

    public function delete(Request $request)
    {
        $animal_id = $request->query('id');
        $animal = Animal::find($animal_id);
        $cage_id = $animal->cage_id;
        if ($animal->image && file_exists(public_path($animal->image))) {
            @unlink(public_path($animal->image));
        }
        $animal->delete();
        return redirect('cage.php?id=' . $cage_id);
    }
} 