<?php

namespace App\Http\Controllers;

use App\Models\CronJob;
use Illuminate\Http\Request;
use App\Models\Schedule;

class CronJobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cron_jobs.index')->with('cron_jobs',CronJob::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cron_jobs.create')->with('schedules',Schedule::Status()->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cron_job=CronJob::firstOrCreate([
            'task'=>ucwords(strtolower($request->task)),
            'schedule_id'=>ucwords(strtolower($request->schedule_id)),
            'description'=>ucwords(strtolower($request->description)),
            'status'=>$request->status
        ]);

        return redirect()->route('cron_jobs.index')
                ->with('success_message','CronJob added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CronJob  $cron_job
     * @return \Illuminate\Http\Response
     */
    public function show(CronJob $cron_job)
    {
        return view('cron_jobs.show')->with('cron_job',$cron_job);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CronJob  $cron_job
     * @return \Illuminate\Http\Response
     */
    public function edit(CronJob $cron_job)
    {
        return view('cron_jobs.create')->with('cron_job',$cron_job)->with('schedules',Schedule::Status()->get());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CronJob  $cron_job
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CronJob $cron_job)
    {
        $cron_job->update([
            'task'=>ucwords(strtolower($request->task)),
            'schedule_id'=>ucwords(strtolower($request->schedule_id)),
            'description'=>ucwords(strtolower($request->description)),
            'status'=>$request->status
        ]);
       
        return redirect()->route('cron_jobs.index')
                ->with('success_message','CronJob updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CronJob  $cron_job
     * @return \Illuminate\Http\Response
     */
    public function destroy(CronJob $cron_job)
    {
        $cron_job->delete();
        return redirect()->route('cron_jobs.index')
                ->with('success_message','CronJob deleted successfully');
    }
     /**
     * update status of particular resource.
     *
     * @param  \App\CronJob  $cron_job
     * @return \Illuminate\Http\Response
     */

    public function updateStatus(Request $request)
    {
        $cron_job=CronJob::where('id',$request->id)->first();
        if(is_object($cron_job)){
            $cron_job->update([
                'status'=>$request->status=="false" ? 0 : 1
            ]);
            return "success";
        }
        else
            return "failed";
    } 
      /**
     * Check Exist 
     *
     * @param  \App\CronJob  $cron_job
     * @return \Illuminate\Http\Response
     */
    public function checkExist(Request $request)
    {  
        return CronJob::where([
                'task'=>$request->task,
            ])->where('id','!=',$request->id ? $request->id : 0)->count() != 0 
        ? 'false' 
        : 'true';
    }
}
