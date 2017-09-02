@extends('layouts.modal')

@section('title', 'Update User Password')
@section('content')
    <form method="POST" action="{{ route('users.password', $user->id) }}" novalidate>
        {{ csrf_field() }}

        <div class="modal-body">
            <div class="form-group">
                <label for="password">New Password</label>
                <input type="password" name="password" id="password" class="form-control">
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm New Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
            </div>
        </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Update</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
    </form>
@endsection