@extends('layouts.app')

@section('content')
    <div id="particles-js" class="absolute inset-0 -z-10"></div>

    <main class="min-h-screen flex items-center justify-center px-4 pt-10">
        <section class="w-full max-w-md bg-white shadow-lg rounded-2xl overflow-hidden relative">
            <!-- Header -->
            <div class="text-center py-6 bg-[#b56576] text-white">
                <h1 class="text-2xl font-bold" style="color: white">Create Account</h1>
                <p class="text-sm opacity-90">Join us and start shopping today</p>
            </div>

            <!-- Content -->
            <div class="p-6">
                {{-- Show Laravel validation errors --}}
                @if ($errors->any())
                    <div class="alert alert-warning small mb-4">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf

                    <!-- Name -->
                    <div class="form-floating">
                        <input id="name" type="text" class="form-control form-control_gray rounded-xl"
                            name="name" value="{{ old('name') }}" required autocomplete="name" autofocus
                            placeholder="Enter your name">
                        <label for="name">Full Name *</label>
                    </div>

                    <!-- Email -->
                    <div class="form-floating">
                        <input id="email" type="email" class="form-control form-control_gray rounded-xl"
                            name="email" value="{{ old('email') }}" required autocomplete="email"
                            placeholder="Enter your email">
                        <label for="email">Email address *</label>
                    </div>

                    <!-- Password -->
                    <div class="form-floating">
                        <input id="password" type="password" class="form-control form-control_gray rounded-xl"
                            name="password" required autocomplete="new-password" placeholder="Enter your password">
                        <label for="password">Password *</label>
                    </div>

                    <!-- Confirm Password -->
                    <div class="form-floating">
                        <input id="password_confirmation" type="password" class="form-control form-control_gray rounded-xl"
                            name="password_confirmation" required autocomplete="new-password"
                            placeholder="Confirm your password">
                        <label for="password_confirmation">Confirm Password *</label>
                    </div>

                    <!-- Register Button -->
                    <button class="w-full py-3 px-4 rounded-xl text-white font-semibold text-uppercase login-btn-animate"
                        type="submit">
                        Create Account
                    </button>
                </form>

                <!-- Links -->
                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        Already registered?
                        <a href="{{ route('login') }}" class="text-[#b56576] font-semibold hover:underline">
                            Login
                        </a>
                    </p>
                </div>
            </div>
        </section>
    </main>

    <!-- Button hover animation -->
    <style>
        .login-btn-animate {
            background: linear-gradient(45deg, #b56576, #f48cc0);
            border: none;
            transition: all 0.3s ease-in-out;
        }

        .login-btn-animate:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 4px 12px rgba(244, 116, 206, 0.5);
        }
    </style>

    <!-- Particles JS -->
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <script>
        particlesJS.load('particles-js', '/particles.json', function() {
            console.log('Particles.js loaded');
        });
    </script>
@endsection
