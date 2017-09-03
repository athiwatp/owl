<?php

namespace App;

use App\Traits\UserTimezone;

class Permission extends \Spatie\Permission\Models\Permission
{
    use UserTimezone;
}
