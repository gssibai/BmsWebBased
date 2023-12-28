<?php

namespace App\Http\Controllers;
use App\Models\JobTitle;
use Illuminate\Http\Request;

class JobTitleController extends Controller
{
    public function index()
    {
        $jobTitles = JobTitle::all();
        return view('job_titles.index', compact('jobTitles'));
    }
    function validateEntry(Request $request){
        return $request->validate([
            'job_title'=> 'required|string|max:255',
        ]) ;
    }
    public function jobTitleCreate(Request $request){
        JobTitle::create(JobTitleController::validateEntry($request));
        return redirect()->route('job_titles.index')->with('success', 'Job title created successfully!');
    }

    public function jobTitleEdit(Request $request,$jobTitleId){
       $jobTitle= JobTitle::findOrFail($request->$jobTitleId);
        $fields = ['job_title'];
        foreach ($fields as $field) {
            if($request->filled($field)){
                $jobTitle->$field = JobTitleController::validateEntry($request->$field);
            }
        }
        $jobTitle->save();
        return redirect()->route('job_titles.index')->with('success', 'Job title updated successfully!');

    }
    public function destroy($jobTitleId)
    {
        // Check authorization and permissions before deleting
        if (!auth()->user()->can('delete', JobTitle::find($jobTitleId))) {
            return abort(403, 'Unauthorized access.');
        }

        JobTitle::findOrFail($jobTitleId)->delete();
        return redirect()->route('job_titles.index')->with('success', 'Job title deleted successfully!');
    }
}
