<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Star Wars EU Holocron — Legends Timeline</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        /* ===== ДОПОЛНИТЕЛЬНЫЕ УЛУЧШЕНИЯ ===== */

        /* Анимация для карточек */
        .card {
            transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            cursor: default;
        }

        .card:hover {
            transform: translateY(-8px) scale(1.02);
            border-color: rgba(74, 158, 255, 0.3);
            box-shadow: 0 12px 40px rgba(74, 158, 255, 0.12);
        }

        .card:hover .card-icon {
            animation: float 2s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-6px); }
        }

        /* Анимация для кнопок */
        .btn-primary, .btn-secondary {
            position: relative;
            overflow: hidden;
        }

        .btn-primary::after, .btn-secondary::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.1), transparent);
            opacity: 0;
            transition: opacity 0.3s;
        }

        .btn-primary:hover::after, .btn-secondary:hover::after {
            opacity: 1;
        }

        /* Статус-бар для авторизованных */
        .user-status {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.25rem 0.75rem 0.25rem 0.25rem;
            background: rgba(74, 158, 255, 0.08);
            border: 1px solid rgba(74, 158, 255, 0.12);
            border-radius: 9999px;
            transition: all 0.3s;
        }

        .user-status:hover {
            background: rgba(74, 158, 255, 0.12);
            border-color: rgba(74, 158, 255, 0.2);
        }

        .user-avatar {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: linear-gradient(135deg, #4A9EFF, #6DB8FF);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #0B0D10;
            font-weight: 700;
            font-size: 0.75rem;
            text-transform: uppercase;
            flex-shrink: 0;
        }

        .user-name {
            color: #EAECEE;
            font-size: 0.875rem;
            font-weight: 500;
            white-space: nowrap;
            max-width: 100px;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .logout-btn {
            color: #8892A0;
            font-size: 0.75rem;
            background: none;
            border: none;
            cursor: pointer;
            padding: 0.25rem 0.5rem;
            border-radius: 0.375rem;
            transition: all 0.3s;
            font-weight: 500;
        }

        .logout-btn:hover {
            color: #E04A5F;
            background: rgba(224, 74, 95, 0.08);
        }

        /* Улучшенный поиск */
        .search-input {
            transition: all 0.3s;
        }

        .search-input:focus {
            width: 280px;
        }

        @media (max-width: 1280px) {
            .search-input:focus {
                width: 220px;
            }
        }

        /* Индикатор загрузки для кнопок */
        .btn-loading {
            position: relative;
            pointer-events: none;
            opacity: 0.7;
        }

        .btn-loading::before {
            content: '...';
            position: absolute;
            right: 1rem;
            animation: dots 1.2s steps(4, end) infinite;
        }

        @keyframes dots {
            0% { content: ''; }
            25% { content: '.'; }
            50% { content: '..'; }
            75% { content: '...'; }
            100% { content: ''; }
        }

        /* Подсветка активного пункта меню */
        .nav-link {
            position: relative;
        }

        .nav-link::before {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 50%;
            transform: translateX(-50%) scaleX(0);
            width: 24px;
            height: 2px;
            background: #4A9EFF;
            border-radius: 2px;
            box-shadow: 0 0 12px rgba(74, 158, 255, 0.6);
            transition: transform 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        .nav-link:hover::before {
            transform: translateX(-50%) scaleX(1);
        }

        .nav-link.active::before {
            transform: translateX(-50%) scaleX(1);
        }

        /* Плавное появление героя */
        .hero-content {
            animation: fadeInUp 0.8s ease forwards;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Адаптивность для маленьких экранов */
        @media (max-width: 640px) {
            .user-name {
                max-width: 60px;
            }
            .user-status {
                padding: 0.25rem 0.5rem 0.25rem 0.25rem;
            }
        }
    </style>
</head>
<body>

<!-- ===== ШАПКА ===== -->
<header>
    <div class="header-container">
        <!-- Логотип с анимацией -->
        <a href="/" class="logo" style="display:flex;align-items:center;gap:0.5rem;">
            <span style="font-size:1.75rem;">⚡</span>
            EU Holocron
        </a>

        <!-- Навигация -->
        <nav class="nav-links">
            <a href="/" class="nav-link active">Главная</a>
            <a href="#" class="nav-link">Хронология</a>
            <a href="#" class="nav-link">Персонажи</a>
            <a href="#" class="nav-link">Библиотека</a>
            <a href="#" class="nav-link">О проекте</a>
        </nav>

        <!-- Поиск и пользователь -->
        <div style="display:flex;align-items:center;gap:0.75rem;">
            <!-- Поиск -->
            <div class="search-container">
                <input type="text" class="search-input" placeholder="Поиск по голокрону..." id="searchInput">
                <svg class="search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>

            <!-- Блок пользователя (улучшенный) -->
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
                <a href="{{ route('login') }}" class="btn-login">
                    <svg style="width:1rem;height:1rem;margin-right:0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Войти
                </a>
            @endauth

            <!-- Бургер -->
            <button class="burger-btn" onclick="toggleMenu()" aria-label="Меню">
                <svg style="width:1.5rem;height:1.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>
    </div>

    <!-- Мобильное меню -->
    <div class="mobile-menu" id="mobileMenu">
        <a href="/" class="active">Главная</a>
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
            <a href="{{ route('login') }}" style="margin-top:0.5rem;text-align:center;background:rgba(74,158,255,0.15);color:#EAECEE;display:block;padding:0.75rem;border-radius:0.5rem;transition:all 0.3s;"
               onmouseover="this.style.background='rgba(74,158,255,0.25)'"
               onmouseout="this.style.background='rgba(74,158,255,0.15)'">
                🔑 Войти
            </a>
        @endauth
    </div>
</header>

<!-- ===== ГЕРОЙ ===== -->
<section class="hero">
    <div class="hero-glow"></div>
    <div class="hero-content">
        <div class="hero-badge">
            <span class="hero-badge-dot"></span>
            @auth
                Добро пожаловать, Хранитель {{ Auth::user()->name }}! 👋
            @else
                Legends Timeline — Expanded Universe
            @endauth
        </div>

        <h1 class="hero-title">
            <span>Хранители Голокрона</span>
        </h1>

        <p class="hero-subtitle">
            Исследуйте хронику расширенной вселенной «Звёздных войн».<br>
            От Трауна до Юужань-Вонгов — без Диснея и Войн Клонов 2008.
        </p>

        <div class="hero-buttons">
            <a href="#" class="btn-primary">
                Начать путешествие
                <svg style="width:1rem;height:1rem;margin-left:0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>
            </a>
            <a href="#" class="btn-secondary">О проекте</a>
        </div>
    </div>
</section>

<!-- ===== КАРТОЧКИ ===== -->
<section class="cards">
    <div class="cards-grid">
        <div class="card">
            <span class="card-icon">📜</span>
            <div class="card-title">Хронология</div>
            <div class="card-text">От Старой Республики до Новой</div>
        </div>
        <div class="card">
            <span class="card-icon">👤</span>
            <div class="card-title">Персонажи</div>
            <div class="card-text">Траун, Люк, Мара и многие другие</div>
        </div>
        <div class="card">
            <span class="card-icon">🌍</span>
            <div class="card-title">Планеты</div>
            <div class="card-text">Корусант, Татуин, Бастион</div>
        </div>
    </div>
</section>

<!-- ===== ФУТЕР ===== -->
<footer>
    <div class="footer-container">
        <p class="footer-text">
            © {{ date('Y') }} EU Holocron.
            <span style="color:#49525E;">⚡</span>
            Расширенная вселенная.
        </p>
        <div class="footer-links">
            <a href="#" style="display:flex;align-items:center;gap:0.25rem;">
                <span>🐙</span> GitHub
            </a>
            <a href="#" style="display:flex;align-items:center;gap:0.25rem;">
                <span>✉️</span> Обратная связь
            </a>
        </div>
    </div>
</footer>

<!-- ===== SCRIPT ===== -->
<script>
    // Мобильное меню
    function toggleMenu() {
        const menu = document.getElementById('mobileMenu');
        menu.classList.toggle('open');
    }

    // Закрытие меню при клике вне
    document.addEventListener('click', function(event) {
        const menu = document.getElementById('mobileMenu');
        const btn = document.querySelector('.burger-btn');
        if (menu.classList.contains('open') &&
            !menu.contains(event.target) &&
            !btn.contains(event.target)) {
            menu.classList.remove('open');
        }
    });

    // Анимация поиска
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.02)';
            });
            searchInput.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
            });
        }
    });

    // Отображение приветствия с эффектом печати (для новых пользователей)
    document.addEventListener('DOMContentLoaded', function() {
        @if(session('success'))
            console.log('🌟 Добро пожаловать в EU Holocron!');
        @endif
    });
</script>

</body>
</html>
