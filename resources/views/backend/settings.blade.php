@extends('layouts.app')

@section('title', 'Settings')
@section('content')
    <div class="container">
        <h1 class="display-5 mt-4 mb-4">@yield('title')</h1>

        <form method="POST" action="{{ route('settings') }}" novalidate>
            {{ csrf_field() }}

            <div class="form-group">
                <label for="title">Title</label>
                <input name="title" id="title" class="form-control" value="{{ config('settings.title') }}">
            </div>

            <div class="form-group">
                <label for="default_timezone">Default Timezone</label>
                <select name="default_timezone" id="default_timezone" class="form-control">
                    @foreach (timezones() as $timezone)
                        <option value="{{ $timezone['identifier'] }}"{{ $timezone['identifier'] == config('settings.default_timezone') ? ' selected' : '' }}>{{ $timezone['label'] }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="recaptcha_site_key">reCAPTCHA Site Key</label>
                <input name="recaptcha_site_key" id="recaptcha_site_key" class="form-control" value="{{ config('settings.recaptcha_site_key') }}">
            </div>

            <div class="form-group">
                <label for="recaptcha_secret_key">reCAPTCHA Secret Key</label>
                <input name="recaptcha_secret_key" id="recaptcha_secret_key" class="form-control" value="{{ config('settings.recaptcha_secret_key') }}">
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection