@extends('layouts.app2')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Extension</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                </div>

            </div>
            <a id='add'  >
        <div   class="Add " style="padding: 12px;">
        <img title="Add Extension" src="/Images/adduser.png" alt="ADD" height=50 width=50 >
        </div>

    </a>
        </div>
    </div>
</div>
<div id="myModal" class="modal">
<div class="modal-contentt">
    <span id='close' class="close">&times;</span>
    <h4>Add Extension</h4>
    <label for=""> name</label>
    <input type="text" id="AudioName" />
    <br>
    <p id='error' >Please enter name of Audio</p>

    <button id="uplod"  class="btn btn-success trim-left" style="margin-top:10px">submit</button>
  </div>
</div>
<script

        src="{{ asset('js/Extension.js') }}"
    ></script>
@endsection
