<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- Sweet Alert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @vite('resources/css/app.css')
</head>

<body>
    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('error') }}',
                confirmButtonText: 'OK',
                confirmButtonColor: '#d33'
            });
        </script>
    @endif

    @if ($errors->has('login'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Login Failed',
                text: '{{ $errors->first('login') }}',
                confirmButtonText: 'OK',
                confirmButtonColor: '#d33'
            });
        </script>
    @endif

    <div class="h-screen w-screen flex flex-col md:flex-row" style="background-image: url('/images/img/login.jpg'); background-size: cover;">
        <div class="w-full md:w-2/5 flex justify-center items-center p-4 my-auto md:p-0">
            <div class="bg-white p-8 border border-gray-200 rounded-md shadow-xl w-full max-w-md mx-auto">
                <div class="bg-white -mt-20 md:-mt-24 border rounded-full w-20 md:w-28 flex mx-auto mb-5">
                    <img src="{{ asset('images/img/saloonlogo.png') }}" alt="" class="w-20 h-20 md:w-28 md:h-28">
                </div>
                <!-- Google Fonts: Playfair Display -->
                <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;700&display=swap" rel="stylesheet">

                <style>
                    .font-playfair {
                        font-family: 'Playfair Display', serif;
                    }
                </style>

                <h2 class="text-3xl md:text-4xl mb-4 text-center font-playfair display font-medium">Login</h2>
                <h1 class="text-lg md:text-xl mb-6 text-center font-playfair display">Salon GloryLuxe</h1>
                <p class="text-md md:text-lg text-center mb-6 font-playfair display">Welcome to the best salon management system.</p>

                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <!-- Email -->
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" id="email" name="email" placeholder="Enter your email"
                            class="mt-1 p-2 w-full border border-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-customPalette-dark">
                    </div>
    
                    <!-- Password with Toggle -->
                    <div class="mb-6 relative">
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input type="password" id="password" name="password" placeholder="Enter your password"
                            class="mt-1 p-2 w-full border border-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-customPalette-dark">
                    </div>
    
                    <!-- Login Button -->
                    <button
                        class="w-full py-2 px-4 bg-customPalette-button text-white rounded-md hover:bg-customPalette-buttonhover focus:outline-none focus:ring-2 focus:ring-customPalette-dark">
                        Login
                    </button>
                </form>
            </div>
        </div>
        <div class="w-full md:w-3/5 hidden md:block"></div>
    </div>
    
</body>

</html>
