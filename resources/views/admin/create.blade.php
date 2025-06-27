<x-layouts.layout :title="$title" :active="$active">
    <main class="h-auto flex flex-col items-center justify-center py-8">
        <div class="bg-white w-[80%] md:w-[60%] py-9 px-12 rounded-xl border border-gray-200">
            <form action="{{ route('admin.store') }}" method="POST">
                @csrf
                <h1 class="font-semibold text-xl mb-6 text-center">Create New Account</h1>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Username Input -->
                    <div class="flex flex-col space-y-1">
                        <label for="username" class="primary-gray font-medium text-sm">Username</label>
                        <input
                            class="primary-gray font-medium rounded-lg py-2 px-3 text-sm border border-gray-200 outline-none"
                            placeholder="Enter username" type="text" id="username" name="name"
                            value="{{ old('name') }}" required>
                        @error('name')
                            <span class="text-red-600 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Password Input -->
                    <div class="flex flex-col space-y-1">
                        <label for="password" class="primary-gray font-medium text-sm">Password</label>
                        <input
                            class="primary-gray font-medium rounded-lg py-2 px-3 text-sm border border-gray-200 outline-none"
                            placeholder="Enter password" type="password" id="password" name="password" required>
                        @error('password')
                            <span class="text-red-600 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <!-- Email Input -->
                    <div class="flex flex-col space-y-1">
                        <label for="email" class="primary-gray font-medium text-sm">Email Akun</label>
                        <input
                            class="primary-gray font-medium rounded-lg py-2 px-3 text-sm border border-gray-200 outline-none"
                            placeholder="Enter email" type="email" id="email" name="email"
                            value="{{ old('email') }}" required>
                        @error('email')
                            <span class="text-red-600 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Password Confirmation -->
                    <div class="flex flex-col space-y-1">
                        <label for="password_confirmation" class="primary-gray font-medium text-sm">Confirm
                            password</label>
                        <input
                            class="primary-gray font-medium rounded-lg py-2 px-3 text-sm border border-gray-200 outline-none"
                            placeholder="Confirm password" type="password" id="password_confirmation"
                            name="password_confirmation" required>
                        @error('password_confirmation')
                            <span class="text-red-600 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Role Selection -->
                <div class="mt-6">
                    <label for="role_id" class="primary-gray font-medium text-sm">Division</label>
                    <select name="role_id" id="role_id"
                        class="w-full primary-gray font-medium rounded-lg py-2 px-3 text-sm border border-gray-200 outline-none"
                        required>
                        <option value="">Select Division</option>
                        @foreach ($roles as $role)
                            @if ($role->id != 2)
                                <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                            @endif
                        @endforeach
                    </select>
                    @error('role_id')
                        <span class="text-red-600 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Permission Mode Selection -->
                <div class="mt-6">
                    <label class="primary-gray font-medium text-sm">Permission Mode</label>
                    <div class="mt-2 space-y-2">
                        <div class="flex items-center">
                            <input type="radio" id="default_permissions" name="permission_mode" value="default" 
                                   class="mr-2" checked onchange="togglePermissionMode()">
                            <label for="default_permissions" class="text-sm">Use Default Role Permissions</label>
                        </div>
                        <div class="flex items-center">
                            <input type="radio" id="custom_permissions" name="permission_mode" value="custom" 
                                   class="mr-2" onchange="togglePermissionMode()">
                            <label for="custom_permissions" class="text-sm">Set Custom Permissions</label>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">
                        Default: Permissions will be based on the selected role. Custom: You can set specific permissions for this user.
                    </p>
                </div>

                <!-- Custom Permissions Section -->
                <div id="custom_permissions_section" class="mt-6 w-full" style="display: none;">
                    <label class="primary-gray font-medium text-sm">Custom Permissions</label>
                    <div class="space-y-4 mt-2">
                        @foreach ($pages as $page)
                            <div class="border border-gray-300 rounded-lg p-4">
                                <div class="flex justify-between items-center">
                                    <span class="font-medium text-sm capitalize">{{ $page->name }}</span>
                                    <div class="flex space-x-4">
                                        <div class="flex items-center">
                                            <input type="checkbox" id="allow_view_{{ $page->id }}"
                                                name="permissions[{{ $page->id }}][allow_view]" value="1">
                                            <label for="allow_view_{{ $page->id }}" class="ml-2 text-sm">View</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="allow_create_{{ $page->id }}"
                                                name="permissions[{{ $page->id }}][allow_create]" value="1">
                                            <label for="allow_create_{{ $page->id }}" class="ml-2 text-sm">Create</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="allow_update_{{ $page->id }}"
                                                name="permissions[{{ $page->id }}][allow_update]" value="1">
                                            <label for="allow_update_{{ $page->id }}" class="ml-2 text-sm">Update</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="allow_delete_{{ $page->id }}"
                                                name="permissions[{{ $page->id }}][allow_delete]" value="1">
                                            <label for="allow_delete_{{ $page->id }}" class="ml-2 text-sm">Delete</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <p class="text-xs text-gray-500 mt-2">
                        Note: Dashboard and Activity pages will have view access by default for all users.
                    </p>
                </div>

                <div class="mt-9 mb-4 flex justify-center">
                    <button type="submit"
                        class="bg-primary-black hover:bg-zinc-500 text-white text-sm px-10 py-1 rounded-lg">Create
                        Account</button>
                </div>
            </form>
        </div>
    </main>

    <script>
        function togglePermissionMode() {
            const customPermissionsSection = document.getElementById('custom_permissions_section');
            const customRadio = document.getElementById('custom_permissions');
            
            if (customRadio.checked) {
                customPermissionsSection.style.display = 'block';
            } else {
                customPermissionsSection.style.display = 'none';
                // Clear all custom permission checkboxes
                const checkboxes = customPermissionsSection.querySelectorAll('input[type="checkbox"]');
                checkboxes.forEach(checkbox => checkbox.checked = false);
            }
        }

        // Role-based permission suggestions
        document.getElementById('role_id').addEventListener('change', function() {
            const roleId = this.value;
            const customRadio = document.getElementById('custom_permissions');
            
            if (!customRadio.checked) return; // Only suggest if custom mode is selected
            
            // Clear existing selections
            const checkboxes = document.querySelectorAll('#custom_permissions_section input[type="checkbox"]');
            checkboxes.forEach(checkbox => checkbox.checked = false);
            
            // Role-based suggestions (sesuai dengan logic default di User model)
            const roleSuggestions = {
                '1': { // Analyst
                    'projects': ['view'],
                    'tasks': ['view', 'create', 'update']
                },
                '3': { // Designer  
                    'projects': ['view'],
                    'tasks': ['view', 'create', 'update']
                },
                '4': { // Engineer Web
                    'projects': ['view'],
                    'tasks': ['view', 'create', 'update']
                },
                '5': { // Engineer Mobile
                    'projects': ['view'],
                    'tasks': ['view', 'create', 'update']
                },
                '6': { // Engineer Tester
                    'projects': ['view'],
                    'tasks': ['view', 'create', 'update']
                }
            };
            
            if (roleSuggestions[roleId]) {
                Object.keys(roleSuggestions[roleId]).forEach(pageName => {
                    const permissions = roleSuggestions[roleId][pageName];
                    const pageElement = document.querySelector(`[id*="${pageName}"]`);
                    
                    if (pageElement) {
                        const pageId = pageElement.id.split('_').pop();
                        permissions.forEach(permission => {
                            const checkbox = document.getElementById(`allow_${permission}_${pageId}`);
                            if (checkbox) checkbox.checked = true;
                        });
                    }
                });
            }
        });
    </script>
</x-layouts.layout>