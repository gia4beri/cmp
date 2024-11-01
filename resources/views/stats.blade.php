@include('header')
    <x-dashboard :title="$title" :user="$user">
        <div class="mt-5">
            <div class="flex">
                <div class="flex-1">
                    <form action="/dashboard/export" method="get">
                        ფილტრი: <input name="from" class="bg-gray-200 p-1 rounded" type="date">-დან
                        <input name="to" class="bg-gray-200 p-1 rounded" type="date">-მდე
                        <button type="submit" name="users" value="1" class="rounded px-3 py-1 bg-gray-700 text-white"><i class="fa-solid fa-download"></i> პაციენტები </button>
                        <button type="submit" name="invoices" value="1" class="rounded px-3 py-1 bg-gray-700 text-white"><i class="fa-solid fa-download"></i> ინვოისები </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="mt-10">
            <div class="flex">
                <div class="flex-1">
                    <h2 class="font-bold text-xl mb-3">დღის სტატისტიკა</h2>
                </div>
                <div class="flex-1 text-right">
                    <div class="">
                        <!--
                        <i class="fa-solid fa-download"></i>
                        <a href="#">პაციენტები</a> | <a href="">ინვოისები</a>
                        -->
                    </div>
                </div>
            </div>
            <div class="flex">
                <div class="flex-1 bg-gray-200 rounded p-5 mr-5">
                    <h2 class="text-xl font-bold text-center"><i class="fa-solid fa-user"></i> მიღებული პაციენტები</h2>
                    <p class="text-5xl font-bold text-center pt-5">{{ $day_users }}</p>
                </div>
                <div class="flex-1 bg-gray-200 rounded p-5 mr-5">
                    <h2 class="text-xl font-bold text-center"><i class="fa-solid fa-file-invoice"></i> მიღებული შემოსავალი</h2>
                    <p class="text-5xl font-bold text-center pt-5">{{ $day_sum }}</p>
                </div>
                <div class="flex-1 bg-gray-200 rounded p-5">
                    <h2 class="text-xl font-bold text-center"><i class="fa-solid fa-chart-simple"></i> საშუალო შემოსავალი</h2>
                    <p class="text-5xl font-bold text-center pt-5">{{ $day_average }}</p>
                </div>
            </div>
        </div>
        <div class="mt-10">
            <div class="flex">
                <div class="flex-1">
                    <h2 class="font-bold text-xl mb-3">კვირის სტატისტიკა</h2>
                </div>
                <div class="flex-1 text-right">
                    <div class="">
                        <!--
                        <i class="fa-solid fa-download"></i>
                        <a href="#">პაციენტები</a> | <a href="">ინვოისები</a>
                        -->
                    </div>
                </div>
            </div>
            <div class="flex">
                <div class="flex-1 bg-gray-200 rounded p-5 mr-5">
                    <h2 class="text-xl font-bold text-center"><i class="fa-solid fa-user"></i> მიღებული პაციენტები</h2>
                    <p class="text-5xl font-bold text-center pt-5">{{ $week_users }}</p>
                </div>
                <div class="flex-1 bg-gray-200 rounded p-5 mr-5">
                    <h2 class="text-xl font-bold text-center"><i class="fa-solid fa-file-invoice"></i> მიღებული შემოსავალი</h2>
                    <p class="text-5xl font-bold text-center pt-5">{{ $week_sum }}</p>
                </div>
                <div class="flex-1 bg-gray-200 rounded p-5">
                    <h2 class="text-xl font-bold text-center"><i class="fa-solid fa-chart-simple"></i> საშუალო შემოსავალი</h2>
                    <p class="text-5xl font-bold text-center pt-5">{{ $week_average }}</p>
                </div>
            </div>
        </div>
        <div class="mt-10">
            <div class="flex">
                <div class="flex-1">
                    <h2 class="font-bold text-xl mb-3">თვის სტატისტიკა</h2>
                </div>
                <div class="flex-1 text-right">
                    <div class="">
                        <!--
                        <i class="fa-solid fa-download"></i>
                        <a href="#">პაციენტები</a> | <a href="">ინვოისები</a>
                        -->
                    </div>
                </div>
            </div>
            <div class="flex">
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
            </div>
        </div>
        <div class="mt-10">
            <div class="flex">
                <div class="flex-1">
                    <h2 class="font-bold text-xl mb-3">წლის სტატისტიკა</h2>
                </div>
                <div class="flex-1 text-right">
                    <div class="">
                        <!--
                        <i class="fa-solid fa-download"></i>
                        <a href="#">პაციენტები</a> | <a href="">ინვოისები</a>
                        -->
                    </div>
                </div>
            </div>
            <div class="flex">
                <div class="flex-1 bg-gray-200 rounded p-5 mr-5">
                    <h2 class="text-xl font-bold text-center"><i class="fa-solid fa-user"></i> მიღებული პაციენტები</h2>
                    <p class="text-5xl font-bold text-center pt-5">{{ $year_users }}</p>
                </div>
                <div class="flex-1 bg-gray-200 rounded p-5 mr-5">
                    <h2 class="text-xl font-bold text-center"><i class="fa-solid fa-file-invoice"></i> მიღებული შემოსავალი</h2>
                    <p class="text-5xl font-bold text-center pt-5">{{ $year_sum }}</p>
                </div>
                <div class="flex-1 bg-gray-200 rounded p-5">
                    <h2 class="text-xl font-bold text-center"><i class="fa-solid fa-chart-simple"></i> საშუალო შემოსავალი</h2>
                    <p class="text-5xl font-bold text-center pt-5">{{ $year_average }}</p>
                </div>
            </div>
        </div>
    </x-dashboard>
@include('footer')
