<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Star Wars EU Holocron — Legends Timeline</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen font-sans antialiased bg-space-dark text-white selection:bg-jedi-blue/30">

    <!-- Шапка с Glass-эффектом -->
    <header class="sticky top-0 z-50 w-full border-b border-white/5 bg-space-dark/75 backdrop-blur-2xl backdrop-saturate-150">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between lg:h-20">

                <!-- Логотип с градиентом -->
                <div class="flex-shrink-0">
                    <a href="{{ route('home') }}" class="text-2xl font-bold tracking-tight bg-gradient-to-r from-republic-gold via-sith-red to-jedi-blue bg-clip-text text-transparent hover:scale-105 transition-transform duration-300">
                        EU Holocron
                    </a>
                </div>

                <!-- Десктопная навигация -->
                <nav class="hidden md:flex items-center space-x-1" x-data>
                    <x-nav-link href="{{ route('home') }}" :active="request()->routeIs('home')">Главная</x-nav-link>
                    <x-nav-link href="#" active="timeline">Хронология</x-nav-link>
                    <x-nav-link href="#" active="characters.*">Персонажи</x-nav-link>
                    <x-nav-link href="#">Библиотека</x-nav-link>
                    <x-nav-link href="#">О проекте</x-nav-link>
                </nav>

                <!-- Блок поиска и действий -->
                <div class="flex items-center gap-3">
                    <!-- Поле поиска (десктоп) -->
                    <div class="hidden lg:block relative">
                        <input type="text"
                               placeholder="Поиск по голокрону..."
                               class="w-48 xl:w-64 h-9 pl-9 pr-4 text-sm bg-white/5 border border-white/10 rounded-full focus:border-jedi-blue/50 focus:ring-2 focus:ring-jedi-blue/20 focus:outline-none transition-all placeholder:text-gray-500 text-white">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>

                    <!-- Кнопка "Войти" -->
                    <button class="hidden sm:inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white transition-all bg-jedi-blue/20 hover:bg-jedi-blue/30 rounded-full border border-jedi-blue/20 hover:border-jedi-blue/40 focus:ring-2 focus:ring-jedi-blue/20">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Войти
                    </button>

                    <!-- Мобильное меню (бургер) -->
                    <button @click="mobileMenu = !mobileMenu"
                            class="md:hidden p-2 rounded-lg hover:bg-white/5 transition-colors relative z-20"
                            x-data="{ mobileMenu: false }"
                            x-bind:aria-expanded="mobileMenu">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Мобильное выпадающее меню -->
        <div x-data="{ mobileMenu: false }"
             x-show="mobileMenu"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-4"
             @click.away="mobileMenu = false"
             class="md:hidden absolute top-full left-0 right-0 bg-space-dark/95 backdrop-blur-2xl border-b border-white/5 shadow-2xl">
            <div class="flex flex-col p-4 space-y-2">
                <a href="{{ route('home') }}" class="px-4 py-3 text-sm font-medium rounded-lg hover:bg-white/5 transition-colors text-white">Главная</a>
                <a href="#" class="px-4 py-3 text-sm font-medium rounded-lg hover:bg-white/5 transition-colors text-gray-400">Хронология</a>
                <a href="#" class="px-4 py-3 text-sm font-medium rounded-lg hover:bg-white/5 transition-colors text-gray-400">Персонажи</a>
                <a href="#" class="px-4 py-3 text-sm font-medium rounded-lg hover:bg-white/5 transition-colors text-gray-400">Библиотека</a>
                <a href="#" class="px-4 py-3 text-sm font-medium rounded-lg hover:bg-white/5 transition-colors text-gray-400">О проекте</a>
                <hr class="border-white/10 my-1">
                <div class="relative px-4">
                    <input type="text" placeholder="Поиск..." class="w-full h-9 pl-9 pr-4 text-sm bg-white/5 border border-white/10 rounded-full focus:border-jedi-blue/50 focus:ring-2 focus:ring-jedi-blue/20 focus:outline-none transition-all placeholder:text-gray-500 text-white">
                    <svg class="absolute left-7 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <button class="mt-2 px-4 py-3 text-sm font-medium text-center rounded-lg bg-jedi-blue/20 hover:bg-jedi-blue/30 text-white transition-colors">
                    Войти
                </button>
            </div>
        </div>
    </header>

    <!-- Основной контент -->
    <main>
        <!-- Героический блок -->
        <div class="relative overflow-hidden bg-gradient-to-b from-space-dark via-space-dark to-space-card/80">
            <!-- Звездное поле -->
            <div class="starfield"></div>

            <!-- Градиентные лучи (световой меч) -->
            <div class="absolute inset-0 opacity-20" style="background: radial-gradient(circle at 30% 50%, #4A9EFF 0%, transparent 60%), radial-gradient(circle at 70% 80%, #E04A5F 0%, transparent 50%);"></div>

            <!-- Контент героя -->
            <div class="relative mx-auto max-w-7xl px-4 py-24 sm:px-6 lg:px-8 text-center fade-in">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 mb-6 text-xs font-medium tracking-widest text-jedi-blue uppercase border border-jedi-blue/30 rounded-full bg-jedi-blue/5">
                    <span class="w-1.5 h-1.5 bg-jedi-blue rounded-full animate-pulse"></span>
                    Legends Timeline — Expanded Universe
                </div>

                <h1 class="text-4xl font-black tracking-tight sm:text-6xl lg:text-7xl">
                    <span class="bg-gradient-to-r from-republic-gold via-white to-jedi-blue bg-clip-text text-transparent">
                        Хранители<br class="sm:hidden"> Голокрона
                    </span>
                </h1>

                <p class="mx-auto mt-6 max-w-2xl text-lg leading-relaxed text-gray-400 sm:text-xl">
                    Исследуйте хронику расширенной вселенной «Звёздных войн».
                    От Трауна до Юужань-Вонгов — без Диснея и Войн Клонов 2008.
                </p>

                <div class="mt-10 flex flex-wrap items-center justify-center gap-4">
                    <a href="#" class="inline-flex items-center px-8 py-3 text-sm font-semibold text-space-dark transition-all bg-jedi-blue rounded-full hover:bg-jedi-blue/80 hover:shadow-[0_0_30px_rgba(74,158,255,0.3)] hover:-translate-y-0.5">
                        Начать путешествие
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                    <a href="#" class="inline-flex items-center px-8 py-3 text-sm font-semibold text-white transition-all border border-white/10 rounded-full hover:bg-white/5 hover:border-white/20">
                        О проекте
                    </a>
                </div>
            </div>
        </div>

        <!-- Место для контента -->
        <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Карточка-заглушка 1 -->
                <div class="glass rounded-xl p-6 hover:border-jedi-blue/20 transition-all duration-300 hover:neon-blue">
                    <div class="text-4xl mb-3">📜</div>
                    <h3 class="text-lg font-semibold text-white">Хронология</h3>
                    <p class="text-sm text-gray-400 mt-2">От Старой Республики до Новой</p>
                </div>

                <!-- Карточка-заглушка 2 -->
                <div class="glass rounded-xl p-6 hover:border-jedi-blue/20 transition-all duration-300 hover:neon-blue">
                    <div class="text-4xl mb-3">👤</div>
                    <h3 class="text-lg font-semibold text-white">Персонажи</h3>
                    <p class="text-sm text-gray-400 mt-2">Траун, Люк, Мара и многие другие</p>
                </div>

                <!-- Карточка-заглушка 3 -->
                <div class="glass rounded-xl p-6 hover:border-jedi-blue/20 transition-all duration-300 hover:neon-blue">
                    <div class="text-4xl mb-3">🌍</div>
                    <h3 class="text-lg font-semibold text-white">Планеты</h3>
                    <p class="text-sm text-gray-400 mt-2">Корусант, Татуин, Бастион</p>
                </div>
            </div>
        </div>
    </main>

    <!-- Футер -->
    <footer class="border-t border-white/5 bg-space-dark/50 backdrop-blur-2xl">
        <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
            <div class="flex flex-col items-center justify-between gap-4 sm:flex-row">
                <p class="text-sm text-gray-500">
                    © {{ date('Y') }} EU Holocron. Расширенная вселенная.
                </p>
                <div class="flex gap-6 text-sm">
                    <a href="#" class="text-gray-500 hover:text-white transition-colors">GitHub</a>
                    <a href="#" class="text-gray-500 hover:text-white transition-colors">Обратная связь</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
