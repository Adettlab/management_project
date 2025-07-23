<x-layouts.layout :title="$title" :active="$active">
    <div class="sm:mx-6 xs:mx-3  my-1">
        <div class="bg-white rounded-lg border-2 border-gray-200 p-6 max-w-full w-full mx-auto">
            <div class="flex flex-1 justify-between items-center w-full -mt-8">
                <div class="w-[35%] sm:w-[20%]">
                    <form method="GET" class="w-full">
                        <input type="month" name="month"
                            class="primary-gray w-full font-medium rounded-lg py-2 px-2 sm:text-sm xs:text-xs border outline-none"
                            onchange="this.form.submit()" value="{{ request('month', date('Y-m')) }}" />
                    </form>
                </div>
                <div class="sm:flex-1 flex justify-end">
                    <div class="my-5">
                        {{ $employees->withQUeryString()->links() }}
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-2">
                @foreach ($employees as $emp)
                    <div class="bg-white border-2 h-fit px-1 py-2 rounded-md">
                        <div class="flex justify-start items-start mb-4 gap-4 pl-5 space-x-2">
                            <div class="relative mt-2 z-1" id="image-preview">
                                @if ($emp->photo)
                                    <img src="{{ asset('/storage/' . $emp->photo) }}" alt="Profile Picture"
                                        class="sm:w-16 sm:h-16 xs:w-[45px] xs:h-[45px] rounded-full object-cover"
                                        id="current-image" loading="lazy">
                                @else
                                    <div
                                        class="sm:w-16 sm:h-16 xs:w-[45px] xs:h-[45px] bg-zinc-200 rounded-full flex items-center justify-center overflow-hidden">
                                        <img src="{{ asset('/blank_profile.png') }}" alt="Photo"
                                            class="sm:w-12 sm:h-12 xs:w-10 xs:h-10 rounded-full object-cover"
                                            loading="lazy">
                                    </div>
                                @endif
                            </div>

                            <div class="mt-3 flex-1 pr-8">
                                <h2 class="sm:text-md xs:text-sm font-semibold">{{ $emp->user->name }}</h2>
                                <p class="text-gray-600 sm:text-xs xs:text-[10px]">{{ $emp->role->name }}</p>
                            </div>
                        </div>

                        <div class="grid mb-4 mr-7 ml-4">
                            <div class="flex sm:space-x-5 xs:space-x-9">
                                <div class="items-center justify-between">
                                    <p class="text-gray-600 sm:text-sm xs:text-[10px] xss:text-[12px]">Total Project</p>
                                    <input type="text"
                                        class="sm:w-20 xs:w-[65px] xss:w-[75px] sm:text-md xs:text-[13px] xss:text-sm font-semibold rounded border text-center mx-auto"
                                        value="{{ $emp->sumProjects }}" readonly disabled>
                                </div>
                                <div class="items-center justify-between">
                                    <p class="text-gray-600 sm:text-sm xs:text-[10px] xss:text-[12px]">Tasks Done</p>
                                    <input type="text"
                                        class="sm:w-20 xs:w-[65px] xss:w-[75px] sm:text-md xs:text-[13px] xss:text-sm font-semibold rounded border text-center"
                                        value="{{ $emp->sumTasks }}" readonly disabled>
                                </div>
                                {{-- <div class="items-center justify-between">
                                    <p class="text-gray-600 sm:text-sm xs:text-[10px] xss:text-[12px]">Total Leave</p>
                                    <input type="text"
                                        class="sm:w-20 xs:w-[65px] xss:w-[75px] sm:text-md xs:text-[13px] xss:text-sm font-semibold rounded border text-center"
                                        value="{{ $emp->totalDayOff }}" readonly disabled>
                                </div> --}}
                            </div>
                        </div>

                        {{-- <div class="px-5 pb-7 pt-2 -mb-4">
                            <div class="max-w-sm">
                                <div class="sm:text-sm xs:text-[10px]text-gray-600 mb-2">
                                    Work hours
                                </div>
                                <div class="flex items-center">
                                    <div
                                        class="relative h-4 bg-gray-200 rounded-full overflow-hidden sm:w-80 xs:w-[100%]">
                                        <div class="absolute h-full bg-blue-900 rounded-full"
                                            style="width: {{ $emp->totalWorkDuration > 100 ? 100 : $emp->totalWorkDuration }}%;">
                                        </div>
                                        <div
                                            class="absolute inset-0 flex items-center justify-center sm:text-xs xs:text-[10px] font-bold {{ $emp->totalWorkDuration > 45 ? 'text-white' : 'text-black' }}">
                                            {{ $emp->totalWorkDuration }}%
                                        </div>
                                    </div>

                                    @if ($emp->totalWorkDuration > 100)
                                        <div class="flex items-center ml-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24">
                                                <path fill="currentColor"
                                                    d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10s10-4.48 10-10S17.52 2 12 2m1 15h-2v-6h2zm0-8h-2V7h2z" />
                                            </svg>
                                            <span class="text-sm text-gray-500 ml-1">Overwork</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div> --}}
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-layouts.layout>
