@props(['active'])
<div class="group flex items-center">
    <a class="p-3 flex items-center justify-center rounded-full cursor-pointer hover:bg-[#616161] {{ $active === 'time-management' ? 'bg-primary-gray' : 'bg-primary-white' }}"
        href="/time-management">
        <svg class="size-6" viewBox="0 0 35 35" fill="{{ $active === 'time-management' ? '#FCFCFC' : '#151A21 ' }}"
            xmlns="http://www.w3.org/2000/svg">
            <path
                class="{{ $active === 'time-management' ? 'fill-[#FCFCFC]' : 'fill-[#151A21]' }} group-hover:fill-[#FCFCFC]"
                d="M17.5013 2.9165C25.5557 2.9165 32.0846 9.44546 32.0846 17.4998C32.0846 25.5542 25.5557 32.0832 17.5013 32.0832C9.44693 32.0832 2.91797 25.5542 2.91797 17.4998C2.91797 9.44546 9.44693 2.9165 17.5013 2.9165ZM17.5013 8.74984C17.1145 8.74984 16.7436 8.90348 16.4701 9.17697C16.1966 9.45046 16.043 9.8214 16.043 10.2082V17.4998C16.0431 17.8866 16.1968 18.2575 16.4703 18.5309L20.8453 22.9059C21.1203 23.1715 21.4887 23.3185 21.8711 23.3152C22.2534 23.3119 22.6192 23.1585 22.8896 22.8881C23.16 22.6177 23.3133 22.252 23.3167 21.8696C23.32 21.4872 23.173 21.1188 22.9073 20.8438L18.9596 16.8961V10.2082C18.9596 9.8214 18.806 9.45046 18.5325 9.17697C18.259 8.90348 17.8881 8.74984 17.5013 8.74984Z" />
        </svg>
    </a>
    <div
        class="hidden group-hover:block text-sm text-gray-600 ml-14 text-center w-32 py-[2px] rounded-md absolute bg-primary-gray primary-white">
        Time Manage
    </div>
</div>
