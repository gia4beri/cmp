@include('header')
    <div class="w-full p-1 m-auto">
        <table class="w-full text-left mt-1">
            <tbody  <a href="#!" onclick="window.print()"></a>
                <tr>
                    <td class="pb-px">
                        @if($logo->option_value)
                            <img src="{{ $logo->option_value }}" class="h-32">
                        @else
                            {{ env('APP_NAME') }}
                        @endif
                    </td>
                    <td class="pb-px text-right">
                        <h1 class="text-l mt-1 font-bold">ინვოისი #{{ date('Ymd', strtotime($invoice->invoice_created_at)) }}-{{$invoice->invoice_id}}</h1>
                        <div class="mt-1">ინვოისი შეიქმნა: {{ $invoice->invoice_created_at }}</div>
                        <h2 class="text-xl @if($invoice->status) text-green-600 @else text-red-600 @endif">@if($invoice->status) გადახდილი <a class="text-base">{{ $invoice->invoice_updated_at }}</a> @else გადაუხდელი @endif</h2>
                        <h2 class="text-base">გადახდის მეთოდი: {{ $invoice->payment_method }}</h2>
                        @if(!empty($invoice->insurance))
                            <h2 class="text-base">სადაზღვეო კომპანია: {{ $invoice->insurance }}</h2>
                            <h2 class="text-base">სადაზღვეო კოდი: {{ $invoice->insurance_code }}</h2>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="pb-px text-left">
                        {!! $company_info->option_value !!}
                    </td>
                    <td class="pb-px text-right align-text-top">
                        <span class="mb-3 block font-bold text-base">პაციენტის ინფორმაცია</span>
                        {{ $invoice->first_name }} {{ $invoice->last_name }}<br>
                        დაბ. თარიღი: {{ $invoice->birth_date }}<br>
                        პ/ნ: {{ $invoice->personal_number }}<br>
                        ტელეფონი: {{ $invoice->phone }}<br>
                        მისამართი: {{ $invoice->address }}<br>
                    </td>
                </tr>
            </tbody>
        </table>
        <table class="w-full text-left">
            <thead class="bg-gray-200 font-bold">
                <tr>
                    <th class="p-2">ექიმი / Doctor</th>
                    <th class="p-2">მომს / Service</th>
                    <th class="p-2">რდნ / Qty</th>
                    <th class="p-2">საცალო ფასი / Retail price</th>
                    <th class="p-2">ფასი / Price (&#8382;)</th>
                    <th class="p-2">ფასი / Price (&#36;)</th>
                    <th class="p-2">ფასი / Price (&#8364;)</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $usd_sum = 0;
                    $eur_sum = 0;
                @endphp
                @foreach(json_decode($invoice->items) as $item)
                    @php
                        $usd_sum += round($item->service_price_usd * $item->service_quantity, 2);
                        $eur_sum += round($item->service_price_eur * $item->service_quantity, 2);
                    @endphp
                    <tr class="border-b border-gray-200">
                        <td class="pr-3 whitespace-nowrap">{{ $item->service_doctor }}</td>
                        <td class="pr-3">{{ $item->service_name }}</td>
                        <td class="pr-3">{{ $item->service_quantity }}</td>
                        <td class="pr-3">{{ $item->service_price_gel }} &#8382;</td>
                        <td class="pr-3">{{ round($item->service_price_gel * $item->service_quantity, 2) }} &#8382;</td>
                        <td class="pr-3">{{ round($item->service_price_usd * $item->service_quantity, 2) }} &#36;</td>
                        <td class="pr-3">{{ round($item->service_price_eur * $item->service_quantity, 2) }} &#8364;</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="bg-gray-200 font-bold">
                    <th class="p-2" colspan="4">ქვეჯამი / Subtotal:</th>
                    <td class="p-2">{{ round($invoice->total, 2) }} &#8382;</td>
                    <td class="p-2">{{ round($usd_sum, 2) }} &#36;</td>
                    <td class="p-2">{{ round($eur_sum, 2) }} &#8364;</td>
                </tr>
                <tr class="bg-gray-200 font-bold">
                    <th class="p-2" colspan="4">ფასდაკლება / Discount:</th>
                    <td class="p-2">-{{ $invoice->discount }}%</td>
                    <td class="p-2">-{{ $invoice->discount }}%</td>
                    <td class="p-2">-{{ $invoice->discount }}%</td>
                </tr>
                <tr class="bg-gray-200 font-bold">
                    <th class="p-2" colspan="4">ჯამი / Sum:</th>
                    <td class="p-2">{{ round($invoice->total - ( ($invoice->total * $invoice->discount) / 100 ), 2) }} &#8382;</td>
                    <td class="p-2">{{ round($usd_sum - ( ($usd_sum * $invoice->discount) / 100 ), 2) }} &#36;</td>
                    <td class="p-2">{{ round($eur_sum - ( ($eur_sum * $invoice->discount) / 100 ), 2) }} &#8364;</td>
                </tr>
            </tfoot>
        </table>
        <br>
        დამატებითი ინფორმაცია / Additional information<br><br>
        {!! $invoice->additional_info !!}
        <br><br>
    </div>
@include('footer')
