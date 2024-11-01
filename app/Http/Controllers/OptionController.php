<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\OptionsRequest;

use Illuminate\Support\Facades\Auth;

use App\Models\OptionModel;

class OptionController extends Controller
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
        return view('options', [
            'title' => 'პარამეტრები',
            'user' => $this->getUserData(),
            'currency_usd' => OptionModel::where('option_name', 'currency_usd')->get(),
            'currency_eur' => OptionModel::where('option_name', 'currency_eur')->get(),
            'portal_logo' => OptionModel::where('option_name', 'portal_logo')->get(),
            'company_info' => OptionModel::where('option_name', 'company_info')->get()
        ]);
    }

    public function update(OptionsRequest $request)
    {
        $validated = $request->validated();

        if($request->hasFile('portal_logo')){
            $path = $request->file('portal_logo')->store('public/logos');
            $path = str_replace('public', '/storage', $path);
            $validated['portal_logo'] = $path;
        } else {
            $validated['portal_logo'] = '';
        }

        $options = new OptionModel();
        $options->put( $validated );

        return redirect('/dashboard/options');
    }
}
