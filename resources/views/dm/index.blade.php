@extends('layouts.app')

@section('title', 'Личные сообщения — EU Holocron')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/dm.css') }}">
@endpush

@section('content')
<div class="dm-container">
    <div class="dm-header">
        <h1>💬 Личные сообщения</h1>
        <p>Общайтесь с другими Хранителями Голокрона</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success">✅ {{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">❌ {{ session('error') }}</div>
    @endif

    <div class="dm-conversations">
        @forelse($conversations as $conversation)
            <a href="{{ route('dm.show', $conversation['user']) }}" class="dm-conversation-item">
                <div class="dm-conversation-avatar">
                    <img src="{{ $conversation['user']->avatar_url }}" alt="{{ $conversation['user']->name }}">
                    @if($conversation['unread_count'] > 0)
                        <span class="dm-unread-badge">{{ $conversation['unread_count'] }}</span>
                    @endif
                </div>
                <div class="dm-conversation-info">
                    <div class="dm-conversation-name">
                        {{ $conversation['user']->name }}
                        <span class="role-badge {{ $conversation['user']->role_class }}">
                            {{ $conversation['user']->role_name }}
                        </span>
                    </div>
                    <div class="dm-conversation-last">
                        @if($conversation['last_message'])
                            @if($conversation['last_message']->sender_id == Auth::id())
                                <span style="color:var(--text-muted);">Вы: </span>
                            @endif
                            {{ Str::limit($conversation['last_message']->content, 50) }}
                            <span class="dm-conversation-time">
                                {{ $conversation['last_message']->created_at->diffForHumans() }}
                            </span>
                        @else
                            <span style="color:var(--text-muted);">Нет сообщений</span>
                        @endif
                    </div>
                </div>
            </a>
        @empty
            <div class="empty-state">
                <span class="empty-icon">📭</span>
                <p>У вас пока нет диалогов</p>
                <p style="font-size:0.875rem;color:var(--text-muted);">Найдите пользователей и начните общение!</p>
            </div>
        @endforelse
    </div>

    <!-- Кнопка "Начать новый диалог" -->
    <div style="margin-top:2rem;text-align:center;">
        <a href="{{ route('characters.index') }}" class="btn-primary" style="display:inline-flex;align-items:center;gap:0.5rem;">
            👥 Найти пользователей
        </a>
    </div>
</div>
@endsection
