@extends('layouts.admin')
@section('content')
  <order-list></order-list>
@endsection
@section('scripts')
  <script src="{{asset('js/sortable.js')}}"></script>
@endsection
