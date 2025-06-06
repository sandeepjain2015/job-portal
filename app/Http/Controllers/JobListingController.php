<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controllers\Middleware;
use App\Models\JobListing;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;

class JobListingController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [

            new Middleware('permission:edit jobs', only: ['edit']),
            new Middleware('permission:create jobs', only: ['create', 'store']),
            new Middleware('permission:delete jobs', only: ['destroy']),
            // new Middleware('permission:show jobs', only: ['show']),
            new Middleware('permission:update jobs', only: ['update']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Assuming you have a JobListing model
        $jobListings = JobListing::paginate(10);
        return view('job_listings.index', compact('jobListings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Return the view for creating a new job listing
        return view('job_listings.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // Validate the request data
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'company_name' => 'required|string|max:255',
            'pay_range' => 'nullable|string',
        ]);

        // Create a new job listing
        JobListing::create([
            'title' => $request->title,
            'description' => $request->description,
            'company_name' => $request->company_name,
            'pay_range' => $request->pay_range,
            'user_id' => auth()->id()
        ]);

        return redirect()->route('job-listings.index')->with('success', 'Job listing created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(JobListing $jobListing)
    {
        // Return the view for showing a specific job listing
        return view('job_listings.show', compact('jobListing'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobListing $jobListing)
    {
        // Return the view for editing a specific job listing
        return view('job_listings.edit', compact('jobListing'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JobListing $jobListing)
    {
        // Validate the request data
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'company' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'salary' => 'nullable|numeric',
        ]);

        // Update the job listing
        $jobListing->update([
            'title' => $request->title,
            'description' => $request->description,
            'company' => $request->company,
            'location' => $request->location,
            'salary' => $request->salary,
        ]);

        return redirect()->route('job_listings.index')->with('success', 'Job listing updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobListing $jobListing)
    {
        // Delete the job listing
        $jobListing->delete();

        return redirect()->route('job_listings.index')->with('success', 'Job listing deleted successfully.');
    }
    public function apply(Request $request, JobListing $jobListing)
    {

        $user = auth()->user();
        // dd($user->appliedJobs);
        if ($user->appliedJobs->contains($jobListing->id)) {
            return back()->with('error', 'You have already applied for this job.');
        } else {
            // dd($user->id);
            // dd($jobListing->id);
            $user->appliedJobs()->attach($jobListing->id);
            return back()->with('success', 'Application submitted successfully.');
        }
    }
    public function appliedJobs()
    {
        $user = auth()->user();
        $appliedJobs = $user->appliedJobs()->paginate(10);
        return view('job_listings.applied_jobs', compact('appliedJobs'));
    }
}
