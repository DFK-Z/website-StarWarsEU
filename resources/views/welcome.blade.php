<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Star Wars EU Holocron — Legends Timeline</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,900&display=swap" rel="stylesheet" />

    <!-- CSS (ПРОСТОЙ СПОСОБ - БЕЗ VITE) -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

<!-- ===== ШАПКА ===== -->
<header>
    <div class="header-container">
        <a href="/" class="logo">EU Holocron</a>

        <nav class="nav-links">
            <a href="/" class="nav-link active">Главная</a>
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

            <a href="#" class="btn-login">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                Войти
            </a>

            <button class="burger-btn" onclick="toggleMenu()">
                <svg style="width:1.5rem;height:1.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>
    </div>

    <!-- Мобильное меню -->
    <div class="mobile-menu" id="mobileMenu">
        <a href="/">Главная</a>
        <a href="#">Хронология</a>
        <a href="#">Персонажи</a>
        <a href="#">Библиотека</a>
        <a href="#">О проекте</a>
        <hr>
        <div style="padding:0 1rem;position:relative;">
            <input type="text" style="width:100%;height:36px;padding:0 1rem 0 2.25rem;font-size:0.875rem;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);border-radius:9999px;color:#EAECEE;outline:none;" placeholder="Поиск...">
            <svg style="position:absolute;left:1.75rem;top:50%;transform:translateY(-50%);width:1rem;height:1rem;color:#49525E;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </div>
        <a href="#" style="margin-top:0.5rem;text-align:center;background:rgba(74,158,255,0.2);color:#EAECEE;">Войти</a>
    </div>
</header>

<!-- ===== ГЕРОЙ ===== -->
<section class="hero">
    <div class="hero-glow"></div>
    <div class="hero-content">
        <div class="hero-badge">
            <span class="hero-badge-dot"></span>
            Legends Timeline — Expanded Universe
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
        <p class="footer-text">© {{ date('Y') }} EU Holocron. Расширенная вселенная.</p>
        <div class="footer-links">
            <a href="#">GitHub</a>
            <a href="#">Обратная связь</a>
        </div>
    </div>
</footer>

<!-- ===== SCRIPT ===== -->
<script>
    function toggleMenu() {
        const menu = document.getElementById('mobileMenu');
        menu.classList.toggle('open');
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
