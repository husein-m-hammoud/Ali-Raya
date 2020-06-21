@extends('layouts.app') @section('content')

<hr />



<div class="container text-center">
@foreach($Users as $user)
    <div class="row mt-4">
        <div class="col-4  row text-sm-center text-ov">
            <div class="ml-4">
                <img src="Images/user.png" alt="" width="40" />
            </div>

            <span class=" h5 m-3 mr-2">{{$user->name}}</span>
        </div>
        <div class=" col-6  m-2 ">
            <div class="row ">
                <div title=" {{$user->Phone}}" class="col-sm-3 text-ov">
                <p class="mb-0">{{$user->Phone}}</p>
                </div>
                <div title=" {{$user->email}}" class="col-sm-3 text-ov"><p class="mb-0">{{$user->email}}</p></div>
                <div title=" {{$user->Address}}" class="col-sm-3 text-ov">
                <p class="mb-0">{{$user->Address}}</p></div>
            </div>
        </div>
        <div class="col-2 navbar-expand-lg">
            <button
                class="btn d-lg-none mt-3"
                type="button"
                data-toggle="collapse"
                data-target="#example-collapse{{$user->id}}"
            >
                <span class="navbar-light"
                    ><span class="navbar-toggler-icon"></span
                ></span>
            </button>

            <div id="example-collapse{{$user->id}}" class="collapse d-lg-block">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a  class="nav-link">
                            <img src="Images/enter.png" alt="" width="20"
                        /></a>
                    </li>
                    <li class="nav-item">
                        <a  href="/editUser/{{$user->id}}" class="nav-link">
                            <img src="Images/edit.png" alt="" width="20"
                        /></a>
                    </li>
                    <li class="nav-item">
                        <a href="/deleteUser/{{$user->id}}" class="nav-link">
                            <img src="Images/trash.png" alt="" width="20"
                        /></a>
                    </li>
                    <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <img src="Images/key.png" alt="password" width="20">
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="/reset/{{$user->id}}">
                                            <img src="Images/password.png" alt="password" width="20">
                                            <span>Reset Password</span>

                                    </a>
                                    <a class="dropdown-item"  href="/block/{{$user->id}}">
                                    <img src="Images/block.png" alt="password" width="20">
                                            <span>Block User</span>
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                </ul>
            </div>
        </div>
    </div>
    <hr />
    @endforeach
    <a href="{{ route('AdminRegister') }}" >
        <div class="Add ">
        <img src="/Images/adduser.png" alt="ADD" height=50 width=50 >
        </div>

    </a>

</div>
@endsection
