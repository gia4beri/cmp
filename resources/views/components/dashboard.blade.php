    <div class="flex">
        <div class="bg-gray-200 w-52 shadow-inner min-h-screen">
            <div class="text-center mt-10">
                <i class="fa-solid fa-user-doctor mb-3 text-7xl"></i>
                <h3 class="text-xl">{{ $user['first_name'] }} {{ $user['last_name'] }}</h3>
            </div>
            <ul class="text-lg mt-10">
                <li class="pl-12">
                    <a href="/logout"><i class="fa-solid fa-right-from-bracket w-6"></i> გამოსვლა</a>
                </li>
            </ul>
            <ul class="text-lg mt-16">
                <li class="py-3 pl-12 border-b border-gray-300 hover:bg-gray-300">
                    <a href="/dashboard"><i class="fa-solid fa-house w-6"></i> მთავარი</a>
                </li>
                @can('isAdminOrReceptionOrDoctor')
                <li class="py-3 pl-12 border-b border-gray-300 hover:bg-gray-300">
                    <a href="/dashboard/users"><i class="fa-solid fa-user w-6"></i> პაციენტები</a>
                </li>
                @endcan

                @can('isAdminOrReception')
                <li class="py-3 pl-12 border-b border-gray-300 hover:bg-gray-300">
                    <a href="/dashboard/invoices"><i class="fa-solid fa-file-invoice w-6"></i> ინვოისები</a>
                </li>
                @endcan

                @can('isAdmin')
                <li class="py-3 pl-12 border-b border-gray-300 hover:bg-gray-300">
                    <a href="/dashboard/services"><i class="fa-solid fa-suitcase-medical w-6"></i> სერვისები</a>
                </li>
                <li class="py-3 pl-12 border-b border-gray-300 hover:bg-gray-300">
                    <a href="/dashboard/staff"><i class="fa-solid fa-user-nurse w-6"></i> პერსონალი</a>
                </li>
                <li class="py-3 pl-12 border-b border-gray-300 hover:bg-gray-300">
                    <a href="/dashboard/stats"><i class="fa-solid fa-chart-simple w-6"></i> სტატისტიკა</a>
                </li>
                <li class="py-3 pl-12 border-b border-gray-300 hover:bg-gray-300">
                    <a href="/dashboard/options"><i class="fa-solid fa-gear w-6"></i> პარამეტრები</a>
                </li>
                @endcan
            </ul>
        </div>
        <div class="grow">
            <h1 class="text-2xl font-bold bg-gray-100 p-5">
               <i class="fa-solid fa-location-dot mr-3"></i> {{ $title }}
            </h1>
            <div class="p-5">
                {{ $slot }}
            </div>
        </div>
    </div>
