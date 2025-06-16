@props(['active'])
<div class="group flex items-center xs:relative">
    <a class="sm:bg-[#F5F5F5] p-2 flex items-center justify-center rounded-full z-50 hover:z-50 cursor-pointer group sm:hover:bg-[#6FAEC9] {{ $active === 'administration' ? 'sm:bg-sky-blue xs:bg-transparent' : 'bg-white' }}"
        href="{{ route('administration.index') }}">
        <svg class="size-6" viewBox="0 0 35 35" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
                class="{{ $active === 'administration' ? 'sm:fill-[#FFFFFF] xs:fill-[#6FAEC9]' : 'fill-[#616161]' }} sm:group-hover:fill-[#FFFFFF]"
                d="M10.2083 2.9165C8.66124 2.9165 7.17751 3.53109 6.08354 4.62505C4.98958 5.71901 4.375 7.20274 4.375 8.74984V26.2498C4.375 27.7969 4.98958 29.2807 6.08354 30.3746C7.17751 31.4686 8.66124 32.0832 10.2083 32.0832H30.625V2.9165H10.2083ZM16.0417 7.2915H26.25V10.2082H16.0417V7.2915ZM7.29167 26.2498C7.29167 25.4763 7.59896 24.7344 8.14594 24.1874C8.69292 23.6405 9.43479 23.3332 10.2083 23.3332H27.7083V29.1665H10.2083C9.43479 29.1665 8.69292 28.8592 8.14594 28.3122C7.59896 27.7653 7.29167 27.0234 7.29167 26.2498Z" />
        </svg>
    </a>
    <div
        class="sm:hidden xs:block sm:group-hover:block sm:text-sm xs:text-[9px] sm:ml-14 text-center w-32 py-[2px] rounded-md absolute xs:-bottom-3 xs:-left-11 sm:left-auto sm:bottom-auto sm:bg-sky-blue sm:bg-white z-[999] group-hover:z-[999] {{ $active === 'administration' ? 'xs:text-[#6FAEC9] sm:text-white' : 'xs:text-black sm:text-white' }}">
        Administration
    </div>
</div>
