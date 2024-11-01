@include('header')
<x-dashboard :title="$title" :user="$user">

    <div id="modal-form" class="relative z-10 @if(!$errors->any() && empty($update)) hidden @endif" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center items-center">
                <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all w-11/12">
                    <div class="bg-white px-4 pb-4 pt-5">
                        <div class="flex items-start">
                            <div class="w-full">
                                <div class="bg-gray-200 p-5 rounded">
                                    <form action="/dashboard/users/profile/consultation" method="post" id="actions" enctype="multipart/form-data">
                                        <div class="flex">
                                            <div class="flex-1">
                                                პაციენტის ჩივილები
                                                <textarea class="textarea-toolbars rounded px-3 py-1 w-full block mb-3 @error('patient_complaints') border border-red-400 @enderror" name="patient_complaints"></textarea>
                                                <br>
                                                გასინჯვის აღწერა
                                                <textarea class="textarea-toolbars rounded px-3 py-1 w-full block mb-3 @error('examination_description') border border-red-400 @enderror" name="examination_description"></textarea>
                                                <br>
                                                <input name="user_id" value="{{ $user_id }}" type="hidden">
                                            </div>
                                        </div>
                                        <div class="flex">
                                            <div class="flex-1">
                                                სატურაცია (აუცილებელი ან 0)
                                                <input class="rounded px-3 py-1 w-full block mb-3 @error('saturation') border border-red-400 @enderror" name="saturation" value="@if(!empty($update)){{ $users[0]->saturation }}@endif">
                                            </div>
                                            <div class="flex-1 ml-3">
                                                სიცხე (აუცილებელი ან 0)
                                                <input class="rounded px-3 py-1 w-full block mb-3 @error('temperature') border border-red-400 @enderror" name="temperature" value="@if(!empty($update)){{ $users[0]->temperature }}@endif">
                                            </div>
                                            <div class="flex-1 ml-3">
                                                წნევა (აუცილებელი ან 0)
                                                <input class="rounded px-3 py-1 w-full block mb-3 @error('pressure') border border-red-400 @enderror" name="pressure" value="@if(!empty($update)){{ $users[0]->pressure }}@endif">
                                            </div>
                                            <div class="flex-1 ml-3">
                                                წონა
                                                <input class="rounded px-3 py-1 w-full block mb-3 @error('weight') border border-red-400 @enderror" name="weight" value="@if(!empty($update)){{ $users[0]->weight }}@endif">
                                            </div>
                                            <div class="flex-1 ml-3">
                                                სიმაღლე
                                                <input class="rounded px-3 py-1 w-full block mb-3 @error('height') border border-red-400 @enderror" name="height" value="@if(!empty($update)){{ $users[0]->height }}@endif">
                                            </div>
                                        </div>
                                        <div class="flex">
                                            <div class="flex-1">
                                                დიაგნოზი (ICD კოდი) (აუცილებელი)
                                                <textarea class="textarea-toolbars rounded px-3 py-1 w-full block mb-3 @error('icd_code') border border-red-400 @enderror" name="icd_code"></textarea>
                                                <br>
                                            </div>
                                        </div>
                                        <div class="flex">
                                            <div class="flex-1">
                                                რეკომენდაციები და დანიშნულება (აუცილებელი ან 0)
                                                <textarea class="textarea-toolbars rounded px-3 py-1 w-full block mb-3 @error('recommendations_prescription') border border-red-400 @enderror" name="recommendations_prescription"></textarea>
                                                <br>
                                                დამატებითი ინფორმაცია
                                                <textarea class="textarea-toolbars rounded px-3 py-1 w-full block mb-3 @error('additional_information') border border-red-400 @enderror" name="additional_information"></textarea>
                                                <br>
                                                საბოლოო დანიშნულება (აუცილებელი ან 0)
                                                <textarea class="textarea-toolbars rounded px-3 py-1 w-full block mb-3 @error('final_prescription') border border-red-400 @enderror" name="final_prescription"></textarea>
                                                <br>
                                            </div>
                                        </div>
                                        <div class="flex">
                                            <div class="flex-1">
                                                ჩატარებული კვლევები:
                                                <label for="conducted_studies" class="bg-gray-700 text-white px-3 py-1.5 cursor-pointer"><i class="fa-solid fa-hard-drive mr-1"></i> აირჩიეთ ფაილი</label>
                                                <input id="conducted_studies" name="conducted_studies[]" class="hidden" type="file">
                                            </div>
                                            <div class="flex-1">
                                                კვლევები:
                                                <label for="studies" class="bg-gray-700 text-white px-3 py-1.5 cursor-pointer"><i class="fa-solid fa-hard-drive mr-1"></i> აირჩიეთ ფაილი</label>
                                                <input name="studies[]" id="studies" class="hidden" type="file">
                                            </div>
                                        </div>
                                        @csrf
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                        <button type="submit" form="actions" class="rounded px-3 py-1 bg-gray-700 text-white">@if(!empty($update)) განახლება @else დამატება @endif</button>
                        <button onclick="modal_form_hide('')" class="rounded bg-white px-3 py-1 text-gray-900 ring-1 ring-inset ring-gray-300 mr-3">გაუქმება</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-10">
        <div class="flex">
            <div class="flex-1">
                <h2 class="font-bold text-xl mb-5"><i class="fa-solid fa-address-card mr-3"></i> ინფორმაცია პაციენტის შესახებ</h2>
            </div>
            <div class="flex-1 text-right text-lg">
                <a href="/dashboard/invoices?user_id={{ $user_id  }}" class="rounded px-3 py-1 bg-gray-700 text-white">
                    <i class="fa-solid fa-circle-plus"></i> ინვოისის დამატება
                </a>
            </div>
        </div>
        <div class="flex mb-3 bg-gray-200 p-5">
            <div class="flex-1">
                <strong>სახელი და გვარი:</strong> {{ $user_data->first_name }} {{ $user_data->last_name }}<br>
                <strong>დაბ. თარიღი:</strong> {{ $user_data->birth_date }}<br>
                <strong>სქესი:</strong> {{ $user_data->gender }}<br>
                <strong>პირადი ნომერი:</strong> {{ $user_data->personal_number }}<br>
            </div>
            <div class="flex-1">
                @if(!empty($user_data->parent_first_name))
                    <strong>მშობელი:</strong> {{ $user_data->parent_first_name }} {{ $user_data->parent_last_name }}<br>
                @endif
                <strong>ტელეფონი:</strong> {{ $user_data->phone }}<br>
                <strong>ელ. ფოსტა:</strong> {{ $user_data->email }}<br>
                <strong>მისამართი:</strong> {{ $user_data->address }}<br>
            </div>
            <div class="flex-1">
                <strong>მოქალაქეობა:</strong> {{ $user_data->citizenship }}<br>
                <strong>დაზღვევა:</strong> {{ $user_data->insurance }}<br>
                <strong>საიდან გაიგეთ:</strong> {{ $user_data->referral_source }}<br>
            </div>
        </div>
    </div>
    <table class="table-auto w-full">
        <thead class="text-left text-lg">
        <tr>
            <th class="text-xl py-5" colspan="3"><i class="fa-solid fa-suitcase-medical mr-3"></i> კონსულტაციები</th>
            <th class="py-5 text-right">
                <button onclick="modal_form_show()" class="rounded px-3 py-1 bg-gray-700 text-white">
                    <i class="fa-solid fa-circle-plus"></i> დამატება
                </button>
            </th>
        </tr>
        <tr class="text-base bg-gray-200 p-3">
            <th class="p-3 text-right" colspan="4">
                @if($consultations->previousPageUrl()) <a href="{{ $consultations->previousPageUrl() }}"><i class="fa-solid fa-circle-chevron-left"></i></a> @endif
                @if($consultations->nextPageUrl()) <a href="{{ $consultations->nextPageUrl() }}"><i class="fa-solid fa-circle-chevron-right"></i></a> @endif
            </th>
        </tr>
        <tr class="text-base bg-gray-200 p-3">
            <th class="p-3">თარიღი</th>
            <th class="p-3">ექიმი</th>
            <th class="p-3">სპეციალობა</th>
            <th class="p-3">მოქმედებები</th>
        </tr>
        </thead>
        <tbody>
        @foreach($consultations as $consultation)
            <tr>
                <td class="p-3">{{ $consultation->created_at }}</td>
                <td class="p-3">{{ $consultation->first_name }} {{ $consultation->last_name }}</td>
                <td class="p-3">{{ $consultation->proficiency }}</td>
                <td class="p-3">
                    <i class="fa-solid fa-eye"></i> <a target="_blank" class="underline mr-3" href="/dashboard/users/profile/consultation/view?consultation_id={{ $consultation->id }}">ნახვა</a>
                    <i class="fa-solid fa-trash"></i> <a href="/dashboard/users/profile/consultation/delete?consultation_id={{ $consultation->id }}&amp;user_id={{ $user_data->id }}" class="underline">წაშლა</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    @if(!empty($user) && ($user->role == 'admin' || $user->role == 'recipient'))
    <table class="table-auto w-full mt-10">
        <thead class="text-left text-lg">
        <tr>
            <th class="text-xl py-5" colspan="4"><i class="fa-solid fa-file-invoice mr-3"></i> ინვოისები</th>
        </tr>
        <tr class="text-base bg-gray-200 p-3">
            <th class="p-3 text-right" colspan="4">
                @if($invoices->previousPageUrl()) <a href="{{ $invoices->previousPageUrl() }}"><i class="fa-solid fa-circle-chevron-left"></i></a> @endif
                @if($invoices->nextPageUrl()) <a href="{{ $invoices->nextPageUrl() }}"><i class="fa-solid fa-circle-chevron-right"></i></a> @endif
            </th>
        </tr>
        <tr class="text-base bg-gray-200 p-3">
            <th class="p-3">ინვ. ნომერი</th>
            <th class="p-3">თანხა</th>
            <th class="p-3">გადახდილი</th>
            <th class="p-3">მოქმედებები</th>
        </tr>
        </thead>
        <tbody>
        @foreach($invoices as $invoice)
            <tr>
                <td class="p-3">{{ date('Ymd', strtotime($invoice->created_at)) }}-{{$invoice->id}}</td>
                <td class="p-3">{{ round($invoice->total - ( ($invoice->total * $invoice->discount) / 100 ), 2) }}</td>
                <td class="p-3">@if($invoice->status) გადახდილი @else გადაუხდელი @endif</td>
                <td class="p-3">
                    <i class="fa-solid fa-eye"></i> <a target="_blank" href="/dashboard/invoices/view?invoice_id={{ $invoice->id }}" class="underline mr-3">ნახვა</a>
                    @if(!$invoice->status)
                        <!-- <i class="fa-solid fa-pen-to-square"></i> <a href="/dashboard/invoices/edit?invoice_id={{ $invoice->id }}" class="underline mr-3">შეცვლა</a>
                        <i class="fa-solid fa-trash"></i> <a href="/dashboard/invoices/delete?invoice_id={{ $invoice->id }}" class="underline mr-3">წაშლა</a>
                        <i class="fa-solid fa-money-check-dollar"></i> <a href="/dashboard/invoices/pay?invoice_id={{ $invoice->id }}" class="underline">გადახა</a> -->
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    @endif

    <table class="table-auto w-full mt-10">
        <thead class="text-left text-lg">
        <tr>
            <th class="text-xl py-5" colspan="2"><i class="fa-solid fa-file-word mr-3"></i> მიმაგრებული ფაილები</th>
            <th class="py-5 text-right" colspan="2">
                <form action="/dashboard/users/files" method="post" enctype="multipart/form-data">
                    <label for="user_files" class="bg-gray-200 px-3 py-1.5 -mr-2 cursor-pointer"><i class="fa-solid fa-hard-drive mr-1"></i> აირჩიეთ ფაილი</label>
                    <input class="hidden" id="user_files" type="file" name="user_files[]" multiple>
                    <input type="hidden" name="user_id" value="{{ $user_data->id }}">
                    <button class="rounded px-3 py-1 bg-gray-700 text-white">
                        <i class="fa-solid fa-upload"></i> ატვირთვა
                    </button>
                    @csrf
                </form>
            </th>
        </tr>
        <tr class="text-base bg-gray-200 p-3">
            <th class="p-3 text-right" colspan="4">
                @if($files->previousPageUrl()) <a href="{{ $files->previousPageUrl() }}"><i class="fa-solid fa-circle-chevron-left"></i></a> @endif
                @if($files->nextPageUrl()) <a href="{{ $files->nextPageUrl() }}"><i class="fa-solid fa-circle-chevron-right"></i></a> @endif
            </th>
        </tr>
        <tr class="text-base bg-gray-200 p-3">
            <th class="p-3">თარიღი</th>
            <th class="p-3">ექიმი</th>
            <th class="p-3">ფაილის სახელი</th>
            <th class="p-3">მოქმედებები</th>
        </tr>
        </thead>
        <tbody>
        @foreach($files as $file)
            <tr>
                <td class="p-3">{{ $file->created_at }}</td>
                <td class="p-3">{{ $file->first_name }} {{ $file->last_name }}</td>
                <td class="p-3">
                    {{ $file->file_name }}
                </td>
                <td class="p-3">
                    <i class="fa-solid fa-circle-down"></i> <a class="underline mr-3" href="{{ $file->file_path }}" download>ჩამოტვირთვა</a>
                    <i class="fa-solid fa-eye"></i> <a class="underline mr-3" target="_blank" href="{{ $file->file_path }}">ნახვა</a>
                    <i class="fa-solid fa-trash"></i> <a class="underline" href="/dashboard/users/files/delete?file_id={{ $file->id }}&amp;user_id={{ $user_data->id }}">წაშლა</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

</x-dashboard>
@include('footer')
