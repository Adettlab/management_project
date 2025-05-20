<nav class="py-4 px-6 flex justify-between items-center bg-white sticky top-0 z-50 border-b">
    <div class="flex justify-between items-center w-full">
        <div class="flex items-center justify-center">
            <!-- Logo -->
            <img src="{{ asset('logo.png') }}" alt="logo" class="w-[150px] ml-3" loading="lazy">
        </div>
        <div class="w-[33%]">
            <div class="flex items-center relative">
                <div class="w-full">
                    <input type="text" id="search" name="search" placeholder="Search project"
                        class="pl-5 py-3 w-full placeholder-[#616161] primary-gray font-medium text-sm border rounded-full focus:outline-none"
                        required>
                </div>
                <div class="absolute right-0 mr-5">
                    <svg class="w-6 h-6 primary-gray" viewBox="0 0 41 41" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M19.5196 4C17.2041 4.0002 14.9222 4.55412 12.8644 5.61556C10.8065 6.677 9.0323 8.21517 7.68979 10.1017C6.34729 11.9883 5.47541 14.1686 5.14689 16.4607C4.81838 18.7527 5.04275 21.0901 5.8013 23.2778C6.55985 25.4655 7.83058 27.4401 9.50746 29.0369C11.1843 30.6336 13.2188 31.8062 15.441 32.4567C17.6632 33.1073 20.0088 33.217 22.282 32.7767C24.5552 32.3364 26.6902 31.3589 28.5088 29.9257L34.7477 36.1645C35.0699 36.4757 35.5014 36.6479 35.9493 36.644C36.3972 36.6401 36.8257 36.4604 37.1425 36.1437C37.4592 35.827 37.6389 35.3985 37.6427 34.9506C37.6466 34.5026 37.4744 34.0711 37.1633 33.7489L30.9244 27.5101C32.6123 25.3689 33.6632 22.7958 33.9569 20.0852C34.2506 17.3746 33.7753 14.6361 32.5853 12.1831C31.3953 9.73003 29.5388 7.66157 27.2281 6.2144C24.9175 4.76722 22.246 3.99982 19.5196 4ZM8.41543 18.5208C8.41543 15.5758 9.58533 12.7514 11.6678 10.669C13.7502 8.58657 16.5746 7.41667 19.5196 7.41667C22.4646 7.41667 25.289 8.58657 27.3714 10.669C29.4539 12.7514 30.6238 15.5758 30.6238 18.5208C30.6238 21.4658 29.4539 24.2902 27.3714 26.3727C25.289 28.4551 22.4646 29.625 19.5196 29.625C16.5746 29.625 13.7502 28.4551 11.6678 26.3727C9.58533 24.2902 8.41543 21.4658 8.41543 18.5208Z"
                            fill="currentColor" fill-opacity="0.6" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-x-5 relative w-1/5">
            <div class="flex items-center gap-x-3">
                <div class="flex flex-col items-end">
                    <div class="text-lg font-semibold">
                        {{ auth()->user()->name }}
                    </div>
                    <div class="text-[12px]">{{ auth()->user()->role }}</div>
                </div>
                <div class="group flex flex-col items-center">
                    @if (auth()->user()->employee)
                        <a class="group relative w-12 h-12 overflow-hidden bg-secondary-white border rounded-full hover:bg-blue-300 transition-colors duration-300"
                            href={{ route('users.profile') }} :active="$active">
                        @else
                            <div
                                class="group relative w-12 h-12 overflow-hidden bg-secondary-white border rounded-full hover:bg-blue-300 transition-colors duration-300">
                    @endif
                    @if (auth()->user()->employee && auth()->user()->employee->photo)
                        <div class="w-full h-full">
                            <img src="{{ asset('/storage/' . auth()->user()->employee->photo) }}" alt="Photo"
                                class="w-full h-full object-cover" loading="lazy">
                        </div>
                    @else
                        <div class="flex items-center justify-center w-full h-full">
                            <img src="{{ asset('blank_profile.png') }}" alt="Photo"
                                class="w-9 h-9 rounded-full object-cover" loading="lazy">
                        </div>
                    @endif
                    @if (auth()->user()->employee)
                        </a>
                    @else
                </div>
                @endif
                <div
                    class="hidden group-hover:block text-sm text-white mt-[60px] px-5 rounded-md absolute bg-sky-blue primary-white">
                    Account
                </div>
            </div>
            <div class="flex flex-col items-center justify-center group mr-6">
                <form method="POST" action="{{ route('logout') }}" id="logout-form">
                    @csrf
                    <button type="button" id="logout-btn"
                        class="bg-secondary-white border text-sm p-3 flex items-center justify-center rounded-full hover:bg-blue-300 transition-colors duration-300">
                        <svg class="size-6 transition-colors icon-color" viewBox="0 0 40 40" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M8.33333 35C7.41667 35 6.63222 34.6739 5.98 34.0217C5.32778 33.3694 5.00111 32.5844 5 31.6667V8.33333C5 7.41667 5.32667 6.63222 5.98 5.98C6.63333 5.32778 7.41778 5.00111 8.33333 5H20V8.33333H8.33333V31.6667H20V35H8.33333ZM26.6667 28.3333L24.375 25.9167L28.625 21.6667H15V18.3333H28.625L24.375 14.0833L26.6667 11.6667L35 20L26.6667 28.3333Z" />
                        </svg>
                    </button>
                    <div
                        class="hidden group-hover:block text-sm text-white mt-[10px] right-0 ml-5 px-5 rounded-md absolute bg-sky-blue primary-white">
                        Logout
                    </div>
                </form>
            </div>
        </div>
    </div>
</nav>

<style>
    /* Default color for SVG icon */
    .icon-color path {
        fill: var(--gray-color);
    }

    /* Change color on hover */
    .group:hover .icon-color path {
        fill: #fcfcfc;
    }
</style>
