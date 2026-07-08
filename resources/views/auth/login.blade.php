<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Вход — EU Holocron</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,900&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>

<div class="auth-container">
    <div class="auth-star"></div>
    <div class="auth-star"></div>
    <div class="auth-star"></div>
    <div class="auth-star"></div>
    <div class="auth-star"></div>
    <div class="auth-star"></div>
    <div class="auth-star"></div>
    <div class="auth-star"></div>

    <div class="auth-card">
        <div class="auth-logo">
            <a href="/">EU Holocron</a>
            <p>Войдите в Голокрон</p>
        </div>

        <h1 class="auth-title">Добро пожаловать</h1>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div class="auth-group">
                <label for="email" class="auth-label">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}"
                       class="auth-input" placeholder="ваш@email.ком" required autofocus>
                @error('email')
                    <p class="auth-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Пароль с глазом -->
            <div class="auth-group">
                <label for="password" class="auth-label">Пароль</label>
                <div class="password-wrapper">
                    <input id="password" type="password" name="password"
                           class="auth-input" placeholder="••••••••" required>
                    <button type="button" class="toggle-password"
                            onclick="togglePasswordVisibility(this, 'password')"
                            aria-label="Показать пароль">
                        <svg viewBox="0 0 24 24">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                    </button>
                </div>
                @error('password')
                    <p class="auth-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Запомнить меня -->
            <div class="auth-checkbox">
                <input id="remember" type="checkbox" name="remember">
                <label for="remember">Запомнить меня</label>
            </div>

            <button type="submit" class="auth-btn">Войти</button>

            <div class="auth-divider">
                <span>или</span>
            </div>

            <div class="auth-social">
                <button type="button">🌐 Google</button>
                <button type="button">🐙 GitHub</button>
            </div>

            <div class="auth-footer">
                Нет аккаунта? <a href="{{ route('register') }}">Зарегистрироваться</a>
            </div>
        </form>
    </div>
</div>

<script>
    function togglePasswordVisibility(button, inputId) {
        const input = document.getElementById(inputId);
        if (!input) return;

        const isPassword = input.type === 'password';
        input.type = isPassword ? 'text' : 'password';

        const svg = button.querySelector('svg');
        if (isPassword) {
            svg.innerHTML = `
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                <circle cx="12" cy="12" r="3"/>
                <line x1="1" y1="1" x2="23" y2="23"/>
            `;
            button.classList.add('active');
            button.setAttribute('aria-label', 'Скрыть пароль');
        } else {
            svg.innerHTML = `
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                <circle cx="12" cy="12" r="3"/>
            `;
            button.classList.remove('active');
            button.setAttribute('aria-label', 'Показать пароль');
        }
    }
</script>

</body>
</html>
