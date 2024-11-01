<?php

namespace App\Exports;

use App\Models\UserModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithHeadings
{
    protected $from;
    protected $to;

    public function __construct($from, $to){
        $this->from = $from;
        $this->to = $to;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return UserModel::select('first_name', 'last_name', 'personal_number', 'birth_date', 'gender', 'citizenship', 'address', 'phone', 'email', 'parent_first_name', 'parent_last_name', 'parent_personal_number', 'insurance', 'referral_source')->where('role', 'user')->whereBetween('created_at', [$this->from, $this->to])->get();
    }

    public function headings(): array {
        return [
            'სახელი',
            'გვარი',
            'პ/ნ',
            'დაბ. თარიღი',
            'სქესი',
            'მოქალაქეობა',
            'მისამართი',
            'ტელეფონი',
            'ელ. ფოსტა',
            'მშობლის სახელი',
            "მშობლის გვარი",
            "მშობლის პ/ნ",
            'დაზღვევა',
            'საიდან გაიგე'
        ];
    }
}
