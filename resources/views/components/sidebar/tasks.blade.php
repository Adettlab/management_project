@props(['active'])
<div class="group flex items-center">
    <a class="bg-secondary-white p-2 flex items-center justify-center rounded-full cursor-pointer hover:bg-[#6FAEC9] {{ $active === 'tasks' ? 'bg-sky-blue' : 'bg-white' }}"
        href="{{ route('tasks.index') }}">
        <svg class="size-6" viewBox="0 0 35 35" fill="{{ $active === 'tasks' ? '#FFFFFF' : '#616161' }}"
            xmlns="http://www.w3.org/2000/svg">
            <path class="{{ $active === 'tasks' ? 'fill-[#FFFFFF]' : 'fill-[#616161]' }} group-hover:fill-[#FFFFFF]"
                d="M20.4154 2.9165H8.7487C7.14453 2.9165 5.84661 4.229 5.84661 5.83317L5.83203 29.1665C5.83203 30.7707 7.12995 32.0832 8.73411 32.0832H26.2487C27.8529 32.0832 29.1654 30.7707 29.1654 29.1665V11.6665L20.4154 2.9165ZM15.9529 26.2498L10.7904 21.0873L12.8466 19.0311L15.9383 22.1228L22.1216 15.9394L24.1779 17.9957L15.9529 26.2498ZM18.957 13.1248V5.104L26.9779 13.1248H18.957Z" />
        </svg>
    </a>
    <div
        class="hidden group-hover:block text-sm text-white ml-14 text-center w-32 py-[2px] rounded-md absolute bg-sky-blue bg-white z-50">
        Tasks
    </div>
</div>
