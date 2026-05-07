<x-guest-layout>
    <div class="w-full max-w-md mx-auto px-4 py-16 sm:py-20 lg:py-24">
        <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden">
            <div class="px-8 py-10 sm:px-10 sm:py-12">
                <div class="text-center mb-10">
                    <div class="flex flex-col items-center justify-center mb-6">
                        <h1 class="text-4xl font-serif font-bold text-gray-900 tracking-wide">Gentry</h1>
                        <span class="text-xs tracking-[0.3em] uppercase text-gray-600 mt-2 font-medium">Timepieces</span>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Sign in to your account</h2>
                    <p class="mt-4 text-sm text-gray-600 leading-relaxed">Manage inventory, appraisals, consignments and sales</p>
                </div>

                <x-auth-session-status class="mb-6" :status="session('status')" />

                <form class="space-y-6" method="POST" action="{{ route('login') }}">
                    @csrf

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

                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-900 mb-2">Password</label>
                        <x-text-input
                            id="password"
                            name="password"
                            type="password"
                            required
                            placeholder="••••••••"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-500 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-gray-800 focus:border-transparent bg-gray-50 focus:bg-white"
                        />
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm" />
                    </div>

                    <div class="flex items-center justify-between pt-2">
                        <label for="remember_me" class="flex items-center cursor-pointer">
                            <input
                                id="remember_me"
                                name="remember"
                                type="checkbox"
                                class="w-4 h-4 text-gray-800 border border-gray-300 rounded focus:ring-2 focus:ring-gray-800 focus:ring-offset-0 transition-all"
                            >
                            <span class="ml-2.5 text-sm text-gray-700 font-medium">Remember me</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm font-medium text-gray-700 hover:text-gray-900 transition-colors duration-200">
                                Forgot password?
                            </a>
                        @endif
                    </div>

                    <button
                        type="submit"
                        class="w-full mt-6 bg-gray-900 text-white font-semibold py-3 px-4 rounded-lg hover:bg-gray-800 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-gray-800 focus:ring-offset-2 shadow-md hover:shadow-lg transform hover:scale-[1.02] active:scale-95"
                    >
                        Sign in
                    </button>
                </form>

                <div class="mt-8 text-center">
                    <p class="text-xs text-gray-500 uppercase tracking-widest font-medium">
                        Premium Watch Management System
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
