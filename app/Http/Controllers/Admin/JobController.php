<?php

namespace App\Http\Controllers\Admin;
use App\Models\Job;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\JobType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JobController extends Controller
{
    public function adminJobs(){
        $jobs = Job::orderBy('created_at', 'desc')->with('user')->paginate(10);
        return view('admin.jobs.list', compact('jobs'));
    }//

    public function edit($id){
        $job = Job::findorFail($id);
        $categories = Category::orderBy('name', 'ASC')->get();
        $jobTypes = JobType::orderBy('name', 'ASC')->get();
        return view('admin.jobs.edit', compact('job', 'categories', 'jobTypes'));
    }//

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:5|max:255',
            'category' => 'required',
            'jobType' => 'required',
            'vacancy' => 'required|integer',
            'salary' => 'required|integer',
            'location' => 'required|min:4|max:255',
            'description' => 'required|min:5|max:25000',
            'benefits' => 'required|min:5|max:25000',
            'responsibility' => 'required|min:5|max:25000',
            'qualifications' => 'required|min:5|max:25000',
            'keywords' => 'required|min:5|max:255',
            'experience' => 'required',
            'company_name' => 'required|min:4|max:255',
            'company_location' => 'required|min:5|max:255',
            'company_website' => 'required|min:5|max:255',
        ]);

        if ($validator->passes()) {
            $job = Job::find($id);
            $job->title = $request->title;
            $job->category_id = $request->category;
            $job->job_type_id = $request->jobType;
            $job->vacancy = $request->vacancy;
            $job->salary = $request->salary;
            $job->location = $request->location;
            $job->description = $request->description;
            $job->benefits = $request->benefits;
            $job->responsibility = $request->responsibility;
            $job->qualifications = $request->qualifications;
            $job->keywords = $request->keywords;
            $job->experience = $request->experience;
            $job->company_name = $request->company_name;
            $job->company_location = $request->company_location;
            $job->company_website = $request->company_website;
            // $job->status = $request->status;
            // $job->isFeatured = (!empty($request->isFeatured)) ? $request->isFeatured : 0;
            $job->save();

            session()->flash('success','Job updated successfully.');
            return response()->json([
                'status' => true,
                'errors' => [],
            ]);
        } 
        else 
        {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }
    }//end of updateJob
}
