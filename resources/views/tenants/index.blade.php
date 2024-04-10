@extends('dashboard')
@section('content')
    <livewire:tenants-table :tenants="$tenants" />
@endsection
