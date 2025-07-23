<x-layouts.layout :title="$title">
    <div class="bg-white rounded-lg shadow-md px-4 sm:px-6 py-4 sm:py-6 max-w-full w-full h-full mx-auto">
        <form action="{{ route('users.update', $user->employee->id) }}" method="POST" id="edit-form"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Header (Foto dan Nama) -->
            <div class="flex flex-col sm:flex-row items-center sm:items-start mb-8 gap-4 sm:pl-8">
                <div class="relative mt-2 sm:mt-6" id="image-preview">
                    @if ($user->employee->photo)
                        <img src="/storage/{{ $user->employee->photo }}" alt="Profile Picture"
                            class="w-24 h-24 rounded-full object-cover" id="current-image">
                        <input type="hidden" name="old_photo" id="old_photo" value="{{ $user->employee->photo }}">
                    @else
                        <div
                            class="w-24 h-24 bg-zinc-200 rounded-full flex items-center justify-center overflow-hidden">
                            <span class="text-gray-400 text-sm">Preview</span>
                        </div>
                    @endif
                </div>

                <div class="mt-2 sm:mt-6 flex-1 pr-0 sm:pr-8 text-center sm:text-left">
                    <h2 class="text-lg sm:text-xl font-semibold">{{ $user->name }}</h2>
                    <p class="text-gray-600 text-sm sm:text-base">{{ $user->employee->role->name }}</p>

                    <div class="mt-2 flex flex-col sm:flex-row items-center sm:gap-4">
                        <label for="photo-upload"
                            class="cursor-pointer bg-sky-blue text-white text-xs font-medium px-4 py-1 rounded hover:bg-blue-600 text-center">
                            Upload Picture
                        </label>
                        <input id="photo-upload" name="photo" type="file" accept="image/*" class="hidden" />

                        <button
                            class="mt-2 sm:mt-0 w-full sm:w-24 bg-black text-xs text-white px-2 py-1 rounded hover:bg-gray-800"
                            id="reactive-button">
                            Edit
                        </button>
                    </div>
                </div>
            </div>

            <!-- Konten Form -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-4 mx-4">
                <!-- Statistik -->
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <p class="text-gray-600 text-sm sm:text-lg">Project Total</p>
                        <input type="text"
                            class="w-16 sm:w-20 text-sm sm:text-lg font-semibold px-2 py-1 rounded border text-center"
                            value="{{ $sumProjects }}" readonly disabled>
                    </div>
                    <div class="flex items-center justify-between">
                        <p class="text-gray-600 text-sm sm:text-lg">Tasks Done</p>
                        <input type="text"
                            class="w-16 sm:w-20 text-sm sm:text-lg font-semibold px-2 py-1 rounded border text-center"
                            value="{{ $sumTasks }}" readonly disabled>
                    </div>
                    {{-- <div class="flex items-center justify-between">
                        <p class="text-gray-600 text-sm sm:text-lg">Total Leave</p>
                        <input type="text"
                            class="w-16 sm:w-20 text-sm sm:text-lg font-semibold px-2 py-1 rounded border text-center"
                            value="{{ $totalDayOff }}" readonly disabled>
                    </div> --}}
                </div>

                <!-- Form Input -->
                <div class="col-span-1 sm:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <!-- Kolom Kiri -->
                    <div class="space-y-4">
                        <div>
                            <label class="text-gray-600 block mb-1 text-sm">Email</label>
                            <input type="email" name="work_email" value="{{ $user->employee->work_email }}"
                                class="w-full border rounded-md px-3 py-2" readonly>
                        </div>
                        <div>
                            <label class="text-gray-600 block mb-1 text-sm">No. HP</label>
                            <input type="text" name="phone_number" value="{{ $user->employee->phone_number }}"
                                class="w-full border rounded-md px-3 py-2" readonly>
                        </div>
                        <div>
                            <label class="text-gray-600 block mb-1 text-sm">Alamat</label>
                            <input type="text" name="address" value="{{ $user->employee->address }}"
                                class="w-full border rounded-md px-3 py-2" readonly>
                        </div>
                    </div>

                    <!-- Kolom Kanan -->
                    <div class="space-y-4">
                        <div>
                            <label class="text-gray-600 block mb-1 text-sm">Password</label>
                            <input type="password" name="password" class="w-full border rounded-md px-3 py-2" readonly>
                        </div>
                        <div>
                            <label class="text-gray-600 block mb-1 text-sm">Link Telegram</label>
                            <input type="text" name="telegram_link" value="{{ $user->employee->telegram_link }}"
                                class="w-full border rounded-md px-3 py-2" readonly>
                        </div>
                        <div>
                            <label class="text-gray-600 block mb-1 text-sm">Tanggal Lahir</label>
                            <input type="date" name="birth_date" value="{{ $user->employee->birth_date }}"
                                class="w-full border rounded-md px-3 py-2" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-layouts.layout>

<!-- JS: Foto & Edit Toggle -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('photo-upload');
        const imagePreview = document.getElementById('image-preview');
        const reactiveButton = document.getElementById('reactive-button');
        const formEdit = document.getElementById('edit-form');

        reactiveButton.addEventListener('click', function(e) {
            e.preventDefault();
            if (this.innerText === 'Edit') {
                const inputs = formEdit.querySelectorAll('input:not([type="hidden"]):not([disabled])');
                inputs.forEach(input => input.removeAttribute('readonly'));
                this.innerText = 'Save';
            } else {
                formEdit.submit();
            }
        });

        fileInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.innerHTML = '';
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.alt = 'Profile Picture';
                    img.id = 'current-image';
                    img.className = 'w-24 h-24 rounded-full object-cover';
                    imagePreview.appendChild(img);
                };
                reader.readAsDataURL(file);
            } else {
                imagePreview.innerHTML = `
                    <div class="w-24 h-24 bg-zinc-200 rounded-full flex items-center justify-center overflow-hidden">
                        <span class="text-gray-400 text-sm">Preview</span>
                    </div>
                `;
            }
        });
    });
</script>
