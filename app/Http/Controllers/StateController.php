<?php

namespace App\Http\Controllers;


class StateController extends Controller
{

    /**
     * Display a listing of the subjects.
     *
     * @return Illuminate\View\View 
     */
    public function index()
    {

      
    }
    public function create()
    {
       
    }
    public function store(Request $request)
    {
         
    }
    public function edit($id)
    {

    }


    public function show($slug)
    {
        $storagePath = 'uploaded_images/'. $slug;
        return Image::make($storagePath)->response();
    }
    
    /**
     * Show the form for creating a new subject.
     *
     * @return Illuminate\View\View
     */
    public function destroy($id)
    {

       
    }


    

}
