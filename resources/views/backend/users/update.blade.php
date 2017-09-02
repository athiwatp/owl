@extends('layouts.modal')

@section('title', 'Update User Profile')
@section('content')
    <form method="POST" action="{{ route('users.update', $user->id) }}" novalidate>
        {{ csrf_field() }}

        <div class="modal-body">
            <div class="form-group">
                <label for="name">Name</label>
                <input name="name" id="name" class="form-control" value="{{ $user->name }}">
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ $user->email }}">
            </div>

            <div class="form-group">
                <label for="timezone">Timezone</label>
                <select name="timezone" id="timezone" class="form-control">
                    @foreach (timezones() as $timezone)
                        <option value="{{ $timezone['identifier'] }}"{{ $timezone['identifier'] == $user->timezone ? ' selected' : '' }}>{{ $timezone['label'] }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="role">Role</label>
                <select name="role" id="role" class="form-control">
                    @foreach ($roles as $role)
                        <option value="{{ $role->name }}"{{ $user->hasRole($role->name) ? ' selected' : '' }}>{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Update</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
    </form>
@endsection