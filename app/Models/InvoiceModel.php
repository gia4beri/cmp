<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceModel extends Model
{
    use HasFactory;
    protected $table = 'invoices';

    public function createInvoice($data, $user_id, $total, $additional)
    {
        $this->payment_method = $additional['payment_method'];
        $this->insurance = empty($additional['insurance']) ? '' : $additional['insurance'];
        $this->insurance_code = empty($additional['insurance_code']) ? '' : $additional['insurance_code'];
        $this->additional_info = $additional['additional_info'];
        $this->items = $data;
        $this->total = $total;
        $this->discount = empty($additional['discount']) ? '0' : $additional['discount'];
        $this->user_id = $user_id;
        $this->save();
    }

    public function remove($data){
        $this->destroy($data);
    }

    public function pay($data){
        $update = InvoiceModel::find($data);
        $update->status = true;
        $update->save();
    }
}
