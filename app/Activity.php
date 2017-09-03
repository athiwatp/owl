<?php

namespace App;

use App\Traits\UserTimezone;

class Activity extends \Spatie\Activitylog\Models\Activity
{
    use UserTimezone;
}
