@include("header")
    <x-dashboard :title="$title" :user="$user">
        <div class="flex mt-10">
            @if($user->role == 'admin')
                <div class="flex-1 bg-gray-200 rounded p-5 mr-5">
                    <h2 class="text-xl font-bold text-center"><i class="fa-solid fa-user"></i> მიღებული პაციენტები</h2>
                    <p class="text-5xl font-bold text-center pt-5">{{ $month_users }}</p>
                </div>
                <div class="flex-1 bg-gray-200 rounded p-5 mr-5">
                    <h2 class="text-xl font-bold text-center"><i class="fa-solid fa-file-invoice"></i> მიღებული შემოსავალი</h2>
                    <p class="text-5xl font-bold text-center pt-5">{{ $month_sum }}</p>
                </div>
                <div class="flex-1 bg-gray-200 rounded p-5">
                    <h2 class="text-xl font-bold text-center"><i class="fa-solid fa-chart-simple"></i> საშუალო შემოსავალი</h2>
                    <p class="text-5xl font-bold text-center pt-5">{{ $month_average }}</p>
                </div>
            @endif
        </div>
        <table class="table-auto w-full">
            <thead class="text-left text-lg">
                <tr>
                    <th class="text-xl py-5"><i class="fa-solid fa-user mr-3"></i> ბოლოს მიღებული პაციენტები</th>
                </tr>
                <tr class="bg-gray-200">
                    <th class="p-3">პაციენტი</th>
                    <th class="p-3">პერსონალი</th>
                    <th class="p-3">დრო</th>
                    <th class="p-3">მოქმედება</th>
                </tr>
            </thead>
            <tbody>
                @foreach($consultations as $consultation)
                    <tr class="border-b border-gray-200">
                        <td class="p-3">{{ $consultation->users_first_name }} {{ $consultation->users_last_name }}</td>
                        <td class="p-3">{{ $consultation->doctors_first_name }} {{ $consultation->doctors_last_name }}</td>
                        <td class="p-3">{{ $consultation->consultation_created_at }}</td>
                        <td class="p-3">
                            <i class="fa-solid fa-eye"></i> <a href="/dashboard/users/profile/consultation/view?consultation_id={{ $consultation->consultations_id }}" target="_blank" class="underline">ნახვა</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if($user->role != 'doctor')
            <table class="table-auto w-full">
            <thead class="text-left text-lg">
                <tr>
                    <th class="text-xl py-5"><i class="fa-solid fa-file-invoice mr-3"></i> ბოლოს მიღებული გადახდები</th>
                </tr>
                <tr class="bg-gray-200">
                    <th class="p-3">პაციენტი</th>
                    <th class="p-3">თანხა</th>
                    <th class="p-3">დრო</th>
                    <th class="p-3">მოქმედება</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoices as $invoice)
                    <tr class="border-b border-gray-200">
                        <td class="p-3">{{ $invoice->first_name }} {{ $invoice->last_name }}</td>
                        <td class="p-3">{{ round( $invoice->total - ( ($invoice->total * $invoice->discount) / 100), 2) }}</td>
                        <td class="p-3">{{ $invoice->invoice_created_at }}</td>
                        <td class="p-3">
                            <i class="fa-solid fa-eye"></i> <a href="/dashboard/invoices/view?invoice_id={{ $invoice->invoice_id }}" target="_blank" class="underline">ნახვა</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </x-dashboard>
@include("footer")
