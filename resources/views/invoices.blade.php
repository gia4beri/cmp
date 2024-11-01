@include('header')
    <x-dashboard :title="$title" :user="$user">

        <div id="modal-form" class="relative z-10 @if(!$errors->any() && empty($update) && empty($users) && empty($from_profile)) hidden @endif" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center items-center">
                    <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all w-11/12">
                        <div class="bg-white px-4 pb-4 pt-5">
                            <div class="flex items-start">
                                <div class="w-full">
                                    @if(!empty($users))
                                        <form id="actions" method="post" action="/dashboard/invoices">
                                            @csrf
                                            <input name="user_id" value="{{ $users->id }}" type="hidden">
                                        </form>
                                    @elseif(!empty($from_profile))
                                        <form id="actions" method="post" action="/dashboard/invoices">
                                            @csrf
                                            <input name="user_id" value="{{ $from_profile }}" type="hidden">
                                            <input name="from_profile" value="{{ $from_profile }}" type="hidden">
                                        </form>
                                    @endif
                                    <table class="table-auto w-full">
                                        @if(empty($from_profile))
                                            <thead class="text-left text-lg">
                                            <tr>
                                                <th class="text-xl py-5" colspan="5"><i class="fa-solid fa-user mr-3"></i> პაციენტის ძებნა</th>
                                            </tr>
                                            <tr class="text-base bg-gray-200 p-3">
                                                <th class="p-3" colspan="5">
                                                    <form action="/dashboard/invoices" method="post">
                                                        @method('PATCH')
                                                        <input class="rounded px-3 py-1 w-1/2 mr-3 @error('user_search') border border-red-400 @enderror" name="user_search" placeholder="პაციენტის ძებნა (პირადი ნომრით)">
                                                        @csrf
                                                        <button class="rounded px-3 py-1 bg-gray-700 text-white" type="submit">ძებნა</button>
                                                    </form>
                                                </th>
                                            </tr>
                                            <tr class="text-base bg-gray-200 p-3">
                                                <th class="p-3">სახელი</th>
                                                <th class="p-3">გვარი</th>
                                                <th class="p-3">პ/ნ</th>
                                                <th class="p-3">ტელეფონი</th>
                                                <th class="p-3">ელ. ფოსტა</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if(!empty($users))
                                                <tr>
                                                    <td class="p-3">{{ $users->first_name }}</td>
                                                    <td class="p-3">{{ $users->last_name }}</td>
                                                    <td class="p-3">{{ $users->personal_number }}</td>
                                                    <td class="p-3">{{ $users->phone }}</td>
                                                    <td class="p-3">{{ $users->email }}</td>
                                                </tr>
                                            @else
                                                <tr>
                                                    <td class="p-3" colspan="5">პაციენტი ვერ მოიძებნა</td>
                                                </tr>
                                            @endif

                                        @endif
                                        <tr class="text-xl font-bold">
                                            <td colspan="5" class="pt-5 pb-5">
                                                <i class="fa-solid fa-suitcase-medical mr-3"></i> სერვისების დამატება ინვოისში
                                            </td>
                                        </tr>
                                        <tr class="bg-gray-200">
                                            <td class="p-5" colspan="4">
                                                სერვუსები: <select class="rounded px-3 py-1 mr-3" id="invoice-services">
                                                    @foreach($services as $service)
                                                        <option value="{{ $service->service_price }}">{{ $service->service_name }}</option>
                                                    @endforeach
                                                </select>
                                                <button onclick="invoiceAddService()" class="rounded px-3 py-1 bg-gray-700 text-white mr-10">დამატება</button>

                                                კონსულტაცია: <select class="rounded px-3 py-1 mr-3" id="invoice-consultations">
                                                    @foreach($consultations as $consultation)
                                                        <option data-proficiency="{{ $consultation->proficiency }}" data-doctor="{{ $consultation->first_name }} {{ $consultation->last_name }}" value="{{ $consultation->consultation_price }}">{{ $consultation->first_name }} {{ $consultation->last_name }} ({{ $consultation->proficiency }})</option>
                                                    @endforeach
                                                </select>
                                                <button onclick="invoiceAddConsultation()" class="rounded px-3 py-1 bg-gray-700 text-white">დამატება</button>
                                            </td>
                                            <td class="text-right pr-3">
                                                <button class="align-top" onclick="addInvoiceItemField()"><i class="fa-solid fa-circle-plus"></i> ცარიელი ველის დამატება</button>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <div class="bg-gray-200 p-5" id="invoice-items">
                                        <div class="flex invoice-item" id="invoice-item">
                                            <div class="flex-1">
                                                სერვისის სახელი
                                                <input name="service_name[]" form="actions" class="w-full rounded px-3 py-1 mb-3 service-name">
                                            </div>
                                            <div class="flex-none w-1/4 ml-3">
                                                ექიმი
                                                <input name="service_doctor[]" form="actions" class="w-full rounded px-3 py-1 mb-3 service-doctor">
                                            </div>
                                            <div class="flex-none w-28 ml-3">
                                                რაოდენობა
                                                <input name="service_quantity[]" form="actions" class="w-full rounded px-3 py-1 mb-3 service-quantity">
                                            </div>
                                            <div class="flex-none w-36 ml-3">
                                                სერვისის ფასი
                                                <input name="service_price[]" form="actions" class="w-full rounded px-3 py-1 mb-3 service-price">
                                            </div>
                                            <div class="flex-none w-5 ml-3 mt-6">
                                                <button class="mt-1" onclick="invoiceItemFieldRemove(this)"><i class="fa-solid fa-trash"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-gray-200 p-5">
                                        გადახდის მეთოდი:
                                        <select form="actions" name="payment_method" class="rounded px-3 py-1 mr-3" id="payment-method">
                                            <option>ბარათი</option>
                                            <option>საბანკო გადარიცხვა</option>
                                            <option>ნაღდი ანგარიშსწორება</option>
                                            <option>სადაზღვეო კომპანია</option>
                                        </select>
                                        სადაზღვეო კომპანია: <input form="actions" id="insurance" name="insurance" class="disabled:bg-gray-100 rounded px-3 py-1 mr-3" disabled>
                                        სადაზღვეო კოდი: <input form="actions" id="insurance-code" name="insurance_code" class="disabled:bg-gray-100 rounded px-3 py-1" disabled>
                                        <div class="py-10">
                                            ფასდაკლება: <input form="actions" name="discount" class="rounded px-3 py-1"> %
                                        </div>
                                        ინვოისის დამატებითი ინფორმაცია
                                        <textarea class="textarea-toolbars" name="additional_info" form="actions"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                            <button type="submit" form="actions" class="rounded px-3 py-1 bg-gray-700 text-white">@if(!empty($update)) განახლება @else დამატება @endif</button>
                            <button onclick="modal_form_hide('/dashboard/invoices')" class="rounded bg-white px-3 py-1 text-gray-900 ring-1 ring-inset ring-gray-300 mr-3">გაუქმება</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <table class="table-auto w-full">
                <thead class="text-left text-lg">
                <tr>
                    <th class="text-xl py-5" colspan="6"><i class="fa-solid fa-file-invoice mr-3"></i>სისტემაში არსებული ინვოისები</th>
                    <th class="py-5 text-right"><button onclick="modal_form_show()" class="rounded px-3 py-1 bg-gray-700 text-white"><i class="fa-solid fa-circle-plus"></i> დამატება</button></th>
                </tr>
                <tr class="text-base bg-gray-200 p-3">
                    <th class="p-3" colspan="6">
                        <form action="/dashboard/invoices" method="post">
                            <input class="rounded px-3 py-1 w-1/2 mr-3 @error('user_search') border border-red-400 @enderror" name="user_search" placeholder="ინვოისის ძებნა (პირადი ნომრით)">
                            @csrf
                            <button class="rounded px-3 py-1 bg-gray-700 text-white" type="submit">ძებნა</button>
                        </form>
                    </th>
                    <th class="p-3 text-right">
                        @if($invoices->previousPageUrl()) <a href="{{ $invoices->previousPageUrl() }}"><i class="fa-solid fa-circle-chevron-left"></i></a> @endif
                        @if($invoices->nextPageUrl()) <a href="{{ $invoices->nextPageUrl() }}"><i class="fa-solid fa-circle-chevron-right"></i></a> @endif
                    </th>
                </tr>
                <tr class="text-base bg-gray-200 p-3">
                    <th class="p-3">ინვ. ნომერი</th>
                    <th class="p-3">თანხა</th>
                    <th class="p-3">გადახდილი</th>
                    <th class="p-3">სახელი</th>
                    <th class="p-3">გვარი</th>
                    <th class="p-3">პ/ნ</th>
                    <th class="p-3">მოქმედებები</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($invoices as $invoice)
                        <tr>
                            <td class="p-3">{{ date('Ymd', strtotime($invoice->created_at)) }}-{{$invoice->invoice_id}}</td>
                            <td class="p-3">{{ round($invoice->total - ( ($invoice->total * $invoice->discount) / 100 ), 2) }}</td>
                            <td class="p-3">@if($invoice->status) გადახდილი @else გადაუხდელი @endif</td>
                            <td class="p-3">{{ $invoice->first_name }}</td>
                            <td class="p-3">{{ $invoice->last_name }}</td>
                            <td class="p-3">{{ $invoice->personal_number }}</td>
                            <td class="p-3">
                                <i class="fa-solid fa-eye"></i> <a target="_blank" href="/dashboard/invoices/view?invoice_id={{ $invoice->invoice_id }}" class="underline mr-3">ნახვა</a>
                                @if(!$invoice->status)
                                    <!-- <i class="fa-solid fa-pen-to-square"></i> <a href="/dashboard/invoices/edit?invoice_id={{ $invoice->invoice_id }}" class="underline mr-3">შეცვლა</a> -->
                                    <i class="fa-solid fa-trash"></i> <a href="/dashboard/invoices/delete?invoice_id={{ $invoice->invoice_id }}" class="underline mr-3">წაშლა</a>
                                    <i class="fa-solid fa-money-check-dollar"></i> <a href="/dashboard/invoices/pay?invoice_id={{ $invoice->invoice_id }}" class="underline">გადახა</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
    </x-dashboard>
@include('footer')
