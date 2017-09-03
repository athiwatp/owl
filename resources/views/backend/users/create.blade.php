@extends('layouts.modal')

@section('title', 'Create User')
@section('content')
    <form method="POST" action="{{ route('users.create') }}" novalidate>
        {{ csrf_field() }}

        <div class="modal-body">
            <div class="form-group">
                <label for="name">Name</label>
                <input name="name" id="name" class="form-control">
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control">
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control">
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
            </div>

            <div class="form-group">
                <label for="timezone">Timezone</label>
                <select name="timezone" id="timezone" class="form-control">
                    @foreach (timezones() as $timezone)
                        <option value="{{ $timezone['identifier'] }}"{{ $timezone['identifier'] == config('settings.default_timezone') ? ' selected' : '' }}>{{ $timezone['label'] }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" data-check="roles[]">
                        Roles
                    </label>
                </div>
                @foreach ($roles as $role)
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input type="checkbox" name="roles[]" class="form-check-input" value="{{ $role->name }}">
                            {{ $role->name }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Create</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
    </form>
@endsection