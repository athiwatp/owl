<?php

namespace App\Traits;

use Carbon\Carbon;

trait UserTimezone
{
    // access user timezone if logged in
    public function getCreatedAtAttribute($value)
    {
        return $this->userTimezone($value);
    }

    public function getUpdatedAtAttribute($value)
    {
        return $this->userTimezone($value);
    }

    public function getDeletedAtAttribute($value)
    {
        return $this->userTimezone($value);
    }

    public function userTimezone($value)
    {
        return Carbon::parse($value)->tz(auth()->guest() ? config('settings.default_timezone') : auth()->user()->timezone)->toDateTimeString();
    }
}