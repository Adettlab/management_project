<x-layouts.layout :title="$title" :active="$active">
    <main class="flex-1 p-6 bg-gradient-to-br from-white-50 to-white-100 min-h-screen">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Detail Project</h1>
            <div class="h-1 w-24 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full"></div>
        </div>

        <!-- Project Title Card -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6 border-l-4 border-blue-500">
            <h2 class="text-2xl font-bold text-gray-800">{{ $project->name }}</h2>
        </div>

        <!-- Project Info Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Basic Information Card -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Informasi Dasar
                </h3>
                <div class="space-y-4">
                    <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                        <svg class="w-5 h-5 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a1 1 0 011-1h6a1 1 0 011 1v4h3a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2V9a2 2 0 012-2h3z"></path>
                        </svg>
                        <div>
                            <span class="text-sm text-gray-600">Tanggal Mulai</span>
                            <p class="font-semibold text-gray-800">
                                {{ \Carbon\Carbon::parse($project->start_date)->locale('id')->translatedFormat('d F Y') }}
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                        <svg class="w-5 h-5 mr-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a1 1 0 011-1h6a1 1 0 011 1v4h3a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2V9a2 2 0 012-2h3z"></path>
                        </svg>
                        <div>
                            <span class="text-sm text-gray-600">Tanggal Selesai</span>
                            <p class="font-semibold text-gray-800">
                                {{ \Carbon\Carbon::parse($project->end_date)->locale('id')->translatedFormat('d F Y') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status & Level Card -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Status & Level
                </h3>
                <div class="space-y-4">
                    <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                        <svg class="w-5 h-5 mr-3 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        <div>
                            <span class="text-sm text-gray-600">Level</span>
                            <p class="font-semibold text-gray-800">{{ $project->level->name }}</p>
                        </div>
                    </div>
                    <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                        <div class="w-3 h-3 mr-3 bg-blue-500 rounded-full"></div>
                        <div>
                            <span class="text-sm text-gray-600">Status</span>
                            <p class="font-semibold text-gray-800">{{ $project->status->name }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Team Members Card -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
            <h3 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
                <svg class="w-6 h-6 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                Tim Yang Ditugaskan
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                <!-- Kepala Pustik -->
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-4 border border-blue-200">
                    <h4 class="font-semibold text-blue-800 mb-3 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Kepala Pustik
                    </h4>
                    @php
                        $kepalaPustik = $project->employees->where('role.name', 'KEPALA PUSTIK');
                    @endphp
                    @if($kepalaPustik->count() > 0)
                        <div class="space-y-2">
                            @foreach($kepalaPustik as $employee)
                                <div class="bg-white rounded-md p-2 flex items-center">
                                    <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center mr-3">
                                        <span class="text-white text-sm font-semibold">
                                            {{ substr($employee->user->name, 0, 1) }}
                                        </span>
                                    </div>
                                    <span class="text-gray-800 text-sm">{{ $employee->user->name }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 italic">Belum ditugaskan</p>
                    @endif
                </div>

                <!-- Project Pelaporan -->
                <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-4 border border-green-200">
                    <h4 class="font-semibold text-green-800 mb-3 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Project Pelaporan
                    </h4>
                    @php
                        $pelaporan = $project->employees->where('role.name', 'Pelaporan PDDIKTI');
                    @endphp
                    @if($pelaporan->count() > 0)
                        <div class="space-y-2">
                            @foreach($pelaporan as $employee)
                                <div class="bg-white rounded-md p-2 flex items-center">
                                    <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center mr-3">
                                        <span class="text-white text-sm font-semibold">
                                            {{ substr($employee->user->name, 0, 1) }}
                                        </span>
                                    </div>
                                    <span class="text-gray-800 text-sm">{{ $employee->user->name }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 italic">Belum ditugaskan</p>
                    @endif
                </div>

                <!-- Asisten DOSEN -->
                <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg p-4 border border-purple-200">
                    <h4 class="font-semibold text-purple-800 mb-3 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        Asisten DOSEN
                    </h4>
                    @php
                        $asistenDosen = $project->employees->where('role.name', 'Asisten DOSEN');
                    @endphp
                    @if($asistenDosen->count() > 0)
                        <div class="space-y-2">
                            @foreach($asistenDosen as $employee)
                                <div class="bg-white rounded-md p-2 flex items-center">
                                    <div class="w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center mr-3">
                                        <span class="text-white text-sm font-semibold">
                                            {{ substr($employee->user->name, 0, 1) }}
                                        </span>
                                    </div>
                                    <span class="text-gray-800 text-sm">{{ $employee->user->name }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 italic">Belum ditugaskan</p>
                    @endif
                </div>

                <!-- TEKNISI -->
                <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-lg p-4 border border-yellow-200">
                    <h4 class="font-semibold text-yellow-800 mb-3 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        TEKNISI
                    </h4>
                    @php
                        $teknisi = $project->employees->where('role.name', 'TEKNISI');
                    @endphp
                    @if($teknisi->count() > 0)
                        <div class="space-y-2">
                            @foreach($teknisi as $employee)
                                <div class="bg-white rounded-md p-2 flex items-center">
                                    <div class="w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center mr-3">
                                        <span class="text-white text-sm font-semibold">
                                            {{ substr($employee->user->name, 0, 1) }}
                                        </span>
                                    </div>
                                    <span class="text-gray-800 text-sm">{{ $employee->user->name }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 italic">Belum ditugaskan</p>
                    @endif
                </div>

                <!-- Jaringan Dan Instalasi -->
                <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-lg p-4 border border-indigo-200">
                    <h4 class="font-semibold text-indigo-800 mb-3 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
                        </svg>
                        Jaringan & Instalasi
                    </h4>
                    @php
                        $jaringan = $project->employees->where('role.name', 'Jaringan Dan Instalasi');
                    @endphp
                    @if($jaringan->count() > 0)
                        <div class="space-y-2">
                            @foreach($jaringan as $employee)
                                <div class="bg-white rounded-md p-2 flex items-center">
                                    <div class="w-8 h-8 bg-indigo-500 rounded-full flex items-center justify-center mr-3">
                                        <span class="text-white text-sm font-semibold">
                                            {{ substr($employee->user->name, 0, 1) }}
                                        </span>
                                    </div>
                                    <span class="text-gray-800 text-sm">{{ $employee->user->name }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 italic">Belum ditugaskan</p>
                    @endif
                </div>

                <!-- Pengelola Sosial Media -->
                <div class="bg-gradient-to-br from-pink-50 to-pink-100 rounded-lg p-4 border border-pink-200">
                    <h4 class="font-semibold text-pink-800 mb-3 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2m0 0V1a1 1 0 011-1h2a1 1 0 011 1v18a1 1 0 01-1 1H4a1 1 0 01-1-1V4a1 1 0 011-1h2a1 1 0 011 1z"></path>
                        </svg>
                        Sosial Media
                    </h4>
                    @php
                        $sosialMedia = $project->employees->where('role.name', 'Pengelola Sosial Media');
                    @endphp
                    @if($sosialMedia->count() > 0)
                        <div class="space-y-2">
                            @foreach($sosialMedia as $employee)
                                <div class="bg-white rounded-md p-2 flex items-center">
                                    <div class="w-8 h-8 bg-pink-500 rounded-full flex items-center justify-center mr-3">
                                        <span class="text-white text-sm font-semibold">
                                            {{ substr($employee->user->name, 0, 1) }}
                                        </span>
                                    </div>
                                    <span class="text-gray-800 text-sm">{{ $employee->user->name }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 italic">Belum ditugaskan</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Description Card -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                </svg>
                Deskripsi Project
            </h3>
            <div class="bg-gray-50 rounded-lg p-4">
                <p class="text-gray-700 leading-relaxed">
                    {{ $project->description ?? 'Tidak ada deskripsi yang disediakan.' }}
                </p>
            </div>
        </div>

        <!-- Back Button -->
        <div class="flex justify-start">
            <a href="{{ route('projects.index') }}" 
               class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold rounded-lg shadow-md hover:from-blue-600 hover:to-blue-700 transform hover:scale-105 transition-all duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali
            </a>
        </div>
    </main>
</x-layouts.layout>