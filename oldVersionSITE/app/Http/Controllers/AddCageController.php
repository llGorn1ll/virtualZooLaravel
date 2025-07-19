<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cage;

class AddCageController extends Controller
{
    public function show()
    {
        return view('addAnimal');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'cageCapacity' => 'required|integer|min:1',
        ]);
        Cage::create([
            'name' => $request->name,
            'capacity' => $request->cageCapacity,
        ]);
        return back()->with('success', 'Клетка успешно добавлена!');
    }
} 