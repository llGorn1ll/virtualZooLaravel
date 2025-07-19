<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cage;
use App\Models\Animal;
use Illuminate\Support\Facades\Session;

class CageController extends Controller
{
    public function show(Request $request)
    {
        $cage_id = $request->query('id');
        $cage = Cage::find($cage_id);
        if (!$cage) {
            return response('Клетка не найдена.', 404);
        }
        $animals = $cage->animals;
        return view('cage', compact('cage', 'animals'));
    }

    public function update(Request $request)
    {
        $cage_id = $request->query('id');
        $cage = Cage::find($cage_id);
        $animal_count = $cage->animals()->count();
        $request->validate([
            'new_name' => 'required|string',
            'new_capacity' => 'required|integer|min:' . $animal_count,
        ]);
        $cage->name = $request->new_name;
        $cage->capacity = $request->new_capacity;
        $cage->save();
        return redirect('cage.php?id=' . $cage_id)->with('cage_edit_success', 'Параметры клетки успешно изменены!');
    }

    public function delete(Request $request)
    {
        $cage_id = $request->query('id');
        $cage = Cage::find($cage_id);
        if ($cage->animals()->count() == 0) {
            $cage->delete();
            return redirect('index.php');
        } else {
            return redirect('cage.php?id=' . $cage_id)->with('cage_delete_error', 'Клетка не пуста! Сначала удалите всех животных.');
        }
    }

    public function deleteAnimal(Request $request)
    {
        $cage_id = $request->query('id');
        $animal_id = $request->input('delete_animal_id');
        $animal = Animal::where('id', $animal_id)->where('cage_id', $cage_id)->first();
        if ($animal) {
            if ($animal->image && file_exists(public_path($animal->image))) {
                @unlink(public_path($animal->image));
            }
            $animal->delete();
        }
        return redirect('cage.php?id=' . $cage_id);
    }
} 