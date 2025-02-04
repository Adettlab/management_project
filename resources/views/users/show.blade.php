<x-layouts.layout :title="$title">
    <div class="bg-white rounded-lg shadow-md p-6 max-w-full w-full h-full mx-auto">
        <form action="{{ route('users.update', $user->employee->id)}}" method="POST" id="edit-form" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="flex justify-start items-start mb-8 gap-4 pl-8 space-x-8">
                <div class="relative mt-6 z-1" id="image-preview">
                    @if ($user->employee->photo)
                        <img
                            src="/storage/{{ $user->employee->photo }}"
                            alt="Profile Picture"
                            class="w-24 h-24 rounded-full object-cover" id="current-image">
                    @else
                        <div class="w-24 h-24 bg-zinc-200 rounded-full flex items-center justify-center overflow-hidden">
                            <span class="text-gray-400 text-sm">Preview</span>
                        </div>
                    @endif
                    @if ($user->employee->photo)
                        <input type="hidden" name="old_photo" id="old_photo" value="{{ $user->employee->photo }}">
                    @endif
                </div>

                <div class="mt-6 flex-1 pr-8">
                    <h2 class="text-xl font-semibold">{{ $user->name }}</h2>
                    <p class="text-gray-600">{{ $user->employee->role->name }}</p>

                    <div class="mt-2 flex gap-4">
                        <div>
                            <label for="photo-upload" class="cursor-pointer bg-sky-blue text-white text-xs font-medium px-4 py-1 rounded hover:bg-blue-600">
                                Upload Picture
                            </label>
                            <input id="photo-upload" name="photo" type="file" accept="image/*" class="hidden" />
                        </div>
                        <button class="ml-auto mr-8 bg-black text-xs w-24 text-white px-2 py-1 rounded hover:bg-gray-800" id="reactive-button">
                            Edit
                        </button>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-6 mb-4 mr-7 ml-4">
                <div class="space-y-3 mt-10">
                    <div class="flex items-center justify-between mr-24">
                        <p class="text-gray-600 text-lg">Project Total</p>
                        <input type="text" class="w-20 text-lg font-semibold px-2 py-1 rounded border text-center" value="{{ $sumProjects }}" readonly disabled>
                    </div>
                    <div class="flex items-center justify-between mr-24">
                        <p class="text-gray-600 text-lg">Tasks Done</p>
                        <input type="text" class="w-20 text-lg font-semibold px-2 py-1 rounded border text-center" value="{{ $sumTasks }}" readonly disabled>
                    </div>
                    <div class="flex items-center justify-between mr-24">
                        <p class="text-gray-600 text-lg">Total Leave</p>
                        <input type="text" class="w-20 text-lg font-semibold px-2 py-1 rounded border text-center" value="{{$totalDayOff}}" readonly disabled>
                    </div>
                </div>

                <div class="col-span-2 grid grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <label class="text-gray-600 block mb-1">Email</label>
                            <input type="email" name="work_email" value="{{ $user->employee->work_email }}" class="w-full border rounded-md px-3 py-2" readonly>
                        </div>
                        <div>
                            <label class="text-gray-600 block mb-1">No. HP</label>
                            <input type="text" name="phone_number" value="{{ $user->employee->phone_number }}" class="w-full border rounded-md px-3 py-2" readonly>
                        </div>
                        <div>
                            <label class="text-gray-600 block mb-1">Alamat</label>
                            <input type="text" name="address" value="{{ $user->employee->address }}" class="w-full border rounded-md px-3 py-2" readonly>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="text-gray-600 block mb-1">Password</label>
                            <input type="password" name="password" class="w-full border rounded-md px-3 py-2" readonly>
                        </div>
                        <div>
                            <label class="text-gray-600 block mb-1">Link Telegram</label>
                            <input type="text" name="telegram_link" value="{{ $user->employee->telegram_link }}" class="w-full border rounded-md px-3 py-2" readonly>
                        </div>
                        <div>
                            <label class="text-gray-600 block mb-1">Tanggal Lahir</label>
                            <div class="relative">
                                <input type="date" name="birth_date" value="{{ $user->employee->birth_date }}" class="w-full border rounded-md px-3 py-2" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>


        <div class="px-5 pb-7 pt-2 mb-4">
             <div class="max-w-sm">
                <div class="text-sm text-gray-600 mb-2">Work hours</div>
                <div class="flex items-center">
                    <div class="relative h-7 bg-gray-200 rounded-full overflow-hidden flex-grow">
                        <div class="absolute h-full bg-blue-900 rounded-full" style="width: {{$user->totalWorkDuration > 100 ? 100 : $user->totalWorkDuration}}%;"></div>
                        <div class="absolute inset-0 flex items-center justify-center text-xs font-bold {{$user->totalWorkDuration > 45 ? 'text-white' : 'text-black'}}">
                            {{ $user->totalWorkDuration }}%
                        </div>
                    </div>

                @if ($user->totalWorkDuration > 100)
                    <div class="flex items-center ml-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24">
                            <path fill="currentColor" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10s10-4.48 10-10S17.52 2 12 2m1 15h-2v-6h2zm0-8h-2V7h2z"/>
                        </svg>
                        <span class="text-sm text-gray-500 ml-1">Overwork</span>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.layout>
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
                inputs.forEach(input => {
                    input.removeAttribute('readonly');
                });
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
