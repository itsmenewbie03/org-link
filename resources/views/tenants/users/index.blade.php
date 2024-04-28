@extends('dashboard')
@section('content')
    <livewire:tenant-users-table :users="$users" />
@endsection
