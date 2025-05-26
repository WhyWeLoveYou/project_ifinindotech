<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Users;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = \App\Models\Users::latest()->paginate(10);


        return view('layouts.user.show', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('layouts.user.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama_user' => 'required',
                'alamat' => 'required',
            ]);

            Users::create($request->all());

            return redirect()->route('users.index')->with('success', 'User created successfully.');
        } catch (\Exception $e) {
            Log::error('User Store Error: '.$e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Failed to create user. Please try again.');
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = Users::findOrFail($id);


        return view('layouts.user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $user = Users::findOrFail($id);

            $request->validate([
                'nama_user' => 'required',
                'alamat' => 'required',
            ]);

            $user->update([
                'nama_user' => $request->input('nama_user'),
                'alamat' => $request->input('alamat'),
            ]);

            return redirect()->route('users.index')->with('success', 'User updated successfully.');
        } catch (\Exception $e) {
            Log::error('User Update Error: '.$e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Failed to update user. Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $user = Users::findOrFail($id);
            $user->delete();

            return redirect()->route('users.index')->with('success', 'User deleted successfully.');
        } catch (\Exception $e) {
            Log::error('User Delete Error: '.$e->getMessage());
            return redirect()->back()->with('error', 'Failed to delete user. Please try again.');
        }
    }
}
