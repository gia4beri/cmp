@include('header')
    <x-dashboard :title="$title" :user="$user">
        <div class="bg-gray-200 p-5">
            <table class="table-auto w-full">
                <tbody>
                    <tr class="text-left">
                        <td class="text-xl py-5 w-1/2"><i class="fa-solid fa-coins mr-3"></i> ვალუტის კურსები</td>
                        <td class="text-xl py-5 w-1/2"><i class="fa-solid fa-image mr-3"></i> ლოგო</td>
                    </tr>
                    <tr>
                        <td>
                            USD <input form="actions" class="w-1/2 rounded px-3 py-1 mr-5 @error('currency_usd') border border-red-400 @enderror" name="currency_usd" value="{{ $currency_usd[0]->option_value }}"><br><br>
                            EUR <input form="actions" class="w-1/2 rounded px-3 py-1 @error('currency_eur') border border-red-400 @enderror" name="currency_eur" value="{{ $currency_eur[0]->option_value }}">
                        </td>
                        <td>
                            @if($portal_logo[0]->option_value)
                                <img class="h-20 mb-5" src="{{ $portal_logo[0]->option_value }}" alt="@if(env('APP_NAME')) {{ env('APP_NAME') }} @endif">
                            @else
                                <div class="mb-5">ლოგო არ არის ატვირთული</div>
                            @endif
                            <label for="logo_upload" class="bg-gray-700 text-white px-3 py-1.5 cursor-pointer"><i class="fa-solid fa-hard-drive mr-1"></i> აირჩიეთ ფაილი</label>
                            <input form="actions" id="logo_upload" class="-ml-3 rounded px-3 py-1 hidden @error('portal_logo') border border-red-400 @enderror" name="portal_logo" type="file">
                        </td>
                    </tr>
                    <tr class="text-left">
                        <td class="text-xl py-5 pt-16" colspan="2"><i class="fa-solid fa-file-invoice"></i> რეკვიზიტები</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <textarea form="actions" class="textarea-toolbars rounded px-3 py-1 mr-5 @error('company_info') border border-red-400 @enderror" name="company_info">{{ $company_info[0]->option_value }}</textarea>
                        </td>
                    </tr>
                </tbody>
            </table>

            <form id="actions" enctype="multipart/form-data" action="/dashboard/options" method="post" class="mt-10">
                @csrf
                @method('PUT')
                <button class="rounded px-3 py-1 bg-gray-700 text-white" type="submit">განახლება</button>
            </form>
        </div>
    </x-dashboard>
@include('footer')
