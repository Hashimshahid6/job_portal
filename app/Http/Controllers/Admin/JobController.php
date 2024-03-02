<?php

namespace App\Http\Controllers\Admin;
use App\Models\Job;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function adminJobs(){
        $jobs = Job::orderBy('created_at', 'desc')->with('user')->paginate(10);
        return view('admin.jobs.list', compact('jobs'));
    }
}
