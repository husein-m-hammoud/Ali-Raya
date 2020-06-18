

@extends('layouts.app2')

@section('content')
<script src="{{ asset('js/app.js') }}" defer></script>
<link rel="stylesheet/less" type="text/css" href="styles.less" />
<!-- <script src="https://unpkg.com/react@15.3.1/dist/react.min.js"></script> -->
  <!-- <script src="https://unpkg.com/react-dom@15.3.1/dist/react-dom.min.js"></script> -->
  <script src="./dist/worker.js" type="text/js-worker" x-audio-encode></script>
  <!-- <script src="./dist/index.js"></script> -->
<div id="main"></div>

@endsection
