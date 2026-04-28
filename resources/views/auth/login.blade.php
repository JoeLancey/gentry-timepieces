<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">Sign in to your account</h2>
                <p class="mt-2 text-center text-sm text-gray-600">Manage inventory, appraisals, consignments and sales.</p>
            </div>
            <div class="bg-white py-8 px-6 shadow rounded-lg">
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form class="space-y-6" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
                        <div class="mt-1">
                            <x-text-input id="email" name="email" type="email" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" :value="old('email')" />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <div class="mt-1">
                            <x-text-input id="password" name="password" type="password" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-between">
                        <label for="remember_me" class="flex items-center">
                            <input id="remember_me" name="remember" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            <span class="ml-2 block text-sm text-gray-900">Remember me</span>
                        </label>

                        @if (Route::has('password.request'))
                            <div class="text-sm">
                                <a href="{{ route('password.request') }}" class="font-medium text-indigo-600 hover:text-indigo-500">Forgot your password?</a>
                            </div>
                        @endif
                    </div>

                    <div>
                        <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Sign in</button>
                    </div>
                </form>

                <p class="mt-6 text-center text-sm text-gray-600">Need an account? <a href="{{ route('register') }}" class="font-medium text-indigo-600 hover:text-indigo-500">Create one</a></p>
            </div>
        </div>
    </div>
</x-guest-layout>
