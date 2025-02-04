@props(['active'])
<div class="group flex items-center">
    <a class="p-3 flex items-center justify-center rounded-full cursor-pointer hover:bg-[#616161] {{ $active === 'setting' ? 'bg-primary-gray' : 'bg-primary-white' }}"
        href="/setting">
        <svg class="size-6" viewBox="0 0 35 35" fill="{{ $active === 'setting' ? '#FCFCFC' : '#151A21' }}"
            xmlns="http://www.w3.org/2000/svg">
            <mask id="mask0_487_407" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="1" y="4" width="33"
                height="27">
                <path d="M24.793 29.8957L32.0846 17.4998L24.793 5.104H10.2096L2.91797 17.4998L10.2096 29.8957H24.793Z"
                    fill="white" stroke="white" stroke-width="2" stroke-linejoin="round" />
                <path
                    d="M17.5013 21.1457C18.4682 21.1457 19.3956 20.7616 20.0793 20.0778C20.763 19.3941 21.1471 18.4668 21.1471 17.4998C21.1471 16.5329 20.763 15.6056 20.0793 14.9218C19.3956 14.2381 18.4682 13.854 17.5013 13.854C16.5344 13.854 15.607 14.2381 14.9233 14.9218C14.2396 15.6056 13.8555 16.5329 13.8555 17.4998C13.8555 18.4668 14.2396 19.3941 14.9233 20.0778C15.607 20.7616 16.5344 21.1457 17.5013 21.1457Z"
                    fill="black" stroke="black" stroke-width="2" stroke-linejoin="round" />
            </mask>
            <g mask="url(#mask0_487_407)">
                <path d="M0 0H35V35H0V0Z"
                    class="{{ $active === 'setting' ? 'fill-[#FCFCFC]' : 'fill-[#151A21]' }} group-hover:fill-[#FCFCFC]"
                    fill="{{ $active === 'setting' ? '#FCFCFC' : '#151A21' }}" />
            </g>
        </svg>
    </a>
    <div
        class="hidden group-hover:block text-sm text-gray-600 ml-14 text-center w-32 py-[2px] rounded-md absolute bg-primary-gray primary-white">
        Setting
    </div>
</div>
