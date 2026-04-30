<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-100 via-gray-50 to-gray-100 py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-md">
            <!-- Logo & Branding -->
            <div class="text-center mb-10">
                <div class="flex flex-col items-center justify-center mb-6">
                    <h1 class="text-4xl font-serif font-bold text-gray-900 tracking-wide">Gentry</h1>
                    <span class="text-xs tracking-[0.3em] uppercase text-gray-600 mt-1 font-medium">Timepieces</span>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Create account</h2>
                <p class="mt-3 text-sm text-gray-600 leading-relaxed">Register for access to the system. Staff accounts are restricted to admin creation</p>
            </div>

            <!-- Register Form Card -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
                <div class="px-8 py-8">
                    <form class="space-y-5" method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- Name Field -->
                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-900 mb-2">Full Name</label>
                            <x-text-input 
                                id="name" 
                                name="name" 
                                type="text" 
                                required 
                                placeholder="John Doe"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-500 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-gray-800 focus:border-transparent bg-gray-50 focus:bg-white" 
                                :value="old('name')" 
                            />
                            <x-input-error :messages="$errors->get('name')" class="mt-2 text-sm" />
                        </div>

                        <!-- Email Field -->
                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-900 mb-2">Email address</label>
                            <x-text-input 
                                id="email" 
                                name="email" 
                                type="email" 
                                required 
                                placeholder="you@example.com"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-500 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-gray-800 focus:border-transparent bg-gray-50 focus:bg-white" 
                                :value="old('email')" 
                            />
                            <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm" />
                        </div>

                        <!-- Password Fields -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="password" class="block text-sm font-semibold text-gray-900 mb-2">Password</label>
                                <x-text-input 
                                    id="password" 
                                    name="password" 
                                    type="password" 
                                    required 
                                    minlength="8" 
                                    placeholder="••••••••"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-500 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-gray-800 focus:border-transparent bg-gray-50 focus:bg-white" 
                                />
                                <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm" />
                            </div>
                            <div>
                                <label for="password_confirmation" class="block text-sm font-semibold text-gray-900 mb-2">Confirm</label>
                                <x-text-input 
                                    id="password_confirmation" 
                                    name="password_confirmation" 
                                    type="password" 
                                    required 
                                    placeholder="••••••••"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-500 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-gray-800 focus:border-transparent bg-gray-50 focus:bg-white" 
                                />
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-sm" />
                            </div>
                        </div>

                        <!-- Role Selection -->
                        @if(auth()->check() && auth()->user()->role === 'admin')
                            <div>
                                <label for="role" class="block text-sm font-semibold text-gray-900 mb-2">Role</label>
                                <select 
                                    id="role" 
                                    name="role" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg text-gray-900 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-gray-800 focus:border-transparent bg-gray-50 focus:bg-white"
                                >
                                    <option value="staff" {{ old('role') === 'staff' ? 'selected' : '' }}>Staff</option>
                                    <option value="appraiser" {{ old('role') === 'appraiser' ? 'selected' : '' }}>Appraiser</option>
                                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                            </div>
                        @else
                            @php $presetRole = request('role', 'appraiser'); @endphp
                            <input type="hidden" name="role" value="{{ $presetRole }}">
                            <p class="text-sm text-gray-600 px-4 py-2 bg-gray-50 rounded-lg">
                                Registering as: <strong class="capitalize text-gray-900">{{ $presetRole }}</strong>
                            </p>
                        @endif

                        <!-- Register Button -->
                        <button 
                            type="submit" 
                            class="w-full mt-6 bg-gray-900 text-white font-semibold py-3 px-4 rounded-lg hover:bg-gray-800 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-gray-800 focus:ring-offset-2 shadow-md hover:shadow-lg transform hover:scale-[1.02] active:scale-95"
                        >
                            Create Account
                        </button>
                    </form>
                </div>
            </div>

            <!-- Footer Info -->
            <div class="mt-8 text-center">
                <p class="text-xs text-gray-500 uppercase tracking-widest font-medium">
                    Premium Watch Management System
                </p>
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
            errEl.className = 'text-red-600 text-sm mt-2';
            errEl.style.display = 'none';
            pwdConfirm.parentNode.appendChild(errEl);

            function validate() {
                if (!pwd || !pwdConfirm) return;
                if (pwd.value !== pwdConfirm.value) {
                    errEl.textContent = 'Passwords do not match.';
                    errEl.style.display = 'block';
                    submitBtn.disabled = true;
                    submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                } else {
                    errEl.style.display = 'none';
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                }
            }

            pwd && pwd.addEventListener('input', validate);
            pwdConfirm && pwdConfirm.addEventListener('input', validate);
            validate();
        })();
    </script>
</x-guest-layout>
