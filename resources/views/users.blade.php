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
                                        <form action="/dashboard/users" method="post" id="actions">
                                            @if(!empty($update)) @method('PUT') @endif
                                            <div class="flex">
                                                <div class="flex-1">
                                                    სახელი
                                                    <input class="rounded px-3 py-1 w-full block mb-3 @error('first_name') border border-red-400 @enderror" name="first_name" value="@if(!empty($update)){{ $users[0]->first_name }}@endif">
                                                    გვარი
                                                    <input class="rounded px-3 py-1 w-full block mb-3 @error('last_name') border border-red-400 @enderror" name="last_name" value="@if(!empty($update)){{ $users[0]->last_name }}@endif">
                                                    პირადი ნომერი
                                                    <input class="rounded px-3 py-1 w-full block mb-3 @error('personal_number') border border-red-400 @enderror" name="personal_number" value="@if(!empty($update)){{ $users[0]->personal_number }}@endif">
                                                    დაბადების თარიღი
                                                    <input id="birth-date" class="rounded px-3 py-1 w-full block mb-3 @error('birth_date') border border-red-400 @enderror" name="birth_date" value="@if(!empty($update)){{ $users[0]->birth_date }}@endif" type="date">
                                                    სქესი
                                                    <select name="gender" class="rounded px-3 py-1 w-full mb-3 @error('gender') border border-red-400 @enderror">
                                                        <option @if(!empty($users[0]->gender) && $users[0]->gender =='მამრობითი') selected @endif>მამრობითი</option>
                                                        <option @if(!empty($users[0]->gender) && $users[0]->gender =='მდედრობითი') selected @endif>მდედრობითი</option>
                                                        <option @if(!empty($users[0]->gender) && $users[0]->gender =='სხვა') selected @endif>სხვა</option>
                                                    </select>
                                                    მშობლის სახელი
                                                    <input id="parent_first_name" class="disabled:bg-gray-100 rounded px-3 py-1 w-full block mb-3 @error('parent_first_name') border border-red-400 @enderror" name="parent_first_name" value="@if(!empty($update)){{ $users[0]->parent_first_name }}@endif" disabled>
                                                    მშობლის გვარი
                                                    <input id="parent_last_name" class="disabled:bg-gray-100 rounded px-3 py-1 w-full block mb-3 @error('parent_last_name') border border-red-400 @enderror" name="parent_last_name" value="@if(!empty($update)){{ $users[0]->parent_last_name }}@endif" disabled>
                                                    მშობლის პ/ნ
                                                    <input id="parent_personal_number" class="disabled:bg-gray-100 rounded px-3 py-1 w-full block mb-3 @error('parent_personal_number') border border-red-400 @enderror" name="parent_personal_number" value="@if(!empty($update)){{ $users[0]->parent_personal_number }}@endif" disabled>
                                                </div>
                                                <div class="flex-1 ml-3">
                                                    ფიზიკური მისამართი
                                                    <input class="rounded px-3 py-1 w-full block mb-3 @error('address') border border-red-400 @enderror" name="address" value="@if(!empty($update)){{ $users[0]->address }}@endif">
                                                    მოქალაქეობა (არასავალდებულო)
                                                    <input class="rounded px-3 py-1 w-full block mb-3 @error('citizenship') border border-red-400 @enderror" name="citizenship" value="@if(!empty($update)){{ $users[0]->citizenship }}@endif">
                                                    ტელეფონი
                                                    <input class="rounded px-3 py-1 w-full block mb-3 @error('phone') border border-red-400 @enderror" name="phone" value="@if(!empty($update)){{ $users[0]->phone }}@endif">
                                                    ელ. ფოსტა (არასავალდებულო)
                                                    <input class="rounded px-3 py-1 w-full block mb-3 @error('email') border border-red-400 @enderror" name="email" value="@if(!empty($update)){{ $users[0]->email }}@endif">
                                                    დაზღვევა (არასავალდებულო)
                                                    <input class="rounded px-3 py-1 w-full block mb-3 @error('insurance') border border-red-400 @enderror" name="insurance" value="@if(!empty($update)){{ $users[0]->insurance }}@endif">
                                                    საიდან გაიგეთ?
                                                    <select class="rounded px-3 py-1 w-full block mb-3 mt-0.5 @error('referral_source') border border-red-400 @enderror" name="referral_source">
                                                        <option @if(!empty($users[0]->referral_source) && $users[0]->referral_source =='პასუხის გარეშე') selected @endif>პასუხის გარეშე</option>
                                                        <option @if(!empty($users[0]->referral_source) && $users[0]->referral_source =='სოციალური მედია') selected @endif>სოციალური მედია</option>
                                                        <option @if(!empty($users[0]->referral_source) && $users[0]->referral_source =='საძიებო სისტემა') selected @endif>საძიებო სისტემა</option>
                                                        <option @if(!empty($users[0]->referral_source) && $users[0]->referral_source =='მეგობარი / ოჯახი') selected @endif>მეგობარი / ოჯახი</option>
                                                        <option @if(!empty($users[0]->referral_source) && $users[0]->referral_source =='რეკლამიდან') selected @endif>რეკლამიდან</option>
                                                        <option @if(!empty($users[0]->referral_source) && $users[0]->referral_source =='ღონისძიებიდან') selected @endif>ღონისძიებიდან</option>
                                                    </select>
                                                </div>
                                            </div>
                                            @csrf
                                            @if(!empty($update)) <input type="hidden" name="user_id" value="{{ $users[0]->id }}"> @endif
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                            <button type="submit" form="actions" class="rounded px-3 py-1 bg-gray-700 text-white">@if(!empty($update)) განახლება @else დამატება @endif</button>
                            <button onclick="modal_form_hide('/dashboard/users')" class="rounded bg-white px-3 py-1 text-gray-900 ring-1 ring-inset ring-gray-300 mr-3">გაუქმება</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <table class="table-auto w-full">
            <thead class="text-left text-lg">
            <tr>
                <th class="text-xl py-5" colspan="5"><i class="fa-solid fa-user mr-3"></i> პაციენტები</th>
                <th class="py-5 text-right">
                    <button onclick="modal_form_show()" class="rounded px-3 py-1 bg-gray-700 text-white">
                        <i class="fa-solid fa-circle-plus"></i> დამატება
                    </button>
                </th>
            </tr>
            <tr class="text-base bg-gray-200 p-3">
                <th class="p-3" colspan="5">
                    <form action="/dashboard/users" method="post">
                        @csrf
                        @method('PATCH')
                        <input class="rounded px-3 py-1 mr-3 w-1/2 @error('user_search') border border-red-400 @enderror" name="user_search" placeholder="სახელი, გვარი, ტელეფონი, პ/ნ, ელ. ფოსტა">
                        <button class="rounded px-3 py-1 bg-gray-700 text-white" type="submit">ძებნა</button>
                    </form>
                </th>
                <th class="p-3 text-right">
                    @if($users->previousPageUrl()) <a href="{{ $users->previousPageUrl() }}"><i class="fa-solid fa-circle-chevron-left"></i></a> @endif
                    @if($users->nextPageUrl()) <a href="{{ $users->nextPageUrl() }}"><i class="fa-solid fa-circle-chevron-right"></i></a> @endif
                </th>
            </tr>
            <tr class="bg-gray-200">
                <th class="p-3 rounded">სახელი</th>
                <th class="p-3">გვარი</th>
                <th class="p-3">პ/ნ</th>
                <th class="p-3">ტელეფონი</th>
                <th class="p-3">ელ. ფოსტა</th>
                <th class="p-3 rounded">მოქმედებები</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr class="border-b border-gray-200">
                    <td class="p-3">{{ $user->first_name }}</td>
                    <td class="p-3">{{ $user->last_name }}</td>
                    <td class="p-3">{{ $user->personal_number }}</td>
                    <td class="p-3">{{ $user->phone }}</td>
                    <td class="p-3">{{ $user->email }}</td>
                    <td class="p-3">
                        <i class="fa-solid fa-trash"></i> <a href="/dashboard/users/delete?user_id={{ $user->id }}" class="underline mr-3">წაშლა</a>
                        <i class="fa-solid fa-pen-to-square"></i> <a class="underline mr-3" href="/dashboard/users/edit?user_id={{ $user->id }}">შეცვლა</a>
                        <i class="fa-solid fa-address-card"></i> <a class="underline" href="/dashboard/users/profile?user_id={{ $user->id }}">პროფილი</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </x-dashboard>
@include('footer')
