<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteAccountRequest;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ProfileController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('profile');
    }


    /**
     * Return the authenticated user
     *
     * @return json
     */
    public function fetch()
    {
        $user = Auth::user();

        return response()->json($user);
    }


    /**
     * Return the authenticated user
     *
     * @return JsonResponse
     */
    public function update(ProfileUpdateRequest $request)
    {
        $validated_data = $request->validated();

        $user = Auth::user();
        $user->fill($validated_data)->save();

        return response()->json($user);
    }



    /**
     * Logout and delete the currently authenticated user
     *
     * @return Redirect
     */
    public function delete(DeleteAccountRequest $request)
    {
        $user = Auth::user();

        Auth::logout();

        $user->delete();

        return response()->json([
            'redirect' => route('front_page')
        ]);
    }
}
