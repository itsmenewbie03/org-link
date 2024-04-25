@extends('dashboard')
@section('content')
    <livewire:tenant-users-add-user />
    <livewire:tenant-users-table :users="$users" />
@endsection
