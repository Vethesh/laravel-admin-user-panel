@extends('layout')

@section('title', 'Change Password')

@section('content')
    <div class="container">
        <h1>Change Password for {{ $user->name }}</h1>
        <form method="post" action="{{ route('admin.change-password.update', ['user' => $user]) }}">
            @csrf
            @method('put')

            <div class="form-group">
                <label for="password">New Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Update Password</button>
        </form>
    </div>
@endsection
