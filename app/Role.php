<?php

namespace App;

use App\Traits\UserTimezone;

class Role extends \Spatie\Permission\Models\Role
{
    use UserTimezone;
}
