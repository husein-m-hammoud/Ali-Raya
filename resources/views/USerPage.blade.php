@extends('layouts.app')

@section('content')



<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header "> <span class="ff h5">{{$user->name}}</span> Page</div>

                <div class="card-body">


                  <div class="row text-white" >
                      <div class="col-md-8  pl-5">
                      <a href="Extension/{{$user->id}}" class="btn btn-primary px-4" >
                      Extension

                    </a>
                    </div>


                    <a href="useraudio/{{$user->id}}" class="btn btn-primary  px-5" >
                       Audio

                    </a>
                  </div>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection
