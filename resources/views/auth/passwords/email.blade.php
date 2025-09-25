@extends('layouts.app')

@section('content')
    <div id="particles-js" class="absolute inset-0 -z-10"></div>

    <main class="min-h-screen flex items-start justify-center px-4 pt-10">
        <section class="w-full max-w-md bg-white shadow-lg rounded-2xl overflow-hidden relative">

            <!-- Header -->
            <div class="text-center py-6 bg-[#b56576] text-white">
                <h1 class="text-2xl font-bold" style="color: white">Forgot Password</h1>
                <p class="text-sm opacity-90">Enter your email to get reset link</p>
            </div>

            <!-- Content -->
            <div class="p-6">
                @if (session('status'))
                    <div class="alert alert-success text-sm text-center rounded-lg py-2 mb-4">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
                    @csrf

                    <!-- Email -->
                    <div class="form-floating">
                        <input id="email" type="email"
                            class="form-control form-control_gray rounded-xl @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                            placeholder="Enter your email">
                        <label for="email">Email Address *</label>
                        @error('email')
                            <span class="invalid-feedback d-block text-danger small mt-1">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Button -->
                    <button type="submit" class="w-full py-3 px-4 rounded-xl text-white font-semibold login-btn-animate">
                        Send Reset Link
                    </button>
                </form>

                <!-- Back to login -->
                <div class="text-center mt-4">
                    <a href="{{ route('login') }}" class="btn-text">Back to Login</a>
                </div>
            </div>
        </section>
    </main>

    <!-- Particles JS -->
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <script>
        particlesJS.load('particles-js', '/particles.json', function() {
            console.log('Particles.js loaded');
        });
    </script>

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
@endsection
