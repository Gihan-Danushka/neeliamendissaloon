<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Neeliya Mendis Saloons</title>
    <!-- Google Fonts: Playfair Display & Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite('resources/css/app.css')
    <style>
        .font-playfair { font-family: 'Playfair Display', serif; }
        .font-inter { font-family: 'Inter', sans-serif; }
        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        .bg-overlay {
            background: linear-gradient(135deg, rgba(30, 58, 138, 0.8) 0%, rgba(23, 37, 84, 0.4) 100%);
        }
        .logo-ring {
            box-shadow: 0 0 0 4px #ca8a04, 0 0 20px rgba(202, 138, 4, 0.4);
        }
        .input-focus:focus {
            border-color: #ca8a04;
            box-shadow: 0 0 0 3px rgba(202, 138, 4, 0.1);
        }
        .animate-fade-in {
            animation: fadeIn 0.8s ease-out forwards;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>

<body class="font-inter antialiased">
    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Access Denied',
                text: '{{ session('error') }}',
                confirmButtonColor: '#1e3a8a'
            });
        </script>
    @endif

    @if ($errors->has('login'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Login Failed',
                text: '{{ $errors->first('login') }}',
                confirmButtonColor: '#1e3a8a'
            });
        </script>
    @endif

    <div class="relative min-h-screen w-full flex items-center justify-center bg-gray-900">
        <!-- Background Overlay Image -->
        <div class="absolute inset-0 z-0">
            <img src="/images/img/login.jpg" alt="Background" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-overlay"></div>
        </div>

        <!-- Login Container -->
        <div class="relative z-10 w-full max-w-md px-6 animate-fade-in">
            <div class="glass-card p-8 rounded-2xl shadow-2xl overflow-visible">
                <!-- Round Logo Icon -->
                <div class="relative -top-20 flex justify-center mb-0 h-4 w-full">
                    <div class="bg-white rounded-full p-1 logo-ring w-32 h-32 flex items-center justify-center overflow-hidden transition-transform duration-500 hover:scale-105">
                        <img src="{{ asset('images/img/saloonlogo.png') }}" alt="Saloon Logo" class="w-28 h-28 object-contain rounded-full">
                    </div>
                </div>

                <div class="mt-8 text-center mb-8">
                    <h2 class="text-3xl font-playfair font-bold text-customPalette-dark mb-1">Login</h2>
                    <h1 class="text-sm font-medium uppercase tracking-widest text-customPalette-light">Neeliya Mendis Saloons</h1>
                    <div class="w-12 h-1 bg-customPalette-light mx-auto mt-4 rounded-full"></div>
                </div>

                <form action="{{ route('login') }}" method="POST" class="space-y-6">
                    @csrf
                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">Email Address</label>
                        <div class="relative">
                            <input type="email" id="email" name="email" required
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 text-sm transition-all duration-200 input-focus outline-none"
                                placeholder="name@example.com">
                        </div>
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">Password</label>
                        <div class="relative">
                            <input type="password" id="password" name="password" required
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 text-sm transition-all duration-200 input-focus outline-none"
                                placeholder="••••••••">
                        </div>
                    </div>

                    <!-- Options -->
                    <div class="flex items-center justify-between text-xs">
                        <label class="flex items-center text-gray-600">
                            <input type="checkbox" class="rounded border-gray-300 text-customPalette-light focus:ring-customPalette-light mr-2">
                            Remember me
                        </label>
                        <a href="#" class="text-customPalette-dark hover:text-customPalette-light font-semibold transition-colors">Forgot password?</a>
                    </div>

                    <!-- Login Button -->
                    <button type="submit"
                        class="w-full py-4 bg-customPalette-dark hover:bg-customPalette-darker text-white font-bold rounded-xl shadow-lg transform transition-all duration-200 hover:-translate-y-1 active:scale-95 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-customPalette-dark">
                        SIGN IN
                    </button>
                </form>

                <p class="mt-8 text-center text-xs text-gray-500">
                    &copy; {{ date('Y') }} Neeliya Mendis Saloons. All rights reserved.
                </p>
            </div>
        </div>
    </div>
</body>

</html>

