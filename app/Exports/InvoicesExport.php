<?php

namespace App\Exports;

use App\Models\InvoiceModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class InvoicesExport implements FromCollection, WithHeadings, WithMapping
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
        return InvoiceModel::select('invoices.id as invoice_id', 'items', 'total', 'discount', 'payment_method', 'invoices.insurance as invoice_insurance', 'insurance_code', 'additional_info', 'users.*')->where('status', true)->whereBetween('invoices.created_at', [$this->from, $this->to])->join('users', 'users.id', '=', 'invoices.user_id')->get();
    }

    public function headings(): array {
        return [
            '#',
            'ექიმი',
            'მომს',
            'რდნ',
            'ფასი',
            'ფასდაკლება',
            'ჯამი',
            'გადახ. მეთოდი',
            'სახელი',
            'გვარი',
            'დაბ. თარიღი',
            'პ/ნ',
            'სქესი',
            'ტელეფონი',
            'მისამართი',
            'დაზღვევა',
            'დაზღვევის კოდი',
            'დამატ. ინფორმ.'
        ];
    }

    public function map($row): array {
        $services = json_decode($row->items, true);
        $mappedRows = [];

        $counter = 0;
        foreach ($services as $service) {
            $counter++;
            $mappedRows[] = [
                $counter < 2 ? date('Ymd', strtotime($row->created_at)).'-'.$row->invoice_id : '',
                $service['service_doctor'],
                $service['service_name'],
                $service['service_quantity'],
                $service['service_price_gel'],
                $counter < 2 ? $row->discount : '',
                $counter < 2 ? $row->total - ( ($row->total * $row->discount) / 100 ) : '',
                $counter < 2 ? $row->payment_method : '',
                $counter < 2 ? $row->first_name : '',
                $counter < 2 ? $row->last_name : '',
                $counter < 2 ? $row->birth_date : '',
                $counter < 2 ? $row->personal_number : '',
                $counter < 2 ? $row->gender : '',
                $counter < 2 ? $row->phone : '',
                $counter < 2 ? $row->address : '',
                $counter < 2 ? $row->invoice_insurance : '',
                $counter < 2 ? $row->insurance_code : '',
                $counter < 2 ? strip_tags($row->additional_info) : '',
            ];
        }

        return $mappedRows;
    }
}
