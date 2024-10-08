<x-guest-layout>
    <style>
        body {
            font-family: 'Press Start 2P', cursive;
            background-image: url('/images/pixel13.gif');
            background-size: 100%;
            color: #ffd700;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            background-color: rgba(100, 99, 90, 0.8);
            border: 3px solid #333;
            border-radius: 20px;
            box-shadow: 10px 10px 0 rgba(0, 0, 0, 0.2);
            padding: 25px;
            max-width: 400px;
            width: 100%;
        }

        h2 {
            font-size: 24px;
            text-align: center;
            margin-bottom: 20px;
            color: #fff
        }

        .form-input {
            font-family: 'Press Start 2P', cursive;
            font-size: 12px;
            padding: 8px;
            border: 2px solid #333;
            border-radius: 4px;
            background-color: #fff;
            color: #333;
            width: 100%;
            margin-bottom: 15px;
        }

        .btn-custom {
            background-color: #7c4700;
            border: 2px solid #3b2a1c;
            border-radius: 8px;
            color: #f5f5f5;
            font-family: 'Press Start 2P', cursive;
            font-size: 12px;
            padding: 10px 20px;
            cursor: pointer;
            transition: all 0.3s ease;
            justify-content: center;
            
        }

        .btn-custom:hover {
            background-color: #3b2a1c;
            border-color: #7c4700;
        }

        .remember-me {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .remember-me input {
            margin-right: 10px;
        }

        .forgot-password {
            text-align: right;
            margin-bottom: 15px;
        }

        .forgot-password a {
            color: #ffd700;
            text-decoration: none;
        }

        .forgot-password a:hover {
            text-decoration: underline;
        }
    </style>

    <div class="container">
        <h2>Login</h2>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input-label class="text-white" for="email" :value="__('Email')" />
                <x-text-input id="email" class="form-input" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label class="text-white" for="password" :value="__('Password')" />
                <x-text-input id="password" class="form-input" type="password" name="password" required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="remember-me">
                <input id="remember_me" type="checkbox" name="remember">
                <label class="text-white" for="remember_me">{{ __('Remember me') }}</label>
            </div>

            <div class="forgot-password" style="text-align: center;">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
            </div>

            <div style="display: flex; justify-content: center;">
                <button type="submit" class="btn-custom">
                    {{ __('Log in') }}
                </button>
            </div>
        </form>
    </div>
</x-guest-layout>
