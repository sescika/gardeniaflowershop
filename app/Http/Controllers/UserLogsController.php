<?php

namespace App\Http\Controllers;

use App\Models\UserLogs;

use Illuminate\Http\Request;

class UserLogsController extends BackendController
{

    public function index(?Request $request, $order = 'desc')
    {
        if ($order == 'desc') {
            $data = UserLogs::orderByDesc('created_at')->paginate(15);
        }

        if ($order == 'asc') {
            $data = UserLogs::orderBy('created_at')->paginate(15);
        }

        if ($request->ajax()) {
            //dd($request->getUri());
            $links = (string) $data->links();
            $data->withPath('/admin/userLogs/' . $order);
            $all = [
                'data' => $data,
                'links' => $links
            ];

            return response()->json($all);
        }

        return view('pages.admin.userlogs', ['data' => $data]);
    }
}
