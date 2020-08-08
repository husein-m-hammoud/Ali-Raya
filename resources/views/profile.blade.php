@extends('layouts.app2')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card"  >
                <div class="card-header h5" style="background:#FFF">Profile</div>

                <div class="card-body cardbg"  >

                    <!-- @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif -->


                    <div class="form-horizontal">


                        <div class="form-group row">
                            <label  class="col-md-5 ff col-form-label text-md-right">Full Name</label>

                            <div class="col-md-6">
                                <p class="   col-form-label ">{{$user->name}} <p>


                            </div>
                        </div>
    <hr>
                        <div class="form-group row">
                            <label  class="col-md-5 ff col-form-label text-md-right">Email</label>

                            <div class="col-md-6">
                                <p class="   col-form-label">{{$user->email}} <p>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <label  class="col-md-5 ff col-form-label text-md-right">Phone</label>

                            <div class="col-md-6">
                                <p class="   col-form-label">{{$user->Phone}}<p>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <label  class="col-md-5 ff col-form-label text-md-right">Address</label>

                            <div class="col-md-6">
                                <p class="   col-form-label">{{$user->Address}}<p>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <label  class="col-md-5 ff col-form-label text-md-right">Number Audio</label>

                            <div class="col-md-6">
                                <p class="   col-form-label">{{$count}}  Audio<p>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <label  class="col-md-5 ff col-form-label text-md-right">Extension Number</label>

                            <div class="col-md-6">
                                <p class="   col-form-label">{{$user->ExtensionNumber}}  Max<p>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-3 offset-md-5">
                            <a  href="/changePassword">
                            <button  class="btn btn-primary">
                                    Change Password
                                </button>
                            </a>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
