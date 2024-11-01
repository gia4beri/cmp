<?php

namespace App\Http\Controllers;

use App\Models\InvoiceModel;
use App\Models\OptionModel;
use App\Models\ServiceModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    private function getUserData()
    {
        if (Auth::check()) {
            return Auth::user();
        } else {
            return redirect('/');
        }
    }
    public function index(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'nullable|exists:users,id',
        ]);

        return view('invoices', [
            'title' => 'ინვოისები',
            'user' => $this->getUserData(),
            'services' => ServiceModel::orderBy('service_name', 'ASC')->get(),
            'consultations' => UserModel::orderBy('first_name', 'ASC')->where('consultation_price', '>', 0)->where('proficiency', '!=', '')->where('role', 'doctor')->get(),
            'invoices' => InvoiceModel::select('users.id as user_id', 'invoices.id as invoice_id', 'users.*', 'invoices.*')
                ->join('users', 'users.id', '=', 'invoices.user_id')
                ->orderBy('invoice_id', 'DESC')->simplePaginate(30),
            'from_profile' => $validated ? $validated['user_id'] : null
        ]);
    }

    public function search(Request $request){
        $validated = $request->validate([
            'user_search' => 'required|string',
        ]);

        return view('invoices', [
            'title' => 'ინვოისები',
            'user' => $this->getUserData(),
            'services' => ServiceModel::orderBy('service_name', 'ASC')->get(),
            'consultations' => UserModel::orderBy('first_name', 'ASC')->where('consultation_price', '>', 0)->where('proficiency', '!=', '')->where('role', 'doctor')->get(),
            'users' => UserModel::where('personal_number', $validated['user_search'])->first(),
            'invoices' => InvoiceModel::select('users.id as user_id', 'invoices.id as invoice_id', 'users.*', 'invoices.*')
                ->join('users', 'users.id', '=', 'invoices.user_id')
                ->orderBy('invoice_id', 'DESC')->simplePaginate(15)
        ]);
    }

    public function create(Request $request){
        $validated = $request->validate([
            'from_profile' => 'nullable|exists:users,id',
            'service_name.*' => 'required|string',
            'service_doctor.*' => 'string|nullable',
            'service_price.*' => 'required|numeric',
            'service_quantity.*' => 'required|numeric',
            'user_id' => 'required|integer|exists:users,id',
            'payment_method' => 'string|in:ბარათი,საბანკო გადარიცხვა,ნაღდი ანგარიშსწორება,სადაზღვეო კომპანია',
            'insurance' => 'string|nullable',
            'insurance_code' => 'string|nullable',
            'discount' => 'numeric|nullable',
            'additional_info' => 'string|nullable'
        ]);

        $usd = OptionModel::where('option_name', 'currency_usd')->first();
        $eur = OptionModel::where('option_name', 'currency_eur')->first();

        // Creating valid array for storing in JSON format
        for ($i = 0; $i < count($validated['service_name']); $i++) {
            $items[] = [
                'service_name' => $validated['service_name'][$i],
                'service_doctor' => $validated['service_doctor'][$i],
                'service_price_gel' => $validated['service_price'][$i],
                'service_price_usd' => round($validated['service_price'][$i] / $usd->option_value, 2),
                'service_price_eur' => round($validated['service_price'][$i] / $eur->option_value, 2),
                'service_quantity' => $validated['service_quantity'][$i],
            ];
        }

        // Calculating total
        $total = 0;
        foreach ($items as $item) {
            $total += round($item['service_price_gel'] * $item['service_quantity'], 2);
        }

        // Calling Model
        $invoice = new InvoiceModel();
        $invoice->createInvoice(json_encode($items), $validated['user_id'], $total, $validated);

        if(!empty($validated['from_profile'])){
            return redirect('/dashboard/users/profile?user_id='.$validated['from_profile']);
        } else {
            return redirect('/dashboard/invoices');
        }


    }

    public function delete(Request $request){
        $validated = $request->validate([
            'invoice_id' => 'required|integer|exists:invoices,id',
        ]);

        $invoice = new InvoiceModel();
        $invoice->remove($validated['invoice_id']);

        return redirect('/dashboard/invoices');
    }

    public function pay(Request $request){
        $validated = $request->validate([
            'invoice_id' => 'required|integer|exists:invoices,id',
        ]);

        $invoice = new InvoiceModel();
        $invoice->pay($validated['invoice_id']);

        return redirect('/dashboard/invoices');
    }

    public function view(Request $request){
        $validated = $request->validate([
            'invoice_id' => 'required|integer|exists:invoices,id',
        ]);

        return view('invoice_view', [
            'title' => 'ინვოისი',
            'user' => $this->getUserData(),
            'invoice' => InvoiceModel::select('invoices.id as invoice_id', 'invoices.created_at as invoice_created_at', 'invoices.updated_at as invoice_updated_at', 'users.*', 'invoices.*')->join('users', 'users.id', '=', 'invoices.user_id')
            ->where('invoices.id', $validated['invoice_id'])->first(),
            'usd' => DB::table('options')->where('option_name', '=','currency_usd')->first(),
            'eur' => DB::table('options')->where('option_name', '=','currency_eur')->first(),
            'logo' => DB::table('options')->where('option_name', '=','portal_logo')->first(),
            'company_info' => DB::table('options')->where('option_name', '=','company_info')->first(),
        ]);
    }
}
