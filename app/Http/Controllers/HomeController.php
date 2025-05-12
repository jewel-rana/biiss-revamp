<?php

namespace App\Http\Controllers;

use App\Models\Library;
use App\Models\LibraryIssue;
use App\Models\LibraryReturn;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $data['title'] = 'Dashboard';
        $data['info'] = Library::groupBy('type')->select('type', DB::raw('count(*) as total'))->get();
        $date = date('Y-m-d');
        $data['issues']['total'] = LibraryIssue::where('is_returned', 0)->count();
        $data['issues']['expired'] = LibraryIssue::where('is_returned', 0)->where('end_date', '<', $date)->count();
        $data['issues']['active'] = LibraryIssue::where('is_returned', 0)->where('end_date', '>=', $date)->count();
        $data['membercount'] = User::count();


        $today = date('Y-m-d');

        $data['expiredIssues'] = LibraryIssue::with('item')->where('is_returned','0')->whereDate('end_date','<',$today)->take(5)->get();

        // dd( $data['expiredIssues'] );


        $data['weeklyReturns'] = LibraryReturn::with(['item', 'issue'])->where('created_at', '>=', Carbon::now()->startOfWeek())->take(5)->get();

        //get interactive maps Data
        // this week results
        $fromDate = Carbon::now()->subDay(7)->toDateString(); // or ->format(..)
        $tillDate = Carbon::now()->subDay()->toDateString();

        $events = LibraryIssue::selectRaw('DATE_FORMAT(created_at, "%M %d") as date, COUNT(*) as count')
            ->whereBetween( DB::raw('date(created_at)'), [$fromDate, $tillDate] )
            ->groupBy('date')
            ->orderBy('date', 'ASC')->get()->toArray();
        $data['events'] = $events;

        // dd($data['events']);

        return view('dashboard.home.index', $data);
    }
}
