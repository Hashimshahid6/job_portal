<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobApplication;

class JobApplicationController extends Controller
{
    public function index(){
        $applications = JobApplication::orderBy('created_at', 'desc')->with('job', 'user', 'employer')->paginate(10);
        return view('admin.jobApplications.list', compact('applications'));
    }
}
