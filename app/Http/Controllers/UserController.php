<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the source.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users=User::where('role','!=',1)->get()->load('cravings','userSaving');

        if(\Request::route()->getName()=='user_details.index')
            return view('user_details.index')->with('users',$users);
        else  
            return view('users.index')->with('users',$users);

    }

    /**
     * Show the form for creating a new source.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created source in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
    }

    /**
     * Display the specified source.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        if(\Request::route()->getName()=='user_details.index')
            return view('user_details.show')->with('user',$user);  
        else  
            return view('users.show')->with('user',$user);               
    }

    /**
     * Show the form for editing the specified source.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {

    }

    /**
     * Update the specified source in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        
    }

    /**
     * Remove the specified source from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {


        $user->delete();
        if(\Request::route()->getName()=='user_details.index')
            return redirect()->route('user_details.index')
                ->with('success_message','User deleted successfully');  
        else  
            return redirect()->route('users.index')
                ->with('success_message','User deleted successfully');
    }

    /**
     * update status of particular source.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */

    public function updateStatus(Request $request)
    {
        $user=User::where('id',$request->id)->first();
        if(is_object($user)){
            $user->update([
                'status'=>$request->status=="false" ? 0 : 1
            ]);
            return "success";
        }
        else
            return "failed";
    } 
     
}
