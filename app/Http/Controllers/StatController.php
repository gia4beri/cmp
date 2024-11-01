<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Exports\UsersExport;
use App\Exports\InvoicesExport;
use Maatwebsite\Excel\Facades\Excel;

class StatController extends Controller
{
    private function getUserData()
    {
        if (Auth::check()) {
            return Auth::user();
        } else {
            return redirect('/');
        }
    }
    public function index()
    {

        $day_users = DB::table('users')->where('role', 'user')->whereDate('created_at', '=', date('Y-m-d'))->count();
        $day_sum = DB::table('invoices')->whereDate('created_at', '=', date('Y-m-d'))->where('status', true)->sum('total');

        $week_users = DB::table('users')->where('role', 'user')->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
        $week_sum = DB::table('invoices')->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where('status', true)->sum('total');

        $month_users = DB::table('users')->where('role', 'user')->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->count();
        $month_sum = DB::table('invoices')->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->where('status', true)->sum('total');

        $year_users = DB::table('users')->where('role', 'user')->whereBetween('created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->count();
        $year_sum = DB::table('invoices')->whereBetween('created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->where('status', true)->sum('total');


        return view('stats', [
            'title' => 'სტატისტიკა',
            'user' => $this->getUserData(),

            'day_users' => $day_users,
            'day_sum' => $day_sum,
            'day_average' => $day_users == 0 ? 0 : round(($day_sum / $day_users), '2'),

            'week_users' => $week_users,
            'week_sum' => $week_sum,
            'week_average' => $week_users == 0 ? 0 : round(($week_sum / $week_users), '2'),

            'month_users' => $month_users,
            'month_sum' => $month_sum,
            'month_average' => $month_users == 0 ? 0 : round(($month_sum / $month_users), '2'),

            'year_users' => $year_users,
            'year_sum' => $year_sum,
            'year_average' => $week_users == 0 ? 0 : round(($year_sum / $year_users), '2'),
        ]);
    }
    public function export(Request $request){
        $validated = $request->validate([
            'from' => 'required|date',
            'to' => 'required|date',
            'users' => 'nullable|integer',
            'invoices' => 'nullable|integer',
        ]);

        if( !empty($validated['users']) ){
            return Excel::download(new UsersExport($validated['from'], $validated['to']), 'users.xlsx');
        } elseif( !empty($validated['invoices']) ){
            return Excel::download(new InvoicesExport($validated['from'], $validated['to']), 'invoices.xlsx');
        }
    }
}
