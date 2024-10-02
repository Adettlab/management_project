<x-layout>
    <div class="flex justify-center items-center min-h-screen bg-gradient-to-b from-white to-blue-50">
        <div class="bg-white shadow-lg rounded-lg p-8 max-w-sm w-full">
            <h2 class="text-2xl font-bold text-center mb-6">Helper</h2>
            <h3 class="text-xl text-center mb-6">Sign in to your account</h3>
            <p class="text-center mb-4 text-sm text-gray-500">Or <a href="#" class="text-blue-500">create a new
                    account</a></p>

            {{-- Error Message --}}
            @if ($errors->has('login'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ $errors->first('login') }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('authenticate') }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700" for="email">Email address</label>
                    <input type="email" id="email" name="email"
                        class="mt-1 p-2 w-full border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        value="{{ old('email') }}" required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700" for="password">Password</label>
                    <input type="password" id="password" name="password"
                        class="mt-1 p-2 w-full border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        required>
                </div>

                <div class="flex items-center justify-between mb-4">
                    <label class="flex items-center">
                        <input type="checkbox"
                            class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-600">Remember me</span>
                    </label>
                    <a href="#" class="text-sm text-blue-500">Forgot password?</a>
                </div>

                <button type="submit"
                    class="w-full bg-blue-500 text-white p-2 rounded-lg font-medium hover:bg-blue-600">Sign in</button>
            </form>

            <div class="flex justify-center items-center my-4">
                <span class="text-gray-500">or</span>
            </div>

            <div class="flex justify-center space-x-4">
                <a href="#" class="p-2 bg-gray-100 hover:bg-gray-200 rounded-full">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/5/51/Facebook_f_logo_%282019%29.svg"
                        alt="Facebook" class="w-6 h-6">
                </a>
                <a href="#" class="p-2 bg-gray-100 hover:bg-gray-200 rounded-full">
                    <img src="https://github.githubassets.com/images/modules/logos_page/GitHub-Mark.png" alt="GitHub"
                        class="w-6 h-6">
                </a>
                <a href="#" class="p-2 bg-gray-100 hover:bg-gray-200 rounded-full">
                    <img src="https://banner2.cleanpng.com/20240119/sut/transparent-x-logo-logo-brand-identity-company-organization-black-background-white-x-logo-for-1710916376217.webp"
                        alt="Twitter" class="w-6 h-6">
                </a>
                <a href="#" class="p-2 bg-gray-100 hover:bg-gray-200 rounded-full">
                    <img src="https://cdn1.iconfinder.com/data/icons/google-s-logo/150/Google_Icons-09-512.png"
                        alt="Google" class="w-6 h-6">
                </a>
            </div>
        </div>
    </div>
</x-layout>
