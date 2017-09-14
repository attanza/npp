@extends('layouts.admin')
@section('content')
  <product-list></product-list>
@endsection
@section('scripts')
  <script src="{{asset('js/sortable.js')}}"></script>
@endsection
