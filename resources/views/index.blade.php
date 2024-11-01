@include("header")
        <div class="flex h-screen items-center justify-center">
            <div class="bg-gray-200 p-5 rounded-md shadow-xl text-center">
                <h1 class="text-2xl pt-0 pb-3 text-center">
                    @if($portal_logo[0]->option_value)
                        <img class="w-36 inline-block" src="{{ $portal_logo[0]->option_value }}" alt="@if(env('APP_NAME')) {{ env('APP_NAME') }} @endif">
                    @elseif(env('APP_NAME'))
                        {{ env('APP_NAME') }}
                    @endif
                </h1>
                <form action="/login" method="post">
                    @csrf
                    <input class="rounded-md px-3 py-1 block mb-3 mx-3 @error('username') border border-red-400 @enderror" name="username" placeholder="მომხმარებელი">

                    <input class="rounded-md px-3 py-1 block mb-5 mx-3 @error('password') border border-red-400 @enderror" name="password" type="password" placeholder="პაროლი">

                    @error('remember') {{ $message }} @enderror
                    <input name="remember" type="checkbox" value="1"> დამახსოვრება
                    <br><br>
                    <button class="rounded-md px-3 py-1 bg-gray-700 text-white" type="submit">შესვლა</button>
                </form>
            </div>
        </div>
@include("footer")
