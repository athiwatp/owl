@extends('layouts.modal')

@section('title', 'Update Role')
@section('content')
    <form method="POST" action="{{ route('roles.update', $role->id) }}" novalidate>
        {{ csrf_field() }}

        <div class="modal-body">
            <div class="form-group">
                <label for="name">Name</label>
                <input name="name" id="name" class="form-control" value="{{ $role->name }}">
            </div>

            <div class="form-group">
                <div class="form-check float-right">
                    <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" data-check="permissions[]"> Check All
                    </label>
                </div>
                <label for="name">Permissions</label>
                <ul class="list-group list-group-hover">
                    @foreach ($group_permissions as $group => $permissions)
                        <li class="list-group-item">
                            <div class="mt-1 mb-2">{{ $group }}</div>
                            @foreach ($permissions as $permission)
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input type="checkbox" name="permissions[]" class="form-check-input" value="{{ $permission->name }}"{{ $role->hasPermissionTo($permission->name) ? ' checked' : '' }}> {{ $permission->name }}
                                    </label>
                                </div>
                            @endforeach
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Update</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
    </form>
@endsection