<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use App\Models\JobType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Hash;
use Auth;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\File;
use App\Models\Category;
use App\Models\Job;
use App\Models\SavedJob;

class AccountController extends Controller
{
    public function registration()
    {
        return view('front.account.registration');
    }

    public function processRegistration(Request $request)
    {
        // Process registration
        $validatedData = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|unique:users|max:255',
            'password' => 'required|min:8',
            'confirm_password' => 'required|min:8|same:password', // Custom validation rule for confirming passwords
        ]);

        if ($validatedData->passes()) {
            // Save user
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password); // Password should be hashed
            $user->confirm_password = Hash::make($request->confirm_password); // Password should be hashed
            $user->save();

            session()->flash('success', 'User created successfully');

            return response()->json([
                'status' => true,
                'message' => 'User created successfully',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validatedData->errors(),
            ]);
        }
    }

    public function login()
    {
        return view('front.account.login');
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('home');
    }
    public function authenticate(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validate->passes()) {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                return redirect()->route('account.profile')->with('success', 'Logged in successfully');
            } else {
                return redirect()->route('account.login')->with('error', 'Invalid email or password')->withInput($request->only('email'));
            }

        } else {
            return redirect()->route('account.login')->withErrors($validate)->withInput($request->only('email'));
        }
    }
    public function profile(){
        $id = Auth::User()->id;
        $user = User::find($id);
        return view('front.account.profile', compact('user'));
    }
    public function updateProfile(Request $request)
    {
        $id = Auth::user()->id;
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,'.$id.',id|max:255',
        ]);

        if ($validator->passes()) {
            $user = User::find($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->designation = $request->designation;
            $user->mobile = $request->mobile;
            $user->save();
            session()->flash('success', 'Profile updated successfully');
            return response()->json([
                'status' => true,
                'errors' => [],
            ]);

        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }
    }
    public function updateProfilePicture(Request $request)
    {
        $id = Auth::user()->id;
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($validator->passes()) {
            $image = $request->image;
            $extension = $image->getClientOriginalExtension();
            $imageName = $id . '.' . $extension;
            $image->move(public_path('profile_pic'), $imageName);
            $source_path = public_path('profile_pic/' . $imageName); // Corrected image source path
            $manager = new ImageManager(['driver' => 'gd']);
            $image = $manager->make($source_path);
            $image->fit(150, 150);
            $image->save(public_path('profile_pic/thumb/' . $imageName)); // Corrected thumbnail image path
            File::delete(public_path('profile_pic/' . Auth::user()->image));
            File::delete(public_path('profile_pic/thumb/' . Auth::user()->image));
            User::where('id', $id)->update(['image' => $imageName]);
            session()->flash('success', 'Profile picture updated successfully');
            return response()->json([
                'status' => true,
                'errors' => [],
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }
    }//
    public function createJob(){
        $categories = Category::orderBy('name', 'ASC')->where('status', 1)->get();
        $job_Nature = JobType::orderBy('name', 'ASC')->where('status', 1)->get();
        return view('front.account.job.create_job', compact('categories', 'job_Nature'));
    }//

    public function saveJob(Request $request){
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
            $job = new Job();
            // $job->user_id = Auth::user()->id;
            $job->title = $request->title;
            $job->category_id = $request->category;
            $job->job_type_id = $request->jobType;
            $job->user_id = Auth::user()->id;
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
            $job->save();
            // die;
            return redirect('/account/my-jobs')->with('success', 'Job created successfully');
        } 
        else 
        {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }
    }
    public function myJobs(){
        $jobs = Job::where('user_id', Auth::user()->id)->with('jobType')->orderBy('created_at', 'DESC')->paginate(10);
        return view('front.account.job.myJobs', ['jobs' => $jobs]);
    }

    public function editJob(Request $request, $id){
        $categories = Category::orderBy('name', 'ASC')->where('status', 1)->get();
        $jobTypes = JobType::orderBy('name', 'ASC')->where('status', 1)->get();

        $job = Job::where([
            'id' => $id,
            'user_id' => Auth::user()->id,
        ])->first();
        
        if($job == null){
            return redirect('/account/my-jobs')->with('error', 'Job not found');
        }
        return view('front.account.job.edit_job', [
            'categories' => $categories,
            'jobTypes' => $jobTypes,
            'job' => $job,
        ]);
    }

    public function updateJob(Request $request, $id){
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
            $job->user_id = Auth::user()->id;
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
    }//

    public function deleteJob(Request $request){
        $job = Job::where([
            'user_id' => Auth::user()->id,
            'id' => $request->id
        ])->first();
        
        if($job == null){
            return redirect('/account/my-jobs')->with('error', 'Job not found');
        }
        Job::where('id', $request->id)->delete();
        return redirect('/account/my-jobs')->with('success', 'Job deleted successfully');
    }//
    public function myJobApplications(){
        $jobApplications = JobApplication::where('user_id',Auth::user()->id)->with(['job', 'job.jobType', 'job.applications'])->orderBy('created_at','DESC')->paginate(10);
        return view('front.account.job.myJobApplications',[
            'jobApplications' => $jobApplications
        ]);
    }//
    public function removeJobs(Request $request){
        $jobApplication = JobApplication::where(['id' => $request->id, 'user_id' => Auth::user()->id])->first();
        
        if ($jobApplication == null) {
            session()->flash('error','Job application not found');
            return response()->json([
                'status' => false,                
            ]);
        }

        JobApplication::find($request->id)->delete();
        session()->flash('success','Job application removed successfully.');

        return response()->json([
            'status' => true,                
        ]);
    }//

    public function savedJobs(){
        $savedJobs = SavedJob::where('user_id', Auth::user()->id)->with(['job', 'job.jobType', 'job.applications'])->orderBy('created_at', 'DESC')->paginate(10);
        return view('front.account.job.savedJobs',[
            'savedJobs' => $savedJobs
        ]);
    }//

    public function removeSavedJob(Request $request){
        $savedJob = SavedJob::where(['id' => $request->id, 'user_id' => Auth::user()->id])->first();
        
        if ($savedJob == null) {
            session()->flash('error','Job not found');
            return response()->json([
                'status' => false,                
            ]);
        }

        SavedJob::find($request->id)->delete();
        session()->flash('success','Job removed successfully.');

        return response()->json([
            'status' => true,                
        ]);
    }//
    public function updatePassword(Request $request){
        $validator = Validator::make($request->all(),[
            'old_password' => 'required',
            'new_password' => 'required|min:5',
            'confirm_password' => 'required|same:new_password',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }

        if (Hash::check($request->old_password, Auth::user()->password) == false){
            session()->flash('error','Your old password is incorrect.');
            return response()->json([
                'status' => true                
            ]);
        }
        $user = User::find(Auth::user()->id);
        $user->password = Hash::make($request->new_password);  
        $user->save();

        session()->flash('success','Password updated successfully.');
        return response()->json([
            'status' => true                
        ]);

    }//
}
