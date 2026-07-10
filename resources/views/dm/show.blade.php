@extends('layouts.app')

@section('title', 'Чат с ' . $otherUser->name . ' — EU Holocron')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/dm.css') }}">
@endpush

@section('content')
<div class="dm-container">
    <div class="dm-header">
        <a href="{{ route('dm.index') }}" class="back-link">← Назад к диалогам</a>
        <div class="dm-user-info">
            <img src="{{ $otherUser->avatar_url }}" alt="{{ $otherUser->name }}" class="dm-user-avatar">
            <div>
                <h1>{{ $otherUser->name }}</h1>
                <span class="role-badge {{ $otherUser->role_class }}">{{ $otherUser->role_name }}</span>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">✅ {{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">❌ {{ session('error') }}</div>
    @endif

    <!-- Сообщения -->
    <div class="dm-messages" id="dmMessages">
        @forelse($messages as $message)
            <div class="dm-message {{ $message->sender_id == Auth::id() ? 'sent' : 'received' }}">
                <div class="dm-message-content">
                    <div class="dm-message-text">{{ $message->content }}</div>
                    <div class="dm-message-time">
                        {{ $message->created_at->format('H:i') }}
                        @if($message->sender_id == Auth::id() && $message->is_read)
                            <span style="color:var(--text-muted);">✓✓</span>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="empty-state" style="grid-column:1/-1;padding:3rem;">
                <span class="empty-icon">💬</span>
                <p>Начните общение с {{ $otherUser->name }}</p>
            </div>
        @endforelse
    </div>

    <!-- Форма отправки -->
    <form method="POST" action="{{ route('dm.send') }}" class="dm-form" id="dmForm">
        @csrf
        <input type="hidden" name="receiver_id" value="{{ $otherUser->id }}">
        <div class="dm-input-group">
            <input type="text" name="content" placeholder="Напишите сообщение..." required maxlength="1000" autocomplete="off">
            <button type="submit" class="btn-send">📨 Отправить</button>
        </div>
    </form>
</div>

<script>
    // Авто-скролл вниз
    document.addEventListener('DOMContentLoaded', function() {
        const messages = document.getElementById('dmMessages');
        if (messages) {
            messages.scrollTop = messages.scrollHeight;
        }

        // Обновление количества непрочитанных
        setInterval(function() {
            fetch('{{ route("dm.unread") }}')
                .then(response => response.json())
                .then(data => {
                    const badge = document.querySelector('.dm-unread-badge-global');
                    if (badge) {
                        if (data.count > 0) {
                            badge.textContent = data.count;
                            badge.style.display = 'inline-block';
                        } else {
                            badge.style.display = 'none';
                        }
                    }
                });
        }, 30000); // каждые 30 секунд
    });
</script>
@endsection
