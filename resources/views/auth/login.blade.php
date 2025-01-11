<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <style>
        .gradient-background {
            background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }

        @keyframes gradient {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.125);
        }

        .input-effect {
            transition: all 0.3s ease;
        }

        .input-effect:focus {
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .btn-hover {
            transition: all 0.3s ease;
        }

        .btn-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body class="gradient-background min-h-screen flex items-center justify-center p-6">
    <div class="animate__animated animate__fadeIn animate__faster max-w-md w-full">
        <div class="glass-effect rounded-xl shadow-2xl p-8 md:p-10">
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-white mb-2 animate__animated animate__fadeInDown">Welcome Back!</h1>
                <p class="text-gray-200 animate__animated animate__fadeIn animate__delay-1s">Please sign in to continue</p>
            </div>

            @if (session('success'))
                <div class="animate__animated animate__fadeIn mb-6 text-emerald-300 text-sm bg-emerald-500/10 p-3 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <form class="space-y-6" action="{{ route('login') }}" method="POST">
                @csrf
                <div class="animate__animated animate__fadeInUp animate__delay-1s">
                    <div class="relative">
                        <input id="email" name="email" type="email" required 
                            class="input-effect w-full px-4 py-3 rounded-lg bg-white/10 border border-white/20 text-white placeholder-gray-300 focus:outline-none focus:border-white/40"
                            placeholder="Email address">
                    </div>
                </div>

                <div class="animate__animated animate__fadeInUp animate__delay-2s">
                    <div class="relative">
                        <input id="password" name="password" type="password" required 
                            class="input-effect w-full px-4 py-3 rounded-lg bg-white/10 border border-white/20 text-white placeholder-gray-300 focus:outline-none focus:border-white/40"
                            placeholder="Password">
                    </div>
                </div>

                @if ($errors->any())
                    <div class="animate__animated animate__fadeIn text-red-300 text-sm bg-red-500/10 p-3 rounded-lg">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <div class="animate__animated animate__fadeInUp animate__delay-3s">
                    <button type="submit" 
                        class="btn-hover w-full bg-white text-gray-900 font-semibold py-3 px-4 rounded-lg hover:bg-opacity-90">
                        Sign In
                    </button>
                </div>

                <div class="text-center mt-6 animate__animated animate__fadeIn animate__delay-3s">
                    <a href="{{ route('register') }}" 
                        class="text-white hover:text-gray-200 text-sm transition-colors duration-300">
                        Don't have an account? <span class="font-semibold">Register here</span>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Animated background circles -->
    <div class="fixed top-0 left-0 w-full h-full overflow-hidden -z-10">
        <div class="absolute w-96 h-96 bg-purple-500 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob"></div>
        <div class="absolute w-96 h-96 bg-yellow-500 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-2000"></div>
        <div class="absolute w-96 h-96 bg-pink-500 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-4000"></div>
    </div>

    <style>
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        .animate-blob {
            animation: blob 7s infinite;
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        .animation-delay-4000 {
            animation-delay: 4s;
        }
    </style>
</body>
</html> 