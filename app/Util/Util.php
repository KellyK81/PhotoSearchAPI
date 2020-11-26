<?php

namespace App\Util;

use Illuminate\Support\Facades\DB;

class Util {

    public static function saveUserActivity($user_id, $activity_type, $activity) {
        // Save User Activity
        DB::table('activity')->insert(
            ['user_id' => $user_id, 
            'activity_type' => $activity_type,
            'activity' => $activity
            ]
        );
    }

}