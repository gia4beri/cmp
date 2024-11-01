<?php

namespace App\Http\Controllers;

use App\Models\ConsultationModel;
use App\Models\InvoiceModel;
use Illuminate\Http\Request;
use App\Models\UserModel;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    private function getUserData()
    {
        if (Auth::check()) {
            return Auth::user();
        } else {
            return redirect('/');
        }
    }
    public function index(){

        $month_users = DB::table('users')->where('role', 'user')->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->count();
        $month_sum = DB::table('invoices')->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->where('status', true)->sum('total');
        $month_average = $month_users == 0 ? 0 : round(($month_sum / $month_users), '2');

        $invoices = InvoiceModel::where('status', true)->join('users', 'invoices.user_id', '=', 'users.id')->select('invoices.id as invoice_id', 'users.first_name', 'users.last_name', 'invoices.total', 'invoices.discount', 'invoices.created_at as invoice_created_at')->limit(10)->get();

        $user = $this->getUserData();

        if($user->role == 'doctor'){
            $consultations = ConsultationModel::join('users', 'consultations.user_id', '=', 'users.id')
                ->join('users as doctors', 'consultations.doctor_id', '=', 'doctors.id')
                ->select('consultations.id as consultations_id', 'users.first_name as users_first_name', 'users.last_name as users_last_name', 'consultations.created_at as consultation_created_at', 'doctors.first_name as doctors_first_name', 'doctors.last_name as doctors_last_name')
                ->where('consultations.doctor_id', $user->id)
                ->limit(10)
                ->get();;
        } else {
            $consultations = ConsultationModel::join('users', 'consultations.user_id', '=', 'users.id')
                ->join('users as doctors', 'consultations.doctor_id', '=', 'doctors.id')
                ->select('consultations.id as consultations_id', 'users.first_name as users_first_name', 'users.last_name as users_last_name', 'consultations.created_at as consultation_created_at', 'doctors.first_name as doctors_first_name', 'doctors.last_name as doctors_last_name')
                ->limit(10)
                ->get();;
        }

        return view('dashboard', [
            'title' => 'მთავარი გვერდი',
            'user' => $this->getUserData(),
            'month_users' => $month_users,
            'month_sum' => $month_sum,
            'month_average' => $month_average,
            'invoices' => $invoices,
            'consultations' => $consultations
            ]);
    }
}
