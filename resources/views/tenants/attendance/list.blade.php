@extends('dashboard')
@section('content')
    <livewire:tenant-attendance-list :events="$events" />
@endsection
