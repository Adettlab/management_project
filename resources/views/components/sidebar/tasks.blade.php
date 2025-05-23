@props(['active'])
<div class="sidebar-item flex items-center w-full {{ $active === 'tasks' ? 'active' : '' }}" data-tooltip="Tasks">
    <a href="{{ route('tasks.index') }}"
        class="flex items-center p-2 rounded-lg transition-colors w-full group
        {{ $active === 'tasks' ? 'active' : '' }}">
        <svg class="sidebar-icon size-6 flex-shrink-0" viewBox="0 0 35 35" xmlns="http://www.w3.org/2000/svg">
            <path class="{{ $active === 'tasks' ? 'active' : '' }}"
                d="M20.4154 2.9165H8.7487C7.14453 2.9165 5.84661 4.229 5.84661 5.83317L5.83203 29.1665C5.83203 30.7707 7.12995 32.0832 8.73411 32.0832H26.2487C27.8529 32.0832 29.1654 30.7707 29.1654 29.1665V11.6665L20.4154 2.9165ZM15.9529 26.2498L10.7904 21.0873L12.8466 19.0311L15.9383 22.1228L22.1216 15.9394L24.1779 17.9957L15.9529 26.2498ZM18.957 13.1248V5.104L26.9779 13.1248H18.957Z" />
        </svg>
        <span class="sidebar-label text-sm font-medium whitespace-nowrap hidden">
            Tasks
        </span>
    </a>
</div>
