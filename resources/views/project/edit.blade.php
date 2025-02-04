<x-layouts.layout :title="$title" :active="$active">
    <main class="flex space-x-4">
        <form action="{{ route('projects.update', $project->id) }}" method="POST" enctype="multipart/form-data" class="flex-1 flex">
            @csrf
            @method('PUT')
            <div class="bg-white rounded shadow w-2/5 pt-4 px-5 pb-4 mr-4">
                <div class="flex flex-row items-center justify-between mb-2">
                    <h1 class="text-2xl font-semibold">Update Project</h1>
                    @if ($errors->has('error'))
                        <div class="flex bg-red-100 rounded-lg p-2 text-xs text-red-700" role="alert">
                            <svg class="w-4 h-4 inline mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                            </svg>
                            <div>
                                {{ $errors->first('error') }}
                            </div>
                        </div>
                    @endif
                </div>
                <div class="space-y-4 mt-6">
                    <div class="flex flex-col space-y-2">
                        <label class="block text-lg text-primary-white" for="name">Project name</label>
                        <input type="text" name="name" id="name" class="w-full bg-primary-white border border-primary-white px-3 py-2 text-sm rounded focus:outline-none" placeholder="project name.." required value="{{old('name', $project->name)}}">
                        @error('name')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                    </div>
                    <div class="flex flex-col space-y-2">
                        <label class="block text-lg text-primary-white">Date</label>
                        <div class="flex items-center justify-between w-full gap-4">
                            <div class="flex items-center w-[50%] gap-2">
                                <label for="start_date" class="text-sm text-gray-700">Start:</label>
                                <input type="date" name="start_date" id="start_date" class="w-full bg-primary-white border border-primary-white px-3 py-2 text-sm rounded focus:outline-none" required value="{{old('start_date', $project->start_date)}}">
                                @error('start_date')
                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="flex items-center w-[50%] gap-1">
                                <label for="end_date" class="text-sm text-gray-700">End:</label>
                                <input type="date" name="end_date" id="end_date"
                                    class="w-full bg-primary-white px-3 py-2 text-sm rounded focus:outline-none border border-primary-white" required value="{{old('end_date', $project->end_date)}}">
                                @error('end_date')
                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col space-y-2">
                        <label class="block text-lg text-primary-white" for="level">Level Project</label>
                        <select name="project_level_id" class="w-full bg-primary-white border border-primary-white px-3 py-2 text-sm rounded focus:outline-none" id="level" required>
                            <option value="">Select level project</option>
                            @foreach ($levels as $level)
                                <option value="{{ $level->id }}" {{ old('project_level_id', $project->project_level_id) == $level->id ? 'selected' : '' }}>{{ $level->name }}</option>
                            @endforeach
                        </select>
                        @error('project_level_id')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="flex flex-col space-y-2">
                        <label class="block text-lg text-primary-white" for="status">Status</label>
                        <select name="project_status_id" class="w-full bg-primary-white border border-primary-white px-3 py-2 text-sm rounded focus:outline-none" id="status" required>
                            <option value="">Select status project</option>
                            @foreach ($statuses as $status)
                                <option value="{{ $status->id }}" {{old('project_status_id', $project->project_status_id) == $status->id ? 'selected' : ''}}>{{ $status->name }}</option>
                            @endforeach
                        </select>
                        @error('project_status_id')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="flex flex-col space-y-2">
                        <label class="block text-lg text-primary-white" for="description">Project Description</label>
                        <textarea name="description" id="description" rows="2" placeholder="project description.."class="w-full bg-primary-white border border-primary-white px-3 py-1 text-sm rounded focus:outline-none" value="{{old('description', $project->description)}}"></textarea>
                        @error('description')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="bg-white rounded shadow w-3/5 pt-4 px-5 pb-4">
                <h1 class="text-2xl font-semibold mb-2">SDM</h1>
                <div class="space-y-4 mt-6">
                    <div class="flex flex-col space-y-2">
                        <label class="block text-lg text-primary-white" for="director">Project Director</label>
                        <select name="director_id" class="w-full bg-primary-white border border-primary-white px-3 py-2 text-sm rounded focus:outline-none" id="director">
                            <option value="">Select project director</option>
                            @foreach ($employees->where('role.name', 'Project Director') as $employee)
                                <option value="{{ $employee->id }}" {{old('director_id', $director->id ?? '') == $employee->id ? 'selected' : ''}}>{{ $employee->user->name }}</option>
                            @endforeach
                        </select>
                        @error('director_id')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="flex flex-col space-y-2">
                        <label class="block text-lg text-primary-white" for="analyst">Project Analyst</label>
                        <select name="analyst_id"
                            class="w-full bg-primary-white border border-primary-white px-3 py-2 text-sm rounded focus:outline-none" id="analyst">
                            <option value="">Select project analyst</option>
                            @foreach ($employees->where('role.name', 'Analyst') as $employee)
                                <option value="{{ $employee->id }}" {{old('analyst_id', $analyst->id ?? '') == $employee->id ? 'selected' : ''}}>{{ $employee->user->name }}</option>
                            @endforeach
                        </select>
                        @error('analyst_id')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="">
                        <div class="flex flex-row space-x-2 w-full">
                            <div class="w-[50%] space-y-2">
                                <label class="block text-lg text-primary-white" for="designer">Project Designer</label>
                                <select name="designer_id" class="w-full bg-primary-white border border-primary-white px-3 py-2 text-sm rounded focus:outline-none" id="designer">
                                    <option value="">Select project designer</option>
                                        @foreach ($employees->where('role.name', 'Designer') as $employee)
                                            <option value="{{ $employee->id }}" {{old('designer_id', $designer->id ?? '') == $employee->id ? 'selected' : ''}}>{{ $employee->user->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('designer_id')
                                        <span class="text-red-600 text-sm">{{ $message }}</span>
                                    @enderror
                            </div>
                            <div class="w-[50%] space-y-2">
                                <label class="block text-lg text-primary-white" for="engineer_web">Engineer Web</label>
                                <select name="engineer_web_id" class="w-full bg-primary-white border border-primary-white px-3 py-2 text-sm rounded focus:outline-none" id="engineer_web">
                                    <option value="">Select engineer web</option>
                                    @foreach ($employees->where('role.name', 'Engineer Web') as $employee)
                                        <option value="{{ $employee->id }}" {{old('engineer_web_id', $engineerWeb->id ?? '') == $employee->id ? 'selected' : ''}}>{{ $employee->user->name }}</option>
                                    @endforeach
                                </select>
                                @error('engineer_web_id')
                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <div class="flex flex-row space-x-2">
                            <div class="w-[50%] space-y-2">
                                <label class="block text-lg text-primary-white" for="engineer_mobile">Engineer Mobile</label>
                                <select name="engineer_mobile_id"class="w-full bg-primary-white border border-primary-white px-3 py-2 text-sm rounded focus:outline-none" id="engineer_mobile">
                                    <option value="">Select engineer mobile</option>
                                    @foreach ($employees->where('role.name', 'Engineer Mobile') as $employee)
                                        <option value="{{ $employee->id }}" {{old('engineer_mobile_id', $engineerMobile->id ?? '') == $employee->id ? 'selected' : ''}}>{{ $employee->user->name }}</option>
                                    @endforeach
                                </select>
                                @error('engineer_mobile_id')
                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="space-y-2 w-[50%]">
                                <label class="block text-lg text-primary-white" for="engineer_tester">Engineer Tester</label>
                                <select name="engineer_tester_id" class="w-full bg-primary-white border border-primary-white px-3 py-2 text-sm rounded focus:outline-none" id="engineer_tester">
                                    <option value="">Select engineer tester</option>
                                    @foreach ($employees->where('role.name', 'Engineer Tester') as $employee)
                                        <option value="{{ $employee->id }}" {{old('engineer_tester_id', $engineerTester->id ?? '') == $employee->id ? 'selected' : ''}}>{{ $employee->user->name }}</option>
                                    @endforeach
                                </select>
                                @error('engineer_tester_id')
                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Form Buttons -->
            <div class="fixed bottom-4 right-4 flex space-x-4">
                <a href="{{ url()->previous() }}"
                   class="bg-white text-black border border-black px-4 py-2 rounded-md hover:bg-gray-100">Cancel</a>
                <button type="submit" class="bg-black text-white px-4 py-2 rounded-md">Update</button>
            </div>
        </form>
    </main>

</x-layouts.layout>
