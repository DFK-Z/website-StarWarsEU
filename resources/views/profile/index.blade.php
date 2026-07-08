<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Личный кабинет — EU Holocron</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        /* ===== СТИЛИ ДЛЯ ПРОФИЛЯ ===== */
        .profile-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 2rem 1rem;
            display: grid;
            grid-template-columns: 280px 1fr;
            gap: 2rem;
        }

        @media (max-width: 768px) {
            .profile-container {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }
        }

        .profile-sidebar {
            background: rgba(27, 32, 40, 0.6);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 1rem;
            padding: 1.5rem;
            text-align: center;
            position: sticky;
            top: 100px;
            height: fit-content;
        }

        @media (max-width: 768px) {
            .profile-sidebar {
                position: static;
            }
        }

        .profile-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: linear-gradient(135deg, #4A9EFF, #6DB8FF);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            font-weight: 700;
            color: #0B0D10;
            margin: 0 auto 1rem;
            text-transform: uppercase;
            box-shadow: 0 0 40px rgba(74, 158, 255, 0.2);
            border: 3px solid rgba(74, 158, 255, 0.2);
            transition: all 0.3s ease;
        }

        .profile-avatar:hover {
            transform: scale(1.05);
            box-shadow: 0 0 60px rgba(74, 158, 255, 0.3);
        }

        .profile-name {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 0.25rem;
        }

        .profile-email {
            font-size: 0.875rem;
            color: var(--text-secondary);
            margin-bottom: 1rem;
        }

        .profile-member-since {
            font-size: 0.75rem;
            color: var(--text-muted);
            margin-bottom: 1.5rem;
            padding: 0.5rem;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 0.5rem;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .profile-sidebar-nav {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .profile-sidebar-nav a {
            padding: 0.625rem 1rem;
            color: var(--text-secondary);
            text-decoration: none;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
            font-size: 0.875rem;
            text-align: left;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .profile-sidebar-nav a:hover {
            background: rgba(74, 158, 255, 0.08);
            color: var(--text-primary);
        }

        .profile-sidebar-nav a.active {
            background: rgba(74, 158, 255, 0.12);
            color: #4A9EFF;
            border: 1px solid rgba(74, 158, 255, 0.15);
        }

        .profile-content {
            background: rgba(27, 32, 40, 0.4);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 1rem;
            padding: 2rem;
        }

        .profile-content h2 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: var(--text-primary);
        }

        .profile-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .profile-stat {
            background: rgba(255, 255, 255, 0.03);
            padding: 1rem;
            border-radius: 0.75rem;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: all 0.3s ease;
        }

        .profile-stat:hover {
            background: rgba(255, 255, 255, 0.06);
            transform: translateY(-2px);
        }

        .profile-stat-number {
            font-size: 1.75rem;
            font-weight: 700;
            color: #4A9EFF;
            display: block;
        }

        .profile-stat-label {
            font-size: 0.75rem;
            color: var(--text-secondary);
            margin-top: 0.25rem;
        }

        .alert {
            padding: 1rem;
            border-radius: 0.75rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .alert-success {
            background: rgba(74, 158, 255, 0.08);
            border: 1px solid rgba(74, 158, 255, 0.15);
            color: #4A9EFF;
        }

        .alert-danger {
            background: rgba(224, 74, 95, 0.08);
            border: 1px solid rgba(224, 74, 95, 0.15);
            color: #E04A5F;
        }
    </style>
</head>
<body>

<!-- ===== ШАПКА (копия из welcome.blade.php) ===== -->
<header>
    <div class="header-container">
        <a href="/" class="logo">
            <span style="font-size:1.75rem;">⚡</span>
            EU Holocron
        </a>

        <nav class="nav-links">
            <a href="/" class="nav-link">Главная</a>
            <a href="#" class="nav-link">Хронология</a>
            <a href="#" class="nav-link">Персонажи</a>
            <a href="#" class="nav-link">Библиотека</a>
            <a href="#" class="nav-link">О проекте</a>
        </nav>

        <div style="display:flex;align-items:center;gap:0.75rem;">
            <div class="search-container">
                <input type="text" class="search-input" placeholder="Поиск по голокрону...">
                <svg class="search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>

            @auth
                <div class="user-status">
                    <div class="user-avatar">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <span class="user-name" title="{{ Auth::user()->name }}">
                        {{ Auth::user()->name }}
                    </span>
                    <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                        @csrf
                        <button type="submit" class="logout-btn" title="Выйти из аккаунта">
                            ✕
                        </button>
                    </form>
                </div>
            @else
                <a href="{{ route('login') }}" class="btn-login">Войти</a>
            @endauth

            <button class="burger-btn" onclick="toggleMenu()" aria-label="Меню">
                <svg style="width:1.5rem;height:1.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>
    </div>

    <div class="mobile-menu" id="mobileMenu">
        <a href="/">Главная</a>
        <a href="#">Хронология</a>
        <a href="#">Персонажи</a>
        <a href="#">Библиотека</a>
        <a href="#">О проекте</a>
        <hr>
        @auth
            <div style="padding:0.75rem 1rem;display:flex;align-items:center;gap:0.75rem;">
                <div class="user-avatar" style="width:32px;height:32px;font-size:0.875rem;">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <span style="color:#EAECEE;font-size:0.875rem;font-weight:500;">
                    {{ Auth::user()->name }}
                </span>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" style="width:100%;text-align:left;padding:0.75rem 1rem;color:#E04A5F;background:none;border:none;cursor:pointer;font-size:0.875rem;border-radius:0.5rem;transition:all 0.3s;"
                        onmouseover="this.style.background='rgba(224,74,95,0.08)'"
                        onmouseout="this.style.background='transparent'">
                    🚪 Выйти
                </button>
            </form>
        @else
            <a href="{{ route('login') }}" style="margin-top:0.5rem;text-align:center;background:rgba(74,158,255,0.15);color:#EAECEE;display:block;padding:0.75rem;border-radius:0.5rem;transition:all 0.3s;">🔑 Войти</a>
        @endauth
    </div>
</header>

<!-- ===== ЛИЧНЫЙ КАБИНЕТ ===== -->
<div class="profile-container">
    <!-- Боковая панель -->
    <aside class="profile-sidebar">
        <div class="profile-avatar">
            {{ substr($user->name, 0, 1) }}
        </div>
        <div class="profile-name">{{ $user->name }}</div>
        <div class="profile-email">{{ $user->email }}</div>
        <div class="profile-member-since">
            🗓️ Хранитель с {{ $user->created_at->format('d.m.Y') }}
        </div>

        <nav class="profile-sidebar-nav">
            <a href="{{ route('profile') }}" class="active">
                <span>👤</span> Мой профиль
            </a>
            <a href="{{ route('profile.edit') }}">
                <span>✏️</span> Редактировать
            </a>
            <a href="{{ route('profile.password') }}">
                <span>🔑</span> Сменить пароль
            </a>
            <a href="/">
                <span>🏠</span> На главную
            </a>
        </nav>
    </aside>

    <!-- Основной контент -->
    <main class="profile-content">
        <h2>👋 Добро пожаловать в личный кабинет!</h2>

        @if(session('success'))
            <div class="alert alert-success">
                ✅ {{ session('success') }}
            </div>
        @endif

        <!-- Статистика -->
        <div class="profile-stats">
            <div class="profile-stat">
                <span class="profile-stat-number">0</span>
                <span class="profile-stat-label">Сохранённых статей</span>
            </div>
            <div class="profile-stat">
                <span class="profile-stat-number">0</span>
                <span class="profile-stat-label">Комментариев</span>
            </div>
            <div class="profile-stat">
                <span class="profile-stat-number">0</span>
                <span class="profile-stat-label">Избранных</span>
            </div>
            <div class="profile-stat">
                <span class="profile-stat-number">0</span>
                <span class="profile-stat-label">Достижений</span>
            </div>
        </div>

        <!-- Информация о пользователе -->
        <div style="background:rgba(255,255,255,0.02);border-radius:0.75rem;padding:1.5rem;border:1px solid rgba(255,255,255,0.05);">
            <h3 style="font-size:1rem;font-weight:600;margin-bottom:1rem;color:var(--text-primary);">📋 Информация об аккаунте</h3>
            <div style="display:grid;gap:0.75rem;">
                <div style="display:flex;justify-content:space-between;padding:0.5rem 0;border-bottom:1px solid rgba(255,255,255,0.03);">
                    <span style="color:var(--text-secondary);">Имя</span>
                    <span style="color:var(--text-primary);font-weight:500;">{{ $user->name }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;padding:0.5rem 0;border-bottom:1px solid rgba(255,255,255,0.03);">
                    <span style="color:var(--text-secondary);">Email</span>
                    <span style="color:var(--text-primary);font-weight:500;">{{ $user->email }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;padding:0.5rem 0;border-bottom:1px solid rgba(255,255,255,0.03);">
                    <span style="color:var(--text-secondary);">Дата регистрации</span>
                    <span style="color:var(--text-primary);font-weight:500;">{{ $user->created_at->format('d.m.Y H:i') }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;padding:0.5rem 0;">
                    <span style="color:var(--text-secondary);">Статус</span>
                    <span style="color:#4A9EFF;font-weight:500;">✅ Активен</span>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- ===== ФУТЕР ===== -->
<footer>
    <div class="footer-container">
        <p class="footer-text">© {{ date('Y') }} EU Holocron. <span style="color:#49525E;">⚡</span> Расширенная вселенная.</p>
        <div class="footer-links">
            <a href="#"><span>🐙</span> GitHub</a>
            <a href="#"><span>✉️</span> Обратная связь</a>
        </div>
    </div>
</footer>

<script>
    function toggleMenu() {
        document.getElementById('mobileMenu').classList.toggle('open');
    }

    document.addEventListener('click', function(event) {
        const menu = document.getElementById('mobileMenu');
        const btn = document.querySelector('.burger-btn');
        if (menu.classList.contains('open') &&
            !menu.contains(event.target) &&
            !btn.contains(event.target)) {
            menu.classList.remove('open');
        }
    });
</script>

</body>
</html>
