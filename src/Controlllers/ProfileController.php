<?php

namespace Larafa\UserProfile\Controllers;

use Illuminate\Support\Facades\Auth;
use Larafa\UserProfile\Profile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user-profile::index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function show(Profile $profile)
    {
        return view('user-profile::show' , compact('profile'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function edit(Profile $profile)
    {
        $user = $profile->user()->first();
        if (Gate::allows('users.update',$user)) {
            return view('user-profile::edit' , compact('profile'));
        }
    }

    public function doEdit()
    {
        $user = Auth::user();
        return redirect('profiles/'.$user->id.'/edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Profile $profile)
    {
        $user = $profile->user()->first();
        if (Gate::allows('users.update',$user)) {
            //TODO validation
        
            if($request->hasFile('profile_pic')){
                
                $path = $request->file('profile_pic')->store('public/profile_pics');
                $request->request->add(['avatar_path'=>$path]);
            }

            $profile->update($request->all());
            return redirect('profiles/' . $profile->id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profile $profile)
    {
        //
    }
}
