<?php

namespace App;

use App\Traits\Owl;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use Owl;

    protected $fillable = ['key', 'value'];
}
