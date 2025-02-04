@props(['active'])
<div class="group flex items-center">
    <a class="p-3 flex items-center justify-center rounded-full cursor-pointer hover:bg-[#616161] {{ $active === 'calendar' ? 'bg-primary-gray' : 'bg-primary-white' }}"
        href="/calendar">
        <svg class="size-6" viewBox="0 0 35 35" fill="{{ $active === 'calendar' ? '#FCFCFC' : '#151A21' }}"
            xmlns="http://www.w3.org/2000/svg">
            <path class="{{ $active === 'calendar' ? 'fill-[#FCFCFC]' : 'fill-[#151A21]' }} group-hover:fill-[#FCFCFC]"
                d="M30.625 17.5V27.7083C30.625 28.4819 30.3177 29.2237 29.7707 29.7707C29.2237 30.3177 28.4819 30.625 27.7083 30.625H7.29167C6.51812 30.625 5.77625 30.3177 5.22927 29.7707C4.68229 29.2237 4.375 28.4819 4.375 27.7083V17.5H30.625ZM23.3333 4.375C23.7201 4.375 24.091 4.52865 24.3645 4.80214C24.638 5.07563 24.7917 5.44656 24.7917 5.83333V7.29167H27.7083C28.4819 7.29167 29.2237 7.59896 29.7707 8.14594C30.3177 8.69292 30.625 9.43479 30.625 10.2083V14.5833H4.375V10.2083C4.375 9.43479 4.68229 8.69292 5.22927 8.14594C5.77625 7.59896 6.51812 7.29167 7.29167 7.29167H10.2083V5.83333C10.2083 5.44656 10.362 5.07563 10.6355 4.80214C10.909 4.52865 11.2799 4.375 11.6667 4.375C12.0534 4.375 12.4244 4.52865 12.6979 4.80214C12.9714 5.07563 13.125 5.44656 13.125 5.83333V7.29167H21.875V5.83333C21.875 5.44656 22.0286 5.07563 22.3021 4.80214C22.5756 4.52865 22.9466 4.375 23.3333 4.375Z" />
        </svg>
    </a>
    <div
        class="hidden group-hover:block text-sm text-gray-600 ml-14 text-center w-32 py-[2px] rounded-md absolute bg-primary-gray primary-white">
        Calendar
    </div>
</div>
