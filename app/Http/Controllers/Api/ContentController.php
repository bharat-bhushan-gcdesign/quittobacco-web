<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Content;
use Illuminate\Http\Request;
use App\Http\Resources\Content as ContentResource;
use App\User;
use Auth;
use JWTFactory;
use JWTAuth;

class ContentController extends Controller
{
    /**
     * Display a listing of the source.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

   
    }

    /**
     * Show the form for creating a new source.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created source in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified source.
     *
     * @param  \App\Models\Content  $content
     * @return \Illuminate\Http\Response
     */
    public function show(Content $content)
    {
        switch (\Request::route()->getName()) {

        /** about us */
            case 'api.contents.about_us':
                $title='About Us';
                break;

        /** Dealing with difficult situations */
            case 'api.contents.difficult_situation':
                $title='Dealing with difficult situations';
                break;

        /** Nicotine Replacement Therapy */
            case 'api.contents.nicotine_replacement':
                $title='Nicotine Replacement Therapy';
                break;

        /** References */
            case 'api.contents.references':
                $title='References';
                break;


        /** Terms and Condition */
            case 'api.contents.terms_conditions':
                $title='Terms and Condition';
                break;

        /** Privacy Policy */
            case 'api.contents.privacy_policy':
                $title='Privacy Policy';
                break;

        /** Welcome */
            case 'api.contents.welcome':
                $title='Welcome';
                break;

        /** Disclaimer */
            case 'api.contents.disclaimer':
                $title='Disclaimer';
                break;

        /** Your Progress */
            case 'api.contents.your_progress':
                $title='Your Progress';
                break;

        /** Motivation */
            case 'api.contents.motivation':
                $title='Motivation';
                break;

            default:
                $title='No Data Found';
                break;
        }

        $content=Content::where('title',$title)->first();

    /** Return User content data with token */
        return response()->json([
            'status' => 200,
            'data' => $content!=null ? new ContentResource($content) : "No data Found",
            'message' => 'Content Retrieved successfully',
        ]); 
    }

    /**
     * Show the form for editing the specified source.
     *
     * @param  \App\Models\Content  $content
     * @return \Illuminate\Http\Response
     */
    public function edit(Content $content)
    {
        //
    }

    /**
     * Update the specified source in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Content  $content
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Content $content)
    {
        //
    }

    /**
     * Remove the specified source from storage.
     *
     * @param  \App\Models\Content  $content
     * @return \Illuminate\Http\Response
     */
    public function destroy(Content $content)
    {
        //
    }
}
