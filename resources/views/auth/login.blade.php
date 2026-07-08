<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Вход — EU Holocron</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        /* ===== СТИЛИ ДЛЯ СТРАНИЦЫ ВХОДА ===== */
        .auth-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            background: radial-gradient(ellipse at 20% 50%, rgba(74, 158, 255, 0.08) 0%, transparent 60%),
                        radial-gradient(ellipse at 80% 50%, rgba(224, 74, 95, 0.08) 0%, transparent 60%),
                        #0B0D10;
            position: relative;
            overflow: hidden;
        }

        .auth-container::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                radial-gradient(1px 1px at 10% 20%, rgba(255,255,255,0.3), transparent),
                radial-gradient(1px 1px at 30% 60%, rgba(255,255,255,0.2), transparent),
                radial-gradient(1.5px 1.5px at 50% 10%, rgba(255,255,255,0.4), transparent),
                radial-gradient(1px 1px at 70% 40%, rgba(255,255,255,0.2), transparent),
                radial-gradient(1px 1px at 90% 80%, rgba(255,255,255,0.3), transparent);
            background-size: 200px 200px;
            opacity: 0.3;
            pointer-events: none;
        }

        .auth-card {
            position: relative;
            width: 100%;
            max-width: 440px;
            padding: 2.5rem 2rem;
            background: rgba(27, 32, 40, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 1.5rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.6);
            z-index: 1;
            animation: fadeSlideUp 0.6s ease forwards;
        }

        .auth-card::before {
            content: '';
            position: absolute;
            inset: -1px;
            border-radius: 1.5rem;
            padding: 1px;
            background: linear-gradient(135deg, rgba(74, 158, 255, 0.2), rgba(224, 74, 95, 0.1), rgba(245, 176, 65, 0.1));
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            pointer-events: none;
        }

        .auth-logo {
            text-align: center;
            margin-bottom: 2rem;
        }

        .auth-logo a {
            font-size: 2rem;
            font-weight: 900;
            letter-spacing: -0.025em;
            background: linear-gradient(to right, #F5B041, #E04A5F, #4A9EFF);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-decoration: none;
        }

        .auth-logo p {
            margin-top: 0.5rem;
            font-size: 0.875rem;
            color: #8892A0;
            -webkit-text-fill-color: #8892A0;
        }

        .auth-title {
            font-size: 1.5rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 1.5rem;
            color: #EAECEE;
        }

        .auth-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: #8892A0;
            margin-bottom: 0.375rem;
        }

        .auth-input {
            width: 100%;
            padding: 0.75rem 1rem;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 0.75rem;
            color: #EAECEE;
            font-size: 0.9375rem;
            transition: all 0.3s ease;
            outline: none;
        }

        .auth-input:focus {
            border-color: rgba(74, 158, 255, 0.4);
            box-shadow: 0 0 0 3px rgba(74, 158, 255, 0.1);
            background: rgba(255, 255, 255, 0.06);
        }

        .auth-input::placeholder {
            color: #49525E;
        }

        .auth-error {
            color: #E04A5F;
            font-size: 0.8125rem;
            margin-top: 0.375rem;
        }

        .auth-checkbox {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin: 1rem 0 1.5rem;
        }

        .auth-checkbox input[type="checkbox"] {
            width: 1rem;
            height: 1rem;
            accent-color: #4A9EFF;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 0.25rem;
            cursor: pointer;
        }

        .auth-checkbox label {
            font-size: 0.875rem;
            color: #8892A0;
            cursor: pointer;
            -webkit-text-fill-color: #8892A0;
        }

        .auth-btn {
            width: 100%;
            padding: 0.75rem;
            background: #4A9EFF;
            color: #0B0D10;
            font-weight: 600;
            font-size: 0.9375rem;
            border: none;
            border-radius: 0.75rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .auth-btn:hover {
            background: #6DB8FF;
            box-shadow: 0 0 30px rgba(74, 158, 255, 0.25);
            transform: translateY(-2px);
        }

        .auth-footer {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.875rem;
            color: #8892A0;
        }

        .auth-footer a {
            color: #4A9EFF;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .auth-footer a:hover {
            color: #6DB8FF;
            text-decoration: underline;
        }

        .auth-divider {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin: 1.5rem 0;
        }

        .auth-divider::before,
        .auth-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: rgba(255, 255, 255, 0.06);
        }

        .auth-divider span {
            font-size: 0.75rem;
            color: #49525E;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .auth-social {
            display: flex;
            gap: 0.75rem;
        }

        .auth-social button {
            flex: 1;
            padding: 0.625rem;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 0.75rem;
            color: #8892A0;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.875rem;
        }

        .auth-social button:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(255, 255, 255, 0.12);
            color: #EAECEE;
        }

        @keyframes fadeSlideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .auth-stars {
            position: absolute;
            width: 4px;
            height: 4px;
            background: #4A9EFF;
            border-radius: 50%;
            box-shadow: 0 0 12px rgba(74, 158, 255, 0.3);
            opacity: 0.6;
            animation: twinkle 3s ease-in-out infinite alternate;
        }

        .auth-stars:nth-child(1) { top: 10%; left: 8%; animation-delay: 0s; }
        .auth-stars:nth-child(2) { top: 15%; right: 12%; animation-delay: 1s; }
        .auth-stars:nth-child(3) { bottom: 20%; left: 5%; animation-delay: 0.5s; }
        .auth-stars:nth-child(4) { bottom: 25%; right: 8%; animation-delay: 1.5s; }
        .auth-stars:nth-child(5) { top: 45%; left: 3%; animation-delay: 0.8s; }

        @keyframes twinkle {
            0% { opacity: 0.3; transform: scale(0.8); }
            100% { opacity: 0.9; transform: scale(1.2); }
        }

        @media (max-width: 480px) {
            .auth-card {
                padding: 1.5rem 1rem;
            }
            .auth-title {
                font-size: 1.25rem;
            }
        }
    </style>
</head>
<body>

<div class="auth-container">
    <!-- Звёзды-декор -->
    <div class="auth-stars"></div>
    <div class="auth-stars"></div>
    <div class="auth-stars"></div>
    <div class="auth-stars"></div>
    <div class="auth-stars"></div>

    <div class="auth-card">
        <!-- Логотип -->
        <div class="auth-logo">
            <a href="/">EU Holocron</a>
            <p>Войдите в Голокрон</p>
        </div>

        <!-- Заголовок -->
        <h1 class="auth-title">Добро пожаловать</h1>

        <!-- ===== ФОРМА ВХОДА ===== -->
        <form method="POST" action="{{ route('login') }}">
            @csrf  <!-- <-- ЭТО САМОЕ ВАЖНОЕ! БЕЗ ЭТОГО БУДЕТ 419 -->

            <!-- Email -->
            <div style="margin-bottom: 1rem;">
                <label for="email" class="auth-label">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                       class="auth-input" placeholder="ваш@email.ком">
                @error('email')
                    <p class="auth-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Пароль -->
            <div style="margin-bottom: 0.5rem;">
                <label for="password" class="auth-label">Пароль</label>
                <input id="password" type="password" name="password" required
                       class="auth-input" placeholder="••••••••">
                @error('password')
                    <p class="auth-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Запомнить меня -->
            <div class="auth-checkbox">
                <input id="remember" type="checkbox" name="remember">
                <label for="remember">Запомнить меня</label>
            </div>

            <!-- Кнопка -->
            <button type="submit" class="auth-btn">Войти</button>

            <!-- Делитель -->
            <div class="auth-divider">
                <span>или</span>
            </div>

            <!-- Социальные кнопки (заглушки) -->
            <div class="auth-social">
                <button type="button">Google</button>
                <button type="button">GitHub</button>
            </div>

            <!-- Ссылка на регистрацию -->
            <div class="auth-footer">
                Нет аккаунта? <a href="{{ route('register') }}">Зарегистрироваться</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>
