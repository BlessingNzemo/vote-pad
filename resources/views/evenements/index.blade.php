<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Liste des événements') }}
            </h2>
            <a href="{{ route('evenements.create') }}"
                class="px-5 py-2 text-sm font-medium text-center inline-flex items-center text-white bg-[#FF9119] hover:bg-[#FF9119]/80 focus:ring-4 focus:outline-none focus:ring-[#FF9119]/50 font-medium rounded-lg text-sm px-4 py-2 text-center inline-flex items-center dark:hover:bg-[#FF9119]/80 dark:focus:ring-[#FF9119]/40">
                Créer un événement
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-8 h-6 pl-2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </a>
        </div>
    </x-slot>


    <div class="relative overflow-x-auto shadow-md sm:rounded-lg" style="padding-top: 10px;">
        @if (session('success'))
            <div id="alert-3"
                class="flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
                role="alert">
                <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                </svg>
                <span class="sr-only">Info</span>
                <div class="ms-3 text-sm font-medium">
                    {{ session('success') }}
                </div>
                <button type="button"
                    class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700"
                    data-dismiss-target="#alert-3" aria-label="Close">
                    <span class="sr-only">Close</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
            </div>
        @endif
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg" style="padding-top: 10px;">
            <div class="">
                @foreach ($evenements as $item)
                    <div class="w-full">
                        <div
                            class="mb-3 py-1 rounded-md border bg-white drop-shadow-xl dark:bg-gray-800 dark:border-gray-800">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2 md:pl-3 relative">
                                <div class="pl-3 col-span-1">
                                    <h3
                                        class="text-2xl font-bold text-gray-900 whitespace-nowrap dark:text-white md:pr-3">
                                        {{ $item->nom }}
                                    </h3>
                                </div>
                                <div class="flex justify-between">
                                    <div class="pl-3 md:pl-5 col-span-1 md:col-span-1">
                                        <h3 class="text-gray-900 whitespace-nowrap dark:text-gray-300 pr-3 capitalize">
                                            Type
                                        </h3>
                                        <h3 class="text-gray-900 whitespace-nowrap dark:text-white pr-3">
                                            {{ $item->type }}
                                        </h3>
                                    </div>
                                    <div class="pl-3 md:pl-5 col-span-1 md:col-span-1">
                                        <h3 class="text-gray-900 whitespace-nowrap dark:text-gray-300 pr-3 capitalize">
                                            Status
                                        </h3>
                                        <h3 class="text-gray-900 whitespace-nowrap dark:text-white pr-3">
                                            {{ $item->status }}
                                        </h3>
                                    </div>
                                </div>
                                <div class="flex md:justify-end items-center">
                                    <div class="py-1 font-medium text-gray-900 whitespace-nowrap dark:text-white pr-3">
                                        <a href="{{ route('evenements.show', $item->id) }}"
                                            class="px-3 text-sm font-medium text-center inline-flex items-center text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 dark:bg-gray-600 dark:hover:bg-gray-700 focus:outline-none dark:focus:ring-gray-800">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                fill="currentColor" class="size-4">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16ZM6.75 9.25a.75.75 0 0 0 0 1.5h4.59l-2.1 1.95a.75.75 0 0 0 1.02 1.1l3.5-3.25a.75.75 0 0 0 0-1.1l-3.5-3.25a.75.75 0 1 0-1.02 1.1l2.1 1.95H6.75Z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                    </div>
                                    <div class="pr-2 absolute right-0">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
            <div class="p-2">

            </div>
        </div>
        <div class="p-2">
            {{ $evenements->withPath(request()->url())->links() }}
        </div>
    </div>
    <script>
        setTimeout(function() {
            let alerts = document.querySelectorAll('[role="alert"]');
            alerts.forEach(function(alert) {
                alert.style.transition = "opacity 0.5s ease";
                alert.style.opacity = "0";
                setTimeout(function() {
                    alert.remove();
                }, 500);
            });
        }, 5000);
    </script>
</x-app-layout>
