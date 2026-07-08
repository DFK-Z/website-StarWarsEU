<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Редактирование профиля — EU Holocron</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
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
            overflow: hidden;
        }

        .profile-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
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
            margin-bottom: 1.5rem;
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

        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--text-secondary);
            margin-bottom: 0.375rem;
        }

        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 0.75rem;
            color: var(--text-primary);
            font-size: 0.9375rem;
            transition: all 0.3s ease;
            outline: none;
        }

        .form-input:focus {
            border-color: rgba(74, 158, 255, 0.4);
            box-shadow: 0 0 0 3px rgba(74, 158, 255, 0.1);
            background: rgba(255, 255, 255, 0.06);
        }

        .form-input-file {
            display: block;
            width: 100%;
            padding: 0.75rem 1rem;
            background: rgba(255, 255, 255, 0.04);
            border: 2px dashed rgba(255, 255, 255, 0.1);
            border-radius: 0.75rem;
            color: var(--text-secondary);
            font-size: 0.9375rem;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .form-input-file:hover {
            border-color: rgba(74, 158, 255, 0.3);
            background: rgba(74, 158, 255, 0.05);
        }

        .form-input-file::-webkit-file-upload-button {
            padding: 0.5rem 1rem;
            background: rgba(74, 158, 255, 0.15);
            border: none;
            border-radius: 0.5rem;
            color: #4A9EFF;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .form-input-file::-webkit-file-upload-button:hover {
            background: rgba(74, 158, 255, 0.25);
        }

        .form-error {
            color: #E04A5F;
            font-size: 0.8125rem;
            margin-top: 0.375rem;
        }

        .btn-save {
            padding: 0.75rem 2rem;
            background: linear-gradient(135deg, #4A9EFF, #3D8BD9);
            color: #0B0D10;
            font-weight: 600;
            border: none;
            border-radius: 0.75rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(74, 158, 255, 0.3);
        }

        .btn-cancel {
            padding: 0.75rem 2rem;
            background: transparent;
            color: var(--text-secondary);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 0.75rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            margin-right: 0.5rem;
        }

        .btn-cancel:hover {
            background: rgba(255, 255, 255, 0.05);
            border-color: rgba(255, 255, 255, 0.2);
        }

        .form-actions {
            display: flex;
            gap: 0.75rem;
            margin-top: 1.5rem;
        }

        .alert-success {
            padding: 1rem;
            border-radius: 0.75rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            background: rgba(74, 158, 255, 0.08);
            border: 1px solid rgba(74, 158, 255, 0.15);
            color: #4A9EFF;
        }

        /* Предпросмотр аватарки */
        .avatar-preview {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
            padding: 1rem;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 0.75rem;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .avatar-preview img {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid rgba(74, 158, 255, 0.2);
        }

        .avatar-preview .info {
            font-size: 0.875rem;
            color: var(--text-secondary);
        }

        .avatar-preview .info strong {
            color: var(--text-primary);
        }
    </style>
</head>
<body>

<!-- ===== ШАПКА ===== -->
<header>
    <div class="header-container">
        <a href="/" class="logo"><span style="font-size:1.75rem;">⚡</span> EU Holocron</a>
        <nav class="nav-links">
            <a href="/" class="nav-link">Главная</a>
            <a href="#" class="nav-link">Хронология</a>
            <a href="#" class="nav-link">Персонажи</a>
            <a href="#" class="nav-link">Библиотека</a>
            <a href="#" class="nav-link">О проекте</a>
        </nav>
        <div style="display:flex;align-items:center;gap:0.75rem;">
            <div class="search-container"><input type="text" class="search-input" placeholder="Поиск по голокрону..."><svg class="search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg></div>
            @auth
                <div class="user-status">
                    <a href="{{ route('profile') }}" style="display:flex;align-items:center;gap:0.5rem;text-decoration:none;">
                        <div class="user-avatar" style="background-image:url('{{ Auth::user()->avatar_url }}');background-size:cover;background-position:center;width:32px;height:32px;border-radius:50%;">
                            {{-- Если аватарка не загружена, показываем букву --}}
                            @if(!Auth::user()->getFirstMedia('avatar'))
                                {{ substr(Auth::user()->name, 0, 1) }}
                            @endif
                        </div>
                        <span class="user-name" title="{{ Auth::user()->name }}">{{ Auth::user()->name }}</span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}" style="display:inline;">@csrf<button type="submit" class="logout-btn" title="Выйти из аккаунта">✕</button></form>
                </div>
            @else
                <a href="{{ route('login') }}" class="btn-login">Войти</a>
            @endauth
            <button class="burger-btn" onclick="toggleMenu()" aria-label="Меню"><svg style="width:1.5rem;height:1.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg></button>
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
                <a href="{{ route('profile') }}" style="display:flex;align-items:center;gap:0.75rem;text-decoration:none;color:inherit;width:100%;">
                    <div class="user-avatar" style="width:32px;height:32px;border-radius:50%;background-image:url('{{ Auth::user()->avatar_url }}');background-size:cover;background-position:center;display:flex;align-items:center;justify-content:center;font-size:0.875rem;font-weight:700;color:#0B0D10;text-transform:uppercase;">
                        @if(!Auth::user()->getFirstMedia('avatar'))
                            {{ substr(Auth::user()->name, 0, 1) }}
                        @endif
                    </div>
                    <span style="color:#EAECEE;font-size:0.875rem;font-weight:500;">{{ Auth::user()->name }}</span>
                </a>
            </div>
            <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" style="width:100%;text-align:left;padding:0.75rem 1rem;color:#E04A5F;background:none;border:none;cursor:pointer;font-size:0.875rem;border-radius:0.5rem;transition:all 0.3s;" onmouseover="this.style.background='rgba(224,74,95,0.08)'" onmouseout="this.style.background='transparent'">🚪 Выйти</button></form>
        @else
            <a href="{{ route('login') }}" style="margin-top:0.5rem;text-align:center;background:rgba(74,158,255,0.15);color:#EAECEE;display:block;padding:0.75rem;border-radius:0.5rem;transition:all 0.3s;">🔑 Войти</a>
        @endauth
    </div>
</header>

<!-- ===== ЛИЧНЫЙ КАБИНЕТ ===== -->
<div class="profile-container">
    <aside class="profile-sidebar">
        <div class="profile-avatar">
            @if($user->getFirstMedia('avatar'))
                <img src="{{ $user->avatar_url }}" alt="Аватар">
            @else
                {{ substr($user->name, 0, 1) }}
            @endif
        </div>
        <div class="profile-name">{{ $user->name }}</div>
        <div class="profile-email">{{ $user->email }}</div>
        <nav class="profile-sidebar-nav">
            <a href="{{ route('profile') }}">👤 Мой профиль</a>
            <a href="{{ route('profile.edit') }}" class="active">✏️ Редактировать</a>
            <a href="{{ route('profile.password') }}">🔑 Сменить пароль</a>
            <a href="/">🏠 На главную</a>
        </nav>
    </aside>

    <main class="profile-content">
        <h2>✏️ Редактирование профиля</h2>

        @if(session('success'))
            <div class="alert-success">✅ {{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Текущая аватарка -->
            <div class="avatar-preview">
                @if($user->getFirstMedia('avatar'))
                    <img src="{{ $user->avatar_url }}" alt="Аватар">
                @else
                    <div class="profile-avatar" style="width:64px;height:64px;font-size:1.5rem;margin:0;">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                @endif
                <div class="info">
                    <strong>Текущая аватарка</strong><br>
                    <span style="font-size:0.75rem;color:var(--text-muted);">
                        @if($user->getFirstMedia('avatar'))
                            Загружена {{ $user->getFirstMedia('avatar')->created_at->diffForHumans() }}
                        @else
                            Используется стандартная аватарка
                        @endif
                    </span>
                </div>
            </div>

            <!-- Загрузка новой аватарки -->
            <div class="form-group">
                <label for="avatar" class="form-label">Новая аватарка</label>
                <input id="avatar" type="file" name="avatar" class="form-input-file" accept="image/*">
                @error('avatar')
                    <p class="form-error">{{ $message }}</p>
                @enderror
                <div style="font-size:0.75rem;color:var(--text-muted);margin-top:0.375rem;">
                    📸 Поддерживаются: JPG, PNG, GIF, WEBP. Максимальный размер: 2MB
                </div>
            </div>

            <!-- Имя -->
            <div class="form-group">
                <label for="name" class="form-label">Имя</label>
                <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" class="form-input" required>
                @error('name') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <!-- Email -->
            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" class="form-input" required>
                @error('email') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-save">💾 Сохранить</button>
                <a href="{{ route('profile') }}" class="btn-cancel">Отмена</a>
            </div>
        </form>
    </main>
</div>

<!-- ===== ФУТЕР ===== -->
<footer>
    <div class="footer-container">
        <p class="footer-text">© {{ date('Y') }} EU Holocron. <span style="color:#49525E;">⚡</span> Расширенная вселенная.</p>
        <div class="footer-links"><a href="#"><span>🐙</span> GitHub</a><a href="#"><span>✉️</span> Обратная связь</a></div>
    </div>
</footer>

<script>
    function toggleMenu() { document.getElementById('mobileMenu').classList.toggle('open'); }
    document.addEventListener('click', function(event) {
        const menu = document.getElementById('mobileMenu');
        const btn = document.querySelector('.burger-btn');
        if (menu.classList.contains('open') && !menu.contains(event.target) && !btn.contains(event.target)) {
            menu.classList.remove('open');
        }
    });

    // Предпросмотр аватарки перед загрузкой
    document.addEventListener('DOMContentLoaded', function() {
        const avatarInput = document.getElementById('avatar');
        if (avatarInput) {
            avatarInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        const preview = document.querySelector('.avatar-preview img');
                        if (preview) {
                            preview.src = event.target.result;
                        } else {
                            const container = document.querySelector('.avatar-preview');
                            const img = document.createElement('img');
                            img.src = event.target.result;
                            img.style.width = '64px';
                            img.style.height = '64px';
                            img.style.borderRadius = '50%';
                            img.style.objectFit = 'cover';
                            img.style.border = '2px solid rgba(74,158,255,0.2)';
                            container.prepend(img);
                        }
                    };
                    reader.readAsDataURL(file);
                }
            });
        }
    });
</script>

</body>
</html>
