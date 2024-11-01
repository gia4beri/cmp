<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionModel extends Model
{
    use HasFactory;

    protected $table = 'options';

    public function put($data)
    {
        $option_currency_usd = $this->where('option_name', 'currency_usd')->first();
        if ($option_currency_usd) {
            $option_currency_usd->option_value = $data['currency_usd'];
            $option_currency_usd->save();
        }

        $option_currency_usd = $this->where('option_name', 'currency_eur')->first();
        if ($option_currency_usd) {
            $option_currency_usd->option_value = $data['currency_eur'];
            $option_currency_usd->save();
        }

        $option_portal_logo = $this->where('option_name', 'portal_logo')->first();
        if ($option_portal_logo && ($data['portal_logo'] !='')) {
            $option_portal_logo->option_value = $data['portal_logo'];
            $option_portal_logo->save();
        }

        $option_company_info = $this->where('option_name', 'company_info')->first();
        if ($option_company_info) {
            $option_company_info->option_value = $data['company_info'];
            $option_company_info->save();
        }
    }
}
