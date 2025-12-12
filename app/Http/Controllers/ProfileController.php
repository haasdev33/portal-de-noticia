<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show()
    {
        $user = auth()->user();
        return view('profile.show', compact('user'));
    }

    public function edit()
    {
        $user = auth()->user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'current_password' => 'nullable|current_password',
            'password' => 'nullable|confirmed|min:8',
        ]);

        // Only update password if provided
        if ($request->filled('password')) {
            if (!$request->filled('current_password')) {
                return back()->withErrors(['current_password' => 'Insira sua senha atual para alterar a senha.']);
            }
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        unset($data['current_password']);

        $user->update($data);

        return redirect()->route('profile.show')->with('success', 'Perfil atualizado com sucesso!');
    }

    public function destroy()
    {
        $user = auth()->user();
        $user->delete();

        return redirect('/')->with('success', 'Conta deletada com sucesso.');
    }
}
