<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cage;
use App\Models\Animal;

class HomeController extends Controller
{
    public function index()
    {
        $cages = Cage::all();
        $animal_count = Animal::count();
        return view('index', compact('cages', 'animal_count'));
    }
} 