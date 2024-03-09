<?php

namespace App\Http\Controllers;

use App\Models\UserLogs;


class BaseController extends Controller
{
    public function writeToLog($type, $message) :void {
        UserLogs::create([
            'type' => $type,
            'message' => $message,
        ]);
    }
}
