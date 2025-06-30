@props(['active'])
<div class="group flex items-center xs:relative sm:w-full">
    <a class="sm:bg-[#F5F5F5] sm:w-full p-2 flex items-center sm:justify-start justify-center rounded-full cursor-pointer sm:hover:bg-[#6FAEC9] sm:rounded-md sm:hover:text-white {{ $active === 'tasks' ? 'sm:bg-sky-blue xs:bg-transparent' : 'bg-white' }}"
        href="{{ route('tasks.index') }}">
        <svg class="size-6" viewBox="0 0 35 35" fill="{{ $active === 'tasks' ? '#FFFFFF' : '#616161' }}"
            xmlns="http://www.w3.org/2000/svg">
            <path
                class="{{ $active === 'tasks' ? 'sm:fill-[#FFFFFF] xs:fill-[#6FAEC9]' : 'fill-[#616161]' }} sm:group-hover:fill-[#FFFFFF]"
                d="M20.4154 2.9165H8.7487C7.14453 2.9165 5.84661 4.229 5.84661 5.83317L5.83203 29.1665C5.83203 30.7707 7.12995 32.0832 8.73411 32.0832H26.2487C27.8529 32.0832 29.1654 30.7707 29.1654 29.1665V11.6665L20.4154 2.9165ZM15.9529 26.2498L10.7904 21.0873L12.8466 19.0311L15.9383 22.1228L22.1216 15.9394L24.1779 17.9957L15.9529 26.2498ZM18.957 13.1248V5.104L26.9779 13.1248H18.957Z" />
        </svg>
        <span class="hidden sm:block sm:ml-1 sm:text-sm {{ $active === 'tasks' ? 'sm:text-white' : '' }}">
            Tasks
        </span>
    </a>
    <div
        class="sm:hidden xs:block sm:text-sm xs:text-[9px] sm:text-white xs:text-black sm:ml-14 text-center w-32 py-[2px] rounded-md absolute xs:-bottom-3 sm:bottom-auto xs:-left-11 sm:left-auto sm:bg-sky-blue sm:bg-white group-hover:z-50 {{ $active === 'tasks' ? 'xs:text-[#6FAEC9] sm:text-white' : 'xs:text-black sm:text-white' }}">
        Tasks
    </div>
</div>
