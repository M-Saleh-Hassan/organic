<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Organic Project</title>
    <!-- Add TailwindCSS or Bootstrap -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="flex items-center justify-center h-screen">
        <div class="bg-white shadow-md rounded-lg p-8 w-96">
            <div class="text-center mb-6">
                <h1 class="text-2xl font-bold text-green-600">Organic Project</h1>
                <p class="text-gray-500">Login to your account</p>
            </div>
            @if (session('status'))
                <div class="mb-4 text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif
            <form method="POST" action="{{ route('admin.login.post') }}">
                @csrf
                <!-- Email Field -->
                <div class="mb-4">
                    <label for="email" class="block text-gray-700">Email Address</label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autocomplete="email"
                        autofocus
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400 @error('email') border-red-500 @enderror"
                    />
                    @error('email')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <!-- Password Field -->
                <div class="mb-4">
                    <label for="password" class="block text-gray-700">Password</label>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400 @error('password') border-red-500 @enderror"
                    />
                    @error('password')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <!-- Remember Me -->
                {{-- <div class="flex items-center justify-between mb-6">
                    <div>
                        <label class="inline-flex items-center">
                            <input
                                type="checkbox"
                                name="remember"
                                class="form-checkbox text-green-500"
                                {{ old('remember') ? 'checked' : '' }}
                            />
                            <span class="ml-2 text-gray-600">Remember Me</span>
                        </label>
                    </div>
                    <div>
                        @if (Route::has('password.request'))
                            <a
                                href="{{ route('password.request') }}"
                                class="text-sm text-green-600 hover:underline"
                            >
                                Forgot Your Password?
                            </a>
                        @endif
                    </div>
                </div> --}}
                <!-- Submit Button -->
                <div>
                    <button
                        type="submit"
                        class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-lg"
                    >
                        Login
                    </button>
                </div>
            </form>
            {{-- <div class="text-center mt-4">
                <p class="text-sm text-gray-600">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="text-green-600 hover:underline">Register here</a>
                </p>
            </div> --}}
        </div>
    </div>
</body>
</html>
