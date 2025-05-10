<?php

namespace Modules\Activity\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Activity\App\Models\ActivityLog;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $length = $request->input('length', 10);
            $start = $request->input('start', 0);

            $query = ActivityLog::filter($request)->skip($start)->limit($length);

            $count = ActivityLog::count();

            return datatables()->of($query->get())
                ->with([
                    'recordsTotal' => $count,
                    'recordsFiltered' => $count,
                ])
                ->editColumn('message', function ($row) {
                    if(array_key_exists('changes', $row->data) && array_key_exists('remember_token', $row->data['changes'])) {
                        $row->message = "User logged in";
                    }
                    return $row->message;
                })
                ->addColumn('actions', function ($row) {
                    return "<button class='btn btn-primary btn-sm showActivity' type='button' data-content='{$row}'><i class='fa fa-eye'></i></button>";
                })
                ->addColumn('causer', function ($row) {
                    return class_basename($row->causer_type);
                })
                ->addColumn('subject', function ($row) {
                    return class_basename($row->subject_type);
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
        return view('activity::index');
    }
}
