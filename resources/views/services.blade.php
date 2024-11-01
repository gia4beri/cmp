@include("header")
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
                                        <form action="/dashboard/services" method="post" id="modal">
                                            @if(!empty($update)) @method('PUT') @endif
                                            <div class="flex">
                                                <div class="flex-1">
                                                    სერვისის სახელი
                                                    <input class="rounded px-3 py-1 w-full block mb-3 @error('service_name') border border-red-400 @enderror" name="service_name" value="@if(!empty($update)){{ $services[0]->service_name }}@endif">
                                                </div>
                                                <div class="flex-1 ml-3">
                                                    სერვისის ფასი (123.45)
                                                    <input class="rounded px-3 py-1 w-full block mb-3 @error('service_price') border border-red-400 @enderror" name="service_price" value="@if(!empty($update)){{ $services[0]->service_price }}@endif">
                                                </div>
                                            </div>
                                            <div class="flex">
                                                <div class="flex-1">
                                                    სერვისის სრული აღწერა (არასავალდებულო)
                                                    <input class="rounded px-3 py-1 w-full block mb-3 @error('service_description') border border-red-400 @enderror" name="service_description" value="@if(!empty($update)){{ $services[0]->service_description }}@endif">
                                                </div>
                                            </div>
                                            @csrf
                                            @if(!empty($update)) <input type="hidden" name="service_id" value="{{ $services[0]->id }}">  @endif
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                            <button type="submit" form="modal" class="rounded px-3 py-1 bg-gray-700 text-white">@if(!empty($update)) განახლება @else დამატება @endif</button>
                            <button onclick="modal_form_hide('/dashboard/services')" class="rounded bg-white px-3 py-1 text-gray-900 ring-1 ring-inset ring-gray-300 mr-3">გაუქმება</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <table class="table-auto w-full">
            <thead class="text-left text-lg">
            <tr>
                <th class="text-xl py-5" colspan="3"><i class="fa-solid fa-suitcase-medical mr-3"></i>ბაზაში არსებული სერვისები</th>
                <th class="py-5 text-right"><button onclick="modal_form_show()" class="rounded px-3 py-1 bg-gray-700 text-white"><i class="fa-solid fa-circle-plus"></i> დამატება</button></th>
            </tr>
            <tr class="text-base bg-gray-200 p-3">
                <th class="p-3" colspan="3">
                    <form action="/dashboard/services" method="post">
                        @csrf
                        @method('PATCH')
                        <input class="rounded px-3 py-1 w-1/2 mr-3 @error('service_search') border border-red-400 @enderror" name="service_search" placeholder="სერვისის სახელი, ფასი ან აღწერა">
                        <button class="rounded px-3 py-1 bg-gray-700 text-white" type="submit">ძებნა</button>
                    </form>
                </th>
                <th class="p-3 text-right">
                    @if($services->previousPageUrl()) <a href="{{ $services->previousPageUrl() }}"><i class="fa-solid fa-circle-chevron-left"></i></a> @endif
                    @if($services->nextPageUrl()) <a href="{{ $services->nextPageUrl() }}"><i class="fa-solid fa-circle-chevron-right"></i></a> @endif
                </th>
            </tr>
            <tr class="bg-gray-200">
                <th class="p-3 rounded">სერვისის სახელი</th>
                <th class="p-3">სერვისის ფასი</th>
                <th class="p-3">სერვისის აღწერა</th>
                <th class="p-3 rounded">მოქმედებები</th>
            </tr>
            </thead>
            <tbody>
                @foreach($services as $service)
                    <tr class="border-b border-gray-200">
                        <td class="p-3">{{ $service->service_name }}</td>
                        <td class="p-3">{{ $service->service_price }}</td>
                        <td class="p-3">{{ $service->service_description }}</td>
                        <td class="p-3">
                            <i class="fa-solid fa-trash"></i> <a href="/dashboard/services/delete?service_id={{ $service->id }}" class="underline mr-3">წაშლა</a>
                            <i class="fa-solid fa-pen-to-square"></i> <a href="/dashboard/services/edit?service_id={{ $service->id }}" class="underline">შეცვლა</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </x-dashboard>
@include("footer")
