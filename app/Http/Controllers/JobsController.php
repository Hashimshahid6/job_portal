<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Job;
use App\Models\JobType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\JobApplication;
use App\Models\SavedJob;
class JobsController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::where('status', 1)->get();
        $jobTypes = JobType::where('status', 1)->get();
        $jobs = Job::where('status', 1);

        //Search Using Keywords and Title
        if(!empty($request->keywords)){
            $jobs=$jobs->where(function($query) use ($request){
                $query->where('title', 'LIKE', '%'.$request->keywords.'%')
                ->orWhere('keywords', 'LIKE', '%'.$request->keywords.'%');
            });
        }//

        //Search Using Location
        if(!empty($request->location)){
            $jobs=$jobs->where('location', 'LIKE', '%'.$request->location.'%');
        }//

        //Search Using Category
        if(!empty($request->category)){
            $jobs=$jobs->where('category_id', $request->category);
        }//

        //Search Using Job Type
        $jobTypeArray = [];
        if(!empty($request->job_type)){
            $jobTypeArray = explode(',', $request->job_type);
            $jobs=$jobs->whereIn('job_type_id', $jobTypeArray);
        }//

        //Search Using Experience
        if(!empty($request->experience)){
            $jobs=$jobs->where('experience', $request->experience);
        }//
        $jobs=$jobs->with(['jobType','category']);
        //Sort Latest or Oldest
        
        if($request->sort == '1'){
            $jobs=$jobs->orderBy('created_at', 'DESC');
        }else{
            $jobs=$jobs->orderBy('created_at', 'ASC');
        }
        
        $jobs = $jobs->paginate(9);

        return view('front.jobs',[
            'jobs' => $jobs,
            'categories' => $categories,
            'jobTypes' => $jobTypes,
            'jobTypeArray' => $jobTypeArray,
        ]);
    }//

    public function jobDetails($id)
    {
        $job = Job::where(['id' => $id, 'status' => 1])->with(['jobType','category'])->first();
        if(!$job)
        {
            return abort(404);
        }
        $count = 0;
        if (Auth::user()) {
            $count = SavedJob::where([
                'user_id' => Auth::user()->id,
                'job_id' => $id
            ])->count();
        }
        
        // fetch applicants
        $applications = JobApplication::where('job_id',$id)->with('user')->get();

        return view('front.jobdetails',[
            'job' => $job,
            'count' => $count,
            'applicants' => $applications
        ]);
    }//

    public function applyJob(Request $request){
        $id = $request->id;
        
        $job = Job::where('id',$id)->first();
        // If job not found in db
        if ($job == null) {
            $message = 'Job does not exist.';
            session()->flash('error',$message);
            return response()->json([
                'status' => false,
                'message' => $message
            ]);
        }

        //you can not apply on your own job
        $employer_id = $job->user_id;
        if($employer_id == Auth::user()->id){
            session()->flash('error', 'You can not apply on your own job');
            return response()->json(['status' => false, 'message' => 'You can not apply on your own job']);
        }//

        // Check if already applied
        $applied = JobApplication::where('job_id', $id)->where('user_id', Auth::user()->id)->count();
        if($applied > 0){
            session()->flash('error', 'You have already applied for this job');
            return response()->json(['status' => false, 'message' => 'You have already applied for this job']);
        }//

        $application = new JobApplication();
        $application->job_id = $id;
        $application->user_id = Auth::user()->id;
        $application->employer_id = $employer_id;
        $application->applied_date = now();
        $application->save();
        session()->flash('success', 'Job applied successfully');
        return response()->json(['status' => true, 'message' => 'Job applied successfully']);
        // //Send Email to Employer for Job Application
        // $employer = User::where('id', $employer_id)->first();
        // $mailData = [
        //     'employer' => $employer,
        //     'job' => $job,
        //     'user' => Auth::user(),
        // ];
        // Mail::to($employer->email)->send(new JobNotificationEmail($mailData));
        // if(Mail::failsures()){
        //     session()->flash('error', 'Failed to send email');
        //     return response()->json(['status' => false, 'message' => 'Failed to send email']);
        // }
        // End Send Email to Employer for Job Application
    }//

    public function saveJob(Request $request) {

        $id = $request->id;

        $job = Job::find($id);

        if ($job == null) {
            session()->flash('error','Job not found');

            return response()->json([
                'status' => false,
            ]);
        }

        // Check if user already saved the job
        $count = SavedJob::where([
            'user_id' => Auth::user()->id,
            'job_id' => $id
        ])->count();

        if ($count > 0) {
            session()->flash('error','You already saved this job.');

            return response()->json([
                'status' => false,
            ]);
        }

        $savedJob = new SavedJob;
        $savedJob->job_id = $id;
        $savedJob->user_id = Auth::user()->id;
        $savedJob->save();

        session()->flash('success','You have successfully saved the job.');

        return response()->json([
            'status' => true,
        ]);

    }
}
