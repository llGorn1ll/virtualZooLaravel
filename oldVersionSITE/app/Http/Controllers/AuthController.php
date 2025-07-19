<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
        ]);
        $user = User::where('login', $request->login)->first();
        if ($user) {
            Session::put('user.id', $user->id);
            return redirect('index.php');
        } else {
            return back()->withErrors(['login' => 'Пользователь не найден!'])->withInput();
        }
    }

    public function logout()
    {
        Session::forget('user.id');
        return redirect('login.php');
    }
} 