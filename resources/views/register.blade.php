<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Register - {{ config('app.name', 'Laravel') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <script src="https://cdn.tailwindcss.com"></script>
        @endif
    </head>
    <body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] dark:text-[#EDEDEC] min-h-screen flex items-center justify-center p-6">
        <div class="w-full max-w-md">
            <div class="bg-white dark:bg-[#161615] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d] rounded-lg p-8">
                <h1 class="text-2xl font-medium mb-6 text-[#1b1b18] dark:text-[#EDEDEC]">Create Account</h1>

                @if (session('success'))
                    <div class="mb-4 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-sm text-green-800 dark:text-green-200">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-sm">
                        <ul class="list-disc list-inside text-red-800 dark:text-red-200 text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" id="register-form" class="space-y-6">
                    @csrf

                    <div>
                        <label for="username" class="block text-sm font-medium mb-2 text-[#1b1b18] dark:text-[#EDEDEC]">
                            Username
                        </label>
                        <input
                            type="text"
                            id="username"
                            name="username"
                            value="{{ old('username') }}"
                            required
                            autofocus
                            class="w-full px-4 py-2 border border-[#e3e3e0] dark:border-[#3E3E3A] bg-white dark:bg-[#161615] text-[#1b1b18] dark:text-[#EDEDEC] rounded-sm focus:outline-none focus:ring-2 focus:ring-[#f53003] dark:focus:ring-[#FF4433] focus:border-transparent"
                            placeholder="Enter your username"
                        >
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium mb-2 text-[#1b1b18] dark:text-[#EDEDEC]">
                            Password
                        </label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            required
                            minlength="8"
                            class="w-full px-4 py-2 border border-[#e3e3e0] dark:border-[#3E3E3A] bg-white dark:bg-[#161615] text-[#1b1b18] dark:text-[#EDEDEC] rounded-sm focus:outline-none focus:ring-2 focus:ring-[#f53003] dark:focus:ring-[#FF4433] focus:border-transparent"
                            placeholder="Enter your password (minimum 8 characters)"
                        >
                        <p id="password-error" class="mt-1 text-sm text-red-600 dark:text-red-400 hidden"></p>
                        <p class="mt-1 text-xs text-[#706f6c] dark:text-[#A1A09A]">Password must be at least 8 characters long</p>
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium mb-2 text-[#1b1b18] dark:text-[#EDEDEC]">
                            Confirm Password
                        </label>
                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            required
                            class="w-full px-4 py-2 border border-[#e3e3e0] dark:border-[#3E3E3A] bg-white dark:bg-[#161615] text-[#1b1b18] dark:text-[#EDEDEC] rounded-sm focus:outline-none focus:ring-2 focus:ring-[#f53003] dark:focus:ring-[#FF4433] focus:border-transparent"
                            placeholder="Confirm your password"
                        >
                        <p id="password-confirmation-error" class="mt-1 text-sm text-red-600 dark:text-red-400 hidden"></p>
                    </div>

                    <button
                        type="submit"
                        class="w-full px-5 py-2.5 bg-[#1b1b18] dark:bg-[#eeeeec] text-white dark:text-[#1C1C1A] border border-black dark:border-[#eeeeec] rounded-sm font-medium hover:bg-black dark:hover:bg-white dark:hover:border-white transition-colors"
                    >
                        Register
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <a href="{{ route('login') }}" class="text-sm text-[#706f6c] dark:text-[#A1A09A] hover:text-[#1b1b18] dark:hover:text-[#EDEDEC] underline underline-offset-4">
                        Already have an account? Login here
                    </a>
                </div>
            </div>
        </div>

        <script>
            // Password validation
            const passwordInput = document.getElementById('password');
            const passwordError = document.getElementById('password-error');
            const passwordConfirmationInput = document.getElementById('password_confirmation');
            const passwordConfirmationError = document.getElementById('password-confirmation-error');
            const registerForm = document.getElementById('register-form');

            function validatePassword() {
                const password = passwordInput.value;
                
                if (password.length > 0 && password.length < 8) {
                    passwordError.textContent = 'Password must be at least 8 characters long';
                    passwordError.classList.remove('hidden');
                    passwordInput.classList.add('border-red-500', 'dark:border-red-500');
                    passwordInput.classList.remove('border-[#e3e3e0]', 'dark:border-[#3E3E3A]');
                    return false;
                } else {
                    passwordError.classList.add('hidden');
                    passwordInput.classList.remove('border-red-500', 'dark:border-red-500');
                    passwordInput.classList.add('border-[#e3e3e0]', 'dark:border-[#3E3E3A]');
                    return true;
                }
            }

            function validatePasswordMatch() {
                const password = passwordInput.value;
                const passwordConfirmation = passwordConfirmationInput.value;
                
                if (passwordConfirmation.length > 0 && password !== passwordConfirmation) {
                    passwordConfirmationError.textContent = 'Passwords do not match';
                    passwordConfirmationError.classList.remove('hidden');
                    passwordConfirmationInput.classList.add('border-red-500', 'dark:border-red-500');
                    passwordConfirmationInput.classList.remove('border-[#e3e3e0]', 'dark:border-[#3E3E3A]');
                    return false;
                } else {
                    passwordConfirmationError.classList.add('hidden');
                    passwordConfirmationInput.classList.remove('border-red-500', 'dark:border-red-500');
                    passwordConfirmationInput.classList.add('border-[#e3e3e0]', 'dark:border-[#3E3E3A]');
                    return true;
                }
            }

            // Real-time validation
            passwordInput.addEventListener('input', function() {
                validatePassword();
                // Also re-validate confirmation when password changes
                if (passwordConfirmationInput.value.length > 0) {
                    validatePasswordMatch();
                }
            });
            passwordInput.addEventListener('blur', validatePassword);
            passwordConfirmationInput.addEventListener('input', validatePasswordMatch);
            passwordConfirmationInput.addEventListener('blur', validatePasswordMatch);

            // Form submission validation
            registerForm.addEventListener('submit', function(event) {
                const isPasswordValid = validatePassword();
                const isPasswordMatch = validatePasswordMatch();
                
                if (!isPasswordValid || !isPasswordMatch) {
                    event.preventDefault();
                    if (!isPasswordValid) {
                        passwordInput.focus();
                    } else if (!isPasswordMatch) {
                        passwordConfirmationInput.focus();
                    }
                }
            });
        </script>
    </body>
</html>

