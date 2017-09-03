<?php

namespace App;

use App\Traits\UserTimezone;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use UserTimezone;

    protected $fillable = ['key', 'value'];
}
