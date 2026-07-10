@extends('layouts.app')

@section('title', 'Галактический чат — EU Holocron')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/chat.css') }}">
@endpush

@section('content')
<div class="chat-container">
    <div class="chat-header">
        <h1>🌌 Галактический чат</h1>
        <p>Общайтесь с другими Хранителями Голокрона</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success">✅ {{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">❌ {{ session('error') }}</div>
    @endif

    @if(Auth::user()->isBannedFromChat() && !Auth::user()->isModerator())
        <div class="alert alert-danger">
            🚫 Вы забанены в чате.
            @if($ban = Auth::user()->getActiveBan())
                @if($ban->expires_at)
                    Бан истекает: {{ $ban->expires_at->format('d.m.Y H:i') }}
                @else
                    Бан бессрочный.
                @endif
                @if($ban->reason)
                    <br>Причина: {{ $ban->reason }}
                @endif
            @endif
        </div>
    @else
        <!-- Форма отправки сообщения -->
        <form method="POST" action="{{ route('chat.send') }}" class="chat-form">
            @csrf
            <div class="chat-input-group">
                <input type="text" name="content" placeholder="Напишите сообщение..." required maxlength="500">
                <button type="submit" class="btn-send">📨 Отправить</button>
            </div>
        </form>
    @endif

    <!-- Список сообщений -->
    <div class="chat-messages">
        @foreach($messages as $message)
            <div class="message-item">
                <div class="message-avatar">
                    <img src="{{ $message->user->avatar_url }}" alt="{{ $message->user->name }}">
                </div>
                <div class="message-content">
                    <div class="message-user">
                        {{ $message->user->name }}
                        <span class="role-badge {{ $message->user->role_class }}">
                            {{ $message->user->role_name }}
                        </span>
                        <span class="message-time">{{ $message->created_at->format('H:i') }}</span>
                    </div>
                    <div class="message-text">{{ $message->content }}</div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Боковая панель для админов/модераторов -->
    @if(Auth::user()->isModerator())
        <div class="chat-admin-panel">
            <h3>⚔️ Управление пользователями</h3>
            @foreach($users as $user)
                <div class="user-item">
                    <span>{{ $user->name }}</span>
                    <span class="role-badge {{ $user->role_class }}">{{ $user->role_name }}</span>
                    @if($user->isBannedFromChat())
                        <form method="POST" action="{{ route('chat.unban', $user) }}" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn-unban">🔓 Разбан</button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('chat.ban', $user) }}" style="display:inline;">
                            @csrf
                            <input type="text" name="reason" placeholder="Причина" style="width:100px;">
                            <input type="datetime-local" name="expires_at" style="width:150px;">
                            <button type="submit" class="btn-ban">🔨 Бан</button>
                        </form>
                    @endif
                </div>
            @endforeach
        </div>
    @endif

    @if(!Auth::user()->hasAgreedToChat())
        <script>window.location.href = "{{ route('chat.rules') }}";</script>
    @endif
</div>
@endsection
