<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-gray-50">
        <div class="max-w-md w-full space-y-8">
            <div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">Create account</h2>
                <p class="mt-2 text-center text-sm text-gray-600">Register for access to the system. Staff accounts are restricted to admin creation.</p>
            </div>
            <div class="bg-white py-8 px-6 shadow rounded-lg">
                <form class="space-y-6" method="POST" action="{{ route('register') }}">
                    @csrf

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                        <div class="mt-1">
                            <x-text-input id="name" name="name" type="text" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" :value="old('name')" />
                        </div>
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
                        <div class="mt-1">
                            <x-text-input id="email" name="email" type="email" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" :value="old('email')" />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                            <div class="mt-1">
                                <x-text-input id="password" name="password" type="password" required minlength="8" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm password</label>
                            <div class="mt-1">
                                <x-text-input id="password_confirmation" name="password_confirmation" type="password" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                            </div>
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>
                    </div>

                    @if(auth()->check() && auth()->user()->role === 'admin')
                        <div>
                            <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                            <div class="mt-1">
                                <select id="role" name="role" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="staff" {{ old('role')=='staff' ? 'selected' : '' }}>Staff</option>
                                    <option value="appraiser" {{ old('role')=='appraiser' ? 'selected' : '' }}>Appraiser</option>
                                    <option value="admin" {{ old('role')=='admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                            </div>
                        </div>
                    @else
                        @php $presetRole = request('role', 'appraiser'); @endphp
                        <input type="hidden" name="role" value="{{ $presetRole }}">
                        <p class="text-sm text-gray-500">Registering as: <strong class="capitalize">{{ $presetRole }}</strong></p>
                    @endif

                    <div>
                        <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Register
                        </button>
                    </div>

                    <div class="text-sm text-center">
                        <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500">Already registered? Sign in</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        // Simple client-side validation: ensure passwords match
        (function(){
            const form = document.querySelector('form[action="{{ route('register') }}"]');
            if (!form) return;
            const pwd = form.querySelector('#password');
            const pwdConfirm = form.querySelector('#password_confirmation');
            const submitBtn = form.querySelector('button[type="submit"]');
            const errEl = document.createElement('p');
            errEl.style.color = '#dc2626'; errEl.style.fontSize = '0.9rem';
            errEl.style.display = 'none';
            pwdConfirm.parentNode.appendChild(errEl);

            function validate() {
                if (!pwd || !pwdConfirm) return;
                if (pwd.value !== pwdConfirm.value) {
                    errEl.textContent = 'Passwords do not match.'; errEl.style.display = 'block'; submitBtn.disabled = true;
                } else { errEl.style.display = 'none'; submitBtn.disabled = false; }
            }

            pwd && pwd.addEventListener('input', validate);
            pwdConfirm && pwdConfirm.addEventListener('input', validate);
            validate();
        })();
    </script>
</x-guest-layout>
