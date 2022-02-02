@extends('admin.layout.head')

@section('content')




<div id="main-content">
    <div class="block-header">
        <div class="row clearfix">
            <div class="col-md-6 col-sm-12">
                <h2>Edit Profile</h2>
            </div>
            <div class="col-md-6 col-sm-12 text-right">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html"><i class="icon-home"></i></a></li>
                    <li class="breadcrumb-item active">Edit Profile</li>
                </ul>
                <!-- <a href="javascript:void(0);" class="btn btn-sm btn-primary" title="">Create New</a> -->
            </div>
        </div>
    </div>

    <div class="container-fluid">

        <div class="row clearfix">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                    @endif
                    @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif

                    <form class="form-horizontal" method="POST" action="{{ route('editProfile') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <label>First Name<span style="color: red;">*</span></label>
                                    <input type="text" class="form-control" name="name" placeholder="abc" value="{{$user->name}}" required>

                                    @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-lg-6">
                                    <label>Last Name<span style="color: red;">*</span></label>
                                    <input type="text" class="form-control" name="last_name" placeholder="xyx" value="{{$user->last_name}}" required>

                                    @if ($errors->has('last_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <label>Email<span style="color: red;">*</span></label>
                                    <input type="email" class="form-control" name="email" placeholder="abc@gmail.com" value="{{$user->email}}" required>

                                    @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-lg-6">
                                    <label>Mobile<span style="color: red;">*</span></label>
                                    <input type="text" class="form-control" name="mobile" placeholder="997487548" value="{{$user->mobile}}" required>

                                    @if ($errors->has('mobile'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('mobile') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <label>Profile Image</label>
                                    <input type="file" class="form-control" name="profile_image" value="">

                                    @if ($errors->has('profile_image'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('profile_image') }}</strong>
                                    </span>
                                    @endif
                                </div>
                               
                            </div>




                            <div class="row" style="margin-top: 10px;">
                                <div class="col-lg-6">
                                    <button type="submit" class="btn btn-primary">
                                        Update
                                    </button>
                                </div>
                            </div>




                        </div>
                    </form>
                </div>

            </div>

        </div>

    </div>
</div>
@endsection