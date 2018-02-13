<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return View|RedirectResponse
     */
    public function index()
    {
        $user = Auth::user();
        if (!$user->is_controller) {
            return redirect('/home');
        }
        return view('users.index', ['users' => User::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  UserStoreRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserStoreRequest $request): RedirectResponse
    {
        try {
            User::create([
                'cyber_code' => $request->cyber_code,
                'first_name' =>  $request->first_name,
                'middle_name' => $request->middle_name,
                'last_name' => $request->last_name,
                'date_of_birth' => $request->date_of_birth,
                'place_of_birth' => $request->place_of_birth,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);
        } catch (\Exception $e) {
            return redirect()
                ->route('users.create')->withInput()->withErrors([$e->getMessage()]);
        }
        // todo notification
        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return View
     */
    public function show(User $user): View
    {
        return view('users.show', ['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return View|RedirectResponse
     */
    public function edit(User $user)
    {
        $authUser = Auth::user();
        if (!$authUser->is_controller && $authUser->id !== $user->id) {
            return redirect('/home');
        }
        return view('users.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UserUpdateRequest  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserUpdateRequest $request, User $user): RedirectResponse
    {
        $authUser = Auth::user();
        if (!$authUser->is_controller && $authUser->id !== $user->id) {
            return redirect('/home');
        }
        try {
            $user->cyber_code = $request->cyber_code;
            $user->first_name =  $request->first_name;
            $user->middle_name = $request->middle_name;
            $user->last_name = $request->last_name;
            $user->date_of_birth = $request->date_of_birth;
            $user->place_of_birth = $request->place_of_birth;
            $user->email = $request->email;
            $user->save();
        } catch (\Exception $e) {
            return redirect()
                ->route('users.edit', ['cyber_code' => $user->cyber_code])->withInput()->withErrors([$e->getMessage()]);
        }

        // todo notification
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user): RedirectResponse
    {
        $authUser = Auth::user();
        if (!$authUser->is_controller && $authUser->id !== $user->id) {
            return redirect('/home');
        }
        try {
            // TODO make delete recursive
              $user->delete();
        } catch (\Exception $e) {
            return redirect()
                ->route('users.edit', ['cyber_code' => $user->cyber_code])->withInput()->withErrors([$e->getMessage()]);
        }

        // todo notification
        return redirect()->route('users.index');
    }
}
