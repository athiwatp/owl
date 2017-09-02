@extends('layouts.modal')

@section('title', $activity->description)
@section('content')
    <div class="modal-body">
        @if(isset($subject))
            <div class="card mb-3">
                <div class="card-header">Subject</div>
                <div class="card-body">
                    <pre class="mb-0">{{ json_encode($subject->toArray(), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                </div>
            </div>
        @endif

            @if(isset($causer))
            <div class="card mb-3">
                <div class="card-header">Causer</div>
                <div class="card-body">
                    <pre class="mb-0">{{ json_encode($causer->toArray(), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                </div>
            </div>
        @endif

        @if($activity->properties != '[]')
            <div class="card mb-3">
                <div class="card-header">Properties</div>
                <div class="card-body">
                    <pre class="mb-0">{{ json_encode($activity->properties->toArray(), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                </div>
            </div>
        @endif
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    </div>
@endsection