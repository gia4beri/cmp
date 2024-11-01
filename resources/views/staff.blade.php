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
                                    <div class="bg-gray-200 p-5">
                                        <form action="/dashboard/staff" method="post" id="modal">
                                            @if(!empty($update)) @method('PUT') @endif
                                            <div class="flex">
                                                <div class="flex-1">
                                                    მომხმარებელი
                                                    <input class="w-full rounded px-3 py-1 block mb-3 @error('username') border border-red-400 @enderror" name="username" value="@if(!empty($update)){{ $users[0]->username }}@endif">
                                                    პაროლი
                                                    <input type="password" class="w-full rounded px-3 py-1 block mb-3 @error('password') border border-red-400 @enderror" name="password" value="">
                                                    ელ. ფოსტა (არასავალდებულო)
                                                    <input class="w-full rounded px-3 py-1 block mb-3 @error('email') border border-red-400 @enderror" name="email" value="@if(!empty($update)){{ $users[0]->email }}@endif">
                                                    უფლებები
                                                    <select id="select-role" name="role" class="w-full rounded px-3 py-1 block mb-3 @error('role') border border-red-400 @enderror">
                                                        @if(!empty($update)) <option value="{{ $users[0]->role }}">მიმდინარე უფლებები</option> @endif
                                                        @foreach($roles as $role)
                                                            @if($role->slug != 'user')
                                                                <option value="{{ $role->slug }}">{{ $role->description }}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="flex-1 ml-3">
                                                    სახელი
                                                    <input class="w-full rounded px-3 py-1 block mb-3 @error('first_name') border border-red-400 @enderror" name="first_name" value="@if(!empty($update)){{ $users[0]->first_name }}@endif">
                                                    გვარი
                                                    <input class="w-full rounded px-3 py-1 block mb-3 @error('last_name') border border-red-400 @enderror" name="last_name" value="@if(!empty($update)){{ $users[0]->last_name }}@endif">
                                                    ტელეფონი
                                                    <input class="w-full rounded px-3 py-1 block mb-3 @error('phone') border border-red-400 @enderror" name="phone" value="@if(!empty($update)){{ $users[0]->phone }}@endif">
                                                    სპეციალობა
                                                    <input id="input-proficiency" class="disabled:bg-gray-100 w-full block rounded px-3 py-1 mb-3 @error('proficiency') border border-red-400 @enderror" name="proficiency" value="@if(!empty($update)){{ $users[0]->proficiency }}@endif" disabled>
                                                    კონსულტაციის ფასი
                                                    <input id="input-consultation-price" class="disabled:bg-gray-100 w-full block rounded px-3 py-1 mb-3 @error('consultation_price') border border-red-400 @enderror" name="consultation_price" value="@if(!empty($update)){{ $users[0]->consultation_price }}@endif" disabled>
                                                </div>
                                            </div>
                                            @csrf
                                            @if(!empty($update)) <input type="hidden" name="user_id" value="{{ $users[0]->id }}">  @endif
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                            <button type="submit" form="modal" class="rounded px-3 py-1 bg-gray-700 text-white">@if(!empty($update)) განახლება @else დამატება @endif</button>
                            <button onclick="modal_form_hide('/dashboard/staff')" class="rounded bg-white px-3 py-1 text-gray-900 ring-1 ring-inset ring-gray-300 mr-3">გაუქმება</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <table class="table-auto w-full">
            <thead class="text-left text-lg">
            <tr>
                <th class="text-xl py-5" colspan="6"><i class="fa-solid fa-user-nurse mr-3"></i> ბაზაში არსებული პერსონალი</th>
                <th class="py-5 text-right"><button onclick="modal_form_show()" class="rounded px-3 py-1 bg-gray-700 text-white"><i class="fa-solid fa-circle-plus"></i> დამატება</button></th>
            </tr>
            <tr class="text-base bg-gray-200 p-3">
                <th class="p-3" colspan="6">
                    <form action="/dashboard/staff" method="post">
                        @csrf
                        @method('PATCH')
                        <input class="rounded px-3 py-1 mr-3 w-1/2 @error('staff_search') border border-red-400 @enderror" name="staff_search" placeholder="სახელი, გვარი, ტელეფონი, ელ. ფოსტა, სპეციალობა, უფლებები">
                        <button class="rounded px-3 py-1 bg-gray-700 text-white" type="submit">ძებნა</button>
                    </form>
                </th>
                <th class="p-3 text-right">
                    @if($users->previousPageUrl()) <a href="{{ $users->previousPageUrl() }}"><i class="fa-solid fa-circle-chevron-left"></i></a> @endif
                    @if($users->nextPageUrl()) <a href="{{ $users->nextPageUrl() }}"><i class="fa-solid fa-circle-chevron-right"></i></a> @endif
                </th>
            </tr>
            <tr class="bg-gray-200">
                <th class="p-3">სახელი</th>
                <th class="p-3">გვარი</th>
                <th class="p-3">ტელეფონი</th>
                <th class="p-3">ელ. ფოსტა</th>
                <th class="p-3">სპეციალობა</th>
                <th class="p-3">უფლებები</th>
                <th class="p-3">მოქმედებები</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr class="border-b border-gray-200">
                    <td class="p-3">{{ $user->first_name }}</td>
                    <td class="p-3">{{ $user->last_name }}</td>
                    <td class="p-3">{{ $user->phone }}</td>
                    <td class="p-3">{{ $user->email }}</td>
                    <td class="p-3">{{ $user->proficiency }}</td>
                    <td class="p-3">{{ $user->role_description }}</td>
                    <td class="p-3">
                        <i class="fa-solid fa-trash"></i> <a href="/dashboard/staff/delete?user_id={{ $user->user_id }}" class="underline mr-3">წაშლა</a>
                        <i class="fa-solid fa-pen-to-square"></i> <a class="underline" href="/dashboard/staff/edit?user_id={{ $user->user_id }}">შეცვლა</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </x-dashboard>
@include('footer')
