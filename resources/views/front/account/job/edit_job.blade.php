@extends('front.layouts.app')
@section('main')
<section class="section-5 bg-2">
    <div class="container py-5">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Account Settings</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                @include('front.account.sidebar')
            </div>
            <div class="col-lg-9">
                @include('front.message')
                <form action="" method="post" name="editJobForm" id="editJobForm">
                    @csrf
                    <div class="card border-0 shadow mb-4 ">
                        <div class="card-body card-form p-4">
                            <h3 class="fs-4 mb-1">Job Details</h3>
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="" class="mb-2">Title<span class="req">*</span></label>
                                    <input value="{{$job->title}}" type="text" placeholder="Job Title" id="title" name="title" class="form-control">
                                </div>
                                <div class="col-md-6  mb-4">
                                    <label for="" class="mb-2">Category<span class="req">*</span></label>
                                    <select name="category" id="category" class="form-control">
                                        <option value="">Select a Category</option>
                                        @if($categories != null)
                                        @foreach($categories as $category)
                                        <option {{($job->category_id == $category->id) ? 'selected' : '' }} value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="" class="mb-2">Job Nature<span class="req">*</span></label>
                                    <select class="form-select" name="jobType" id="jobType">
                                        <option value="">Select a Job Nature</option>
                                        @if($jobTypes != null)
                                        @foreach($jobTypes as $jobType)
                                        <option {{($job->job_type_id == $jobType->id) ? 'selected' : ''}} value="{{$jobType->id}}">{{$jobType->name}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-6  mb-4">
                                    <label for="" class="mb-2">Vacancy<span class="req">*</span></label>
                                    <input value="{{$job->vacancy}}" type="number" min="1" placeholder="Vacancy" id="vacancy" name="vacancy" class="form-control">
                                </div>
                            </div>

                            <div class="row">
                                <div class="mb-4 col-md-6">
                                    <label for="" class="mb-2">Salary<span class="req">*</span></label>
                                    <input value="{{$job->salary}}" type="text" placeholder="Salary" id="salary" name="salary" class="form-control">
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label for="" class="mb-2">Location<span class="req">*</span></label>
                                    <input value="{{$job->location}}" type="text" placeholder="Location" id="location" name="location" class="form-control">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="" class="mb-2">Description<span class="req">*</span></label>
                                <textarea class="form-control" name="description" id="description" cols="5" rows="5" placeholder="Description">{{$job->description}}</textarea>
                            </div>
                            <div class="mb-4">
                                <label for="" class="mb-2">Benefits<span class="req">*</span></label>
                                <textarea class="form-control" name="benefits" id="benefits" cols="5" rows="5" placeholder="Benefits">{{$job->benefits}}</textarea>
                            </div>
                            <div class="mb-4">
                                <label for="" class="mb-2">Responsibility<span class="req">*</span></label>
                                <textarea class="form-control" name="responsibility" id="responsibility" cols="5" rows="5" placeholder="Responsibility">{{$job->responsibility}}</textarea>
                            </div>
                            <div class="mb-4">
                                <label for="" class="mb-2">Qualifications<span class="req">*</span></label>
                                <textarea class="form-control" name="qualifications" id="qualifications" cols="5" rows="5" placeholder="Qualifications">{{$job->qualifications}}</textarea>
                            </div>
                            <div class="mb-4">
                                <label for="" class="mb-2">Experience<span class="req">*</span></label>
                                <select id="experience" name="experience" class="form-control">
                                    <option value="">Select Experience</option>
                                    <option value="1" {{($job->experience==1)? "selected": ''}}>1 Years</option>
                                    <option value="2" {{($job->experience==2)? "selected": ''}}>2 Years</option>
                                    <option value="3" {{($job->experience==3)? "selected": ''}}>3 Years</option>
                                    <option value="4" {{($job->experience==4)? "selected": ''}}>4 Years</option>
                                    <option value="5" {{($job->experience==5)? "selected": ''}}>5 Years</option>
                                    <option value="6" {{($job->experience==6)? "selected": ''}}>6 Years</option>
                                    <option value="7" {{($job->experience==7)? "selected": ''}}>7 Years</option>
                                    <option value="8" {{($job->experience==8)? "selected": ''}}>8 Years</option>
                                    <option value="9" {{($job->experience==9) ? "selected": ''}}>9 Years</option>
                                    <option value="10" {{($job->experience==10) ? "selected": ''}}>10 Years</option>
                                    <option value="10+" {{($job->experience=='10+') ? "selected": ''}}>10+ Years</option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label for="" class="mb-2">Keywords<span class="req">*</span></label>
                                <input value="{{$job->keywords}}" type="text" placeholder="keywords" id="keywords" name="keywords" class="form-control">
                            </div>
                            <h3 class="fs-4 mb-1 mt-5 border-top pt-5">Company Details</h3>
                            <div class="row">
                                <div class="mb-4 col-md-6">
                                    <label for="" class="mb-2">Company Name<span class="req">*</span></label>
                                    <input value="{{$job->company_name}}" type="text" placeholder="Company Name" id="company_name" name="company_name" class="form-control">
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label for="" class="mb-2">Company Location<span class="req">*</span></label>
                                    <input value="{{$job->company_location}}" type="text" placeholder="Location" id="company_location" name="company_location" class="form-control">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="" class="mb-2">Company Website<span class="req">*</span></label>
                                <input value="{{$job->company_website}}" type="text" placeholder="Website" id="company_website" name="company_website" class="form-control">
                            </div>
                        </div> 
                        <div class="card-footer  p-4">
                            <button type="submit" class="btn btn-primary">Update Job</button>
                        </div>
                    </div>   
                </form>            
            </div>
        </div>
    </div>
</section>
@endsection

@section('customJS')
<script>
$("#editJobForm").submit(function(e){
    e.preventDefault();
    $("button[type='submit']").prop('disabled', true);
    $.ajax({
        url: '{{ route("account.updateJob", + ' $job->id + ') }}',
        type: 'POST',
        dataType: 'json',
        data: $('#editJobForm').serialize(),
        success: function(response){
        $("button[type='submit']").prop('disabled', false );
            if(response.status == true){
                $('#title').removeClass('is-invalid').
                siblings('p')
                .removeClass('invalid-feedback')
                .html('');

                $('#category').removeClass('is-invalid').
                siblings('p')
                .removeClass('invalid-feedback')
                .html('');

                $('#jobType').removeClass('is-invalid').
                siblings('p')
                .removeClass('invalid-feedback')
                .html('');

                $('#vacancy').removeClass('is-invalid').
                siblings('p')
                .removeClass('invalid-feedback')
                .html('');

                $('#salary').removeClass('is-invalid').
                siblings('p')
                .removeClass('invalid-feedback')
                .html('');

                $('#location').removeClass('is-invalid').
                siblings('p')
                .removeClass('invalid-feedback')
                .html('');

                $('#description').removeClass('is-invalid').
                siblings('p')
                .removeClass('invalid-feedback')
                .html('');

                $('#benefits').removeClass('is-invalid').
                siblings('p')
                .removeClass('invalid-feedback')
                .html('');

                $('#responsibility').removeClass('is-invalid').
                siblings('p')
                .removeClass('invalid-feedback')
                .html('');

                $('#qualifications').removeClass('is-invalid').
                siblings('p')
                .removeClass('invalid-feedback')
                .html('');

                $('#experience').removeClass('is-invalid').
                siblings('p')
                .removeClass('invalid-feedback')
                .html('');

                $('#keywords').removeClass('is-invalid').
                siblings('p')
                .removeClass('invalid-feedback')
                .html('');

                $('#company_name').removeClass('is-invalid').
                siblings('p')
                .removeClass('invalid-feedback')
                .html('');

                $('#company_location').removeClass('is-invalid').
                siblings('p')
                .removeClass('invalid-feedback')
                .html('');

                $('#company_website').removeClass('is-invalid').
                siblings('p')
                .removeClass('invalid-feedback')
                .html('');

            }else{
                if(response.errors.title){
                    $('#title').addClass('is-invalid').
                    siblings('p')
                    .addClass('invalid-feedback')
                    .html(response.errors.title[0]);
                }else{
                    $('#title').removeClass('is-invalid').
                    siblings('p')
                    .removeClass('invalid-feedback')
                    .html('');
                }

                if(response.errors.category){
                    $('#category').addClass('is-invalid').
                    siblings('p')
                    .addClass('invalid-feedback')
                    .html(response.errors.category[0]);
                }else{
                    $('#category').removeClass('is-invalid').
                    siblings('p')
                    .removeClass('invalid-feedback')
                    .html('');
                }

                if(response.errors.jobType){
                    $('#jobType').addClass('is-invalid').
                    siblings('p')
                    .addClass('invalid-feedback')
                    .html(response.errors.jobType[0]);
                }else{
                    $('#jobType').removeClass('is-invalid').
                    siblings('p')
                    .removeClass('invalid-feedback')
                    .html('');
                }

                if(response.errors.vacancy){
                    $('#vacancy').addClass('is-invalid').
                    siblings('p')
                    .addClass('invalid-feedback')
                    .html(response.errors.vacancy[0]);
                }else{
                    $('#vacancy').removeClass('is-invalid').
                    siblings('p')
                    .removeClass('invalid-feedback')
                    .html('');
                }

                if(response.errors.salary){
                    $('#salary').addClass('is-invalid').
                    siblings('p')
                    .addClass('invalid-feedback')
                    .html(response.errors.salary[0]);
                }else{
                    $('#salary').removeClass('is-invalid').
                    siblings('p')
                    .removeClass('invalid-feedback')
                    .html('');
                }

                if(response.errors.location){
                    $('#location').addClass('is-invalid').
                    siblings('p')
                    .addClass('invalid-feedback')
                    .html(response.errors.location[0]);
                }else{
                    $('#location').removeClass('is-invalid').
                    siblings('p')
                    .removeClass('invalid-feedback')
                    .html('');
                }

                if(response.errors.description){
                    $('#description').addClass('is-invalid').
                    siblings('p')
                    .addClass('invalid-feedback')
                    .html(response.errors.description[0]);
                }else{
                    $('#description').removeClass('is-invalid').
                    siblings('p')
                    .removeClass('invalid-feedback')
                    .html('');
                }

                if(response.errors.benefits){
                    $('#benefits').addClass('is-invalid').
                    siblings('p')
                    .addClass('invalid-feedback')
                    .html(response.errors.benefits[0]);
                }else{
                    $('#benefits').removeClass('is-invalid').
                    siblings('p')
                    .removeClass('invalid-feedback')
                    .html('');
                }
                if(response.errors.responsibility){
                    $('#responsibility').addClass('is-invalid').
                    siblings('p')
                    .addClass('invalid-feedback')
                    .html(response.errors.responsibility[0]);
                }else{
                    $('#responsibility').removeClass('is-invalid').
                    siblings('p')
                    .removeClass('invalid-feedback')
                    .html('');
                }
                if(response.errors.qualifications){
                    $('#qualifications').addClass('is-invalid').
                    siblings('p')
                    .addClass('invalid-feedback')
                    .html(response.errors.qualifications[0]);
                }else{
                    $('#qualifications').removeClass('is-invalid').
                    siblings('p')
                    .removeClass('invalid-feedback')
                    .html('');
                }
                if(response.errors.experience){
                    $('#experience').addClass('is-invalid').
                    siblings('p')
                    .addClass('invalid-feedback')
                    .html(response.errors.experience[0]);
                }else{
                    $('#experience').removeClass('is-invalid').
                    siblings('p')
                    .removeClass('invalid-feedback')
                    .html('');
                }
                if(response.errors.keywords){
                    $('#keywords').addClass('is-invalid').
                    siblings('p')
                    .addClass('invalid-feedback')
                    .html(response.errors.keywords[0]);
                }else{
                    $('#keywords').removeClass('is-invalid').
                    siblings('p')
                    .removeClass('invalid-feedback')
                    .html('');
                }
                if(response.errors.company_name){
                    $('#company_name').addClass('is-invalid').
                    siblings('p')
                    .addClass('invalid-feedback')
                    .html(response.errors.company_name[0]);
                }else{
                    $('#company_name').removeClass('is-invalid').
                    siblings('p')
                    .removeClass('invalid-feedback')
                    .html('');
                }
                if(response.errors.company_location){
                    $('#company_location').addClass('is-invalid').
                    siblings('p')
                    .addClass('invalid-feedback')
                    .html(response.errors.company_location[0]);
                }else{
                    $('#company_location').removeClass('is-invalid').
                    siblings('p')
                    .removeClass('invalid-feedback')
                    .html('');
                }
                if(response.errors.company_website){
                    $('#company_website').addClass('is-invalid').
                    siblings('p')
                    .addClass('invalid-feedback')
                    .html(response.errors.company_website[0]);
                }else{
                    $('#company_website').removeClass('is-invalid').
                    siblings('p')
                    .removeClass('invalid-feedback')
                    .html('');
                }
            }
        }
    }
    );
});
</script>
@endsection