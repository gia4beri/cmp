@include('header')
    <div class="w-full p-5 m-auto">
        <div class="flex">
            <div class="flex-1 text-right">
                @if($logo->option_value)
                    <img src="{{ $logo->option_value }}" class="h-32">
                @else
                    {{ env('APP_NAME') }}
                @endif
            </div>
            <div class="flex-1 text-right">
                <a href="#!" onclick="window.print();"><i class="fa-solid fa-print"></i> ამობეჭდვა</a>
            </div>
        </div>
        <div class="flex mt-10">
            <div class="flex-1">
                <h2 class="font-bold text-2xl border-b border-black pb-2 inline-block">დანართი N6</h2>
                <h4 class="font-bold text-base mt-3">ამბულატორიული მომსახურების მიწოდება</h4>
                <h4 class="font-bold text-base">პირის დაწესებულების დასახელება: შპს გს კომპანი პრო</h4>
                <h3 class="font-bold text-xl mt-3">ფორმა N5-200-5/ა</h3>
                <h4 class="font-bold text-base">პაციენტის გასინჯვის ფურცელი</h4>
                <h4 class="font-bold text-base">კონსულტაციის სახე: {{ $doctor->proficiency }} (ექიმის პროფესია)</h4>
                <h4 class="font-bold text-base">სამედიცინო ბარათი N ______________________ </h4>
                <h4 class="font-bold text-base">
                    პაციენტი: {{ $consultation->first_name }} {{ $consultation->last_name }}, პ/ნ {{ $consultation->personal_number }},
                    <br>
                    დაბ. თარიღი: {{ $consultation->birth_date }}, მოქალაქეობა: {{ $consultation->citizenship }}
                </h4>
            </div>
            <div class="flex-1 text-right">
                კონსულტაცია შეიქმნა: {{ $consultation->consultation_created_at }}
            </div>
        </div>
        <div class="w-full mt-10">
            <div class="bg-gray-200 p-5 rounded">
                    <div class="flex">
                        <div class="flex-1">
                            <h4 class="font-bold text-xl">პაციენტის ჩივილები</h4>
                            <div class="rounded px-3 py-1 w-full block mb-3 bg-white">{!! $consultation->patient_complaints !!}</div>
                            <br>
                            <h4 class="font-bold text-xl">გასინჯვის აღწერა</h4>
                            <div class="rounded px-3 py-1 w-full block mb-3 bg-white">{!! $consultation->examination_description !!}</div>
                            <br>
                        </div>
                    </div>
                    <div class="flex">
                        <div class="flex-1">
                            <h4 class="font-bold text-xl">სატურაცია</h4>
                            <div class="rounded px-3 py-1 w-full block mb-3 bg-white">{{ $consultation->saturation }}</div>
                        </div>
                        <div class="flex-1 ml-3">
                            <h4 class="font-bold text-xl">სიცხე</h4>
                            <div class="rounded px-3 py-1 w-full block mb-3 bg-white">{{ $consultation->temperature }}</div>
                        </div>
                        <div class="flex-1 ml-3">
                            <h4 class="font-bold text-xl">წნევა</h4>
                            <div class="rounded px-3 py-1 w-full block mb-3 bg-white">{{ $consultation->pressure }}</div>
                        </div>
                        <div class="flex-1 ml-3">
                            <h4 class="font-bold text-xl">წონა</h4>
                            <div class="rounded px-3 py-1 w-full block mb-3 bg-white">{{ $consultation->weight }}</div>
                        </div>
                        <div class="flex-1 ml-3">
                            <h4 class="font-bold text-xl">სიმაღლე</h4>
                            <div class="rounded px-3 py-1 w-full block mb-3 bg-white">{{ $consultation->height }}</div>
                        </div>
                    </div>
                    <div class="flex">
                        <div class="flex-1">
                            <br>
                            <h4 class="font-bold text-xl">დიაგნოზი (ICD კოდი)</h4>
                            <div class="rounded px-3 py-1 w-full block mb-3 bg-white">{!! $consultation->icd_code !!}</div>
                            <br>
                        </div>
                    </div>
                    <div class="flex">
                        <div class="flex-1">
                            <h4 class="font-bold text-xl">რეკომენდაციები და დანიშნულება</h4>
                            <div class="rounded px-3 py-1 w-full block mb-3 bg-white">{!! $consultation->recommendations_prescription !!}</div>
                            <br>
                            <h4 class="font-bold text-xl">დამატებითი ინფორმაცია</h4>
                            <div class="rounded px-3 py-1 w-full block mb-3 bg-white">{!! $consultation->additional_information !!}</div>
                            <br>
                            <h4 class="font-bold text-xl">საბოლოო დანიშნულება</h4>
                            <div class="rounded px-3 py-1 w-full block mb-3 bg-white">{!! $consultation->final_prescription !!}</div>
                            <br>
                        </div>
                    </div>
                    <div class="" id="no-print">
                        <table class="table-auto w-full">
                            <thead class="text-left text-lg">
                            <tr>
                                <th class="text-xl py-5" colspan="4"><i class="fa-solid fa-file-word mr-3"></i> ჩატარებული კვლევები</th>
                            </tr>
                            <tr class="text-base bg-gray-200 p-3">
                                <th class="p-3">თარიღი</th>
                                <th class="p-3">ექიმი</th>
                                <th class="p-3">ფაილის სახელი</th>
                                <th class="p-3">მოქმედებები</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($conducted_studies as $file)
                                <tr>
                                    <td class="p-3">{{ $file->created_at }}</td>
                                    <td class="p-3">{{ $file->first_name }} {{ $file->last_name }}</td>
                                    <td class="p-3">
                                        {{ $file->file_name }}
                                    </td>
                                    <td class="p-3">
                                        <i class="fa-solid fa-circle-down"></i> <a class="underline mr-3" href="{{ $file->file_path }}" download>ჩამოტვირთვა</a>
                                        <i class="fa-solid fa-eye"></i> <a class="underline mr-3" target="_blank" href="{{ $file->file_path }}">ნახვა</a>
                                        <i class="fa-solid fa-trash"></i> <a class="underline" href="/dashboard/users/files/delete?file_id={{ $file->id }}">წაშლა</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <table class="table-auto w-full mt-10">
                            <thead class="text-left text-lg">
                            <tr>
                                <th class="text-xl py-5" colspan="4"><i class="fa-solid fa-file-word mr-3"></i>კვლევები</th>
                            </tr>
                            <tr class="text-base bg-gray-200 p-3">
                                <th class="p-3">თარიღი</th>
                                <th class="p-3">ექიმი</th>
                                <th class="p-3">ფაილის სახელი</th>
                                <th class="p-3">მოქმედებები</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($studies as $file)
                                <tr>
                                    <td class="p-3">{{ $file->created_at }}</td>
                                    <td class="p-3">{{ $file->first_name }} {{ $file->last_name }}</td>
                                    <td class="p-3">
                                        {{ $file->file_name }}
                                    </td>
                                    <td class="p-3">
                                        <i class="fa-solid fa-circle-down"></i> <a class="underline mr-3" href="{{ $file->file_path }}" download>ჩამოტვირთვა</a>
                                        <i class="fa-solid fa-eye"></i> <a class="underline mr-3" target="_blank" href="{{ $file->file_path }}">ნახვა</a>
                                        <i class="fa-solid fa-trash"></i> <a class="underline" href="/dashboard/users/files/delete?file_id={{ $file->id }}">წაშლა</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="hidden" id="print">
                        * მიბმული ფაილების სანახავად ეწვიეთ ონლაინ პორტალს.
                    </div>
            </div>
        </div>
        <div class="flex mt-36">
            <div class="flex-1">

            </div>
            <div class="flex-1">

            </div>
            <div class="flex-1 text-xl py-20">
                ექიმი: {{ $doctor->first_name }} {{ $doctor->last_name }}<br><br>
                ხელმოწერა: _______________________
            </div>
        </div>
    </div>
@include('footer')
