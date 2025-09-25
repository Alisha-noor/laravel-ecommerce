@extends('layouts.app')

@section('content')
    <div id="particles-js" class="absolute inset-0 -z-10"></div>

    <main class="min-h-screen flex items-center justify-center px-4">
        <section class="w-full max-w-md bg-white shadow-lg rounded-2xl overflow-hidden relative">

            <!-- Header -->
            <div class="text-center py-6 bg-[#b56576] text-white">
                <h1 class="text-2xl font-bold">Reset Password</h1>
                <p class="text-sm opacity-90">Set a new password for your account</p>
            </div>

            <!-- Content -->
            <div class="p-6">
                <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">

                    <!-- Email -->
                    <div class="form-floating">
                        <input id="email" type="email"
                            class="form-control form-control_gray rounded-xl @error('email') is-invalid @enderror"
                            name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus
                            placeholder="Enter your email">
                        <label for="email">Email Address *</label>
                        @error('email')
                            <span class="invalid-feedback d-block text-danger small mt-1">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="form-floating">
                        <input id="password" type="password"
                            class="form-control form-control_gray rounded-xl @error('password') is-invalid @enderror"
                            name="password" required autocomplete="new-password" placeholder="Enter your new password">
                        <label for="password">New Password *</label>
                        @error('password')
                            <span class="invalid-feedback d-block text-danger small mt-1">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="form-floating">
                        <input id="password-confirm" type="password" class="form-control form-control_gray rounded-xl"
                            name="password_confirmation" required autocomplete="new-password"
                            placeholder="Confirm your new password">
                        <label for="password-confirm">Confirm Password *</label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full py-3 px-4 rounded-xl text-white font-semibold login-btn-animate">
                        Reset Password
                    </button>
                </form>
            </div>
        </section>
    </main>

    <!-- Button hover animation -->
    <style>
        .login-btn-animate {
            background: linear-gradient(45deg, #b56576, #ff6666);
            border: none;
            transition: all 0.3s ease-in-out;
        }

        .login-btn-animate:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 4px 12px rgba(255, 102, 102, 0.5);
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
