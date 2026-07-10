@extends('layouts.app')

@section('title', 'Кодекс Хранителя — EU Holocron')

@push('styles')
    <style>
        .rules-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 2rem 1.5rem;
            min-height: 80vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .rules-card {
            background: rgba(27, 32, 40, 0.8);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(74, 158, 255, 0.15);
            border-radius: 1.5rem;
            padding: 3rem 2.5rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
            position: relative;
            overflow: hidden;
            width: 100%;
        }

        .rules-card::before {
            content: '';
            position: absolute;
            inset: -1px;
            border-radius: 1.5rem;
            padding: 1px;
            background: linear-gradient(135deg, rgba(74, 158, 255, 0.2), rgba(245, 176, 65, 0.1), rgba(224, 74, 95, 0.1));
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            pointer-events: none;
        }

        .rules-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .rules-header .icon {
            font-size: 4rem;
            display: block;
            margin-bottom: 0.5rem;
        }

        .rules-header h1 {
            font-size: 2rem;
            font-weight: 900;
            background: linear-gradient(to right, #F5B041, #E04A5F, #4A9EFF);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .rules-header p {
            color: var(--text-secondary);
            font-size: 1rem;
            margin-top: 0.25rem;
        }

        .rules-list {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            margin: 1.5rem 0;
        }

        .rules-list .rule-item {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            padding: 0.75rem 1rem;
            background: rgba(255, 255, 255, 0.02);
            border-radius: 0.75rem;
            border: 1px solid rgba(255, 255, 255, 0.03);
            transition: all 0.3s ease;
        }

        .rules-list .rule-item:hover {
            background: rgba(255, 255, 255, 0.04);
            border-color: rgba(74, 158, 255, 0.08);
        }

        .rules-list .rule-item .rule-number {
            font-size: 0.7rem;
            font-weight: 700;
            color: #4A9EFF;
            background: rgba(74, 158, 255, 0.1);
            padding: 0.125rem 0.5rem;
            border-radius: 9999px;
            flex-shrink: 0;
            border: 1px solid rgba(74, 158, 255, 0.1);
        }

        .rules-list .rule-item .rule-text {
            color: var(--text-secondary);
            font-size: 0.875rem;
            line-height: 1.6;
        }

        .rules-list .rule-item .rule-text strong {
            color: var(--text-primary);
        }

        .rules-list .rule-item .rule-text .highlight {
            color: #4A9EFF;
        }

        .rules-list .rule-item .rule-text .warning {
            color: #E04A5F;
        }

        .rules-list .rule-item .rule-text .gold {
            color: #F5B041;
        }

        .rules-agreement {
            margin: 2rem 0 1.5rem;
            padding: 1.5rem;
            background: rgba(74, 158, 255, 0.03);
            border: 1px solid rgba(74, 158, 255, 0.08);
            border-radius: 0.75rem;
            text-align: center;
        }

        .rules-agreement label {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            cursor: pointer;
            color: var(--text-secondary);
            font-size: 0.9375rem;
        }

        .rules-agreement label input[type="checkbox"] {
            width: 1.125rem;
            height: 1.125rem;
            accent-color: #4A9EFF;
            cursor: pointer;
            flex-shrink: 0;
        }

        .rules-agreement label .agree-text {
            color: var(--text-primary);
            font-weight: 500;
        }

        .rules-agreement .error-message {
            color: #E04A5F;
            font-size: 0.8125rem;
            margin-top: 0.5rem;
            display: none;
        }

        .rules-agreement .error-message.show {
            display: block;
        }

        .rules-btn {
            display: block;
            width: 100%;
            padding: 0.875rem;
            background: linear-gradient(135deg, #4A9EFF, #3D8BD9);
            color: #0B0D10;
            font-weight: 700;
            font-size: 1rem;
            border: none;
            border-radius: 0.75rem;
            cursor: pointer;
            transition: all 0.3s ease;
            opacity: 0.5;
            pointer-events: none;
        }

        .rules-btn.active {
            opacity: 1;
            pointer-events: auto;
        }

        .rules-btn.active:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(74, 158, 255, 0.3);
        }

        .rules-footer {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        .rules-footer a {
            color: #4A9EFF;
            text-decoration: none;
        }

        .rules-footer a:hover {
            text-decoration: underline;
        }

        @media (max-width: 640px) {
            .rules-card {
                padding: 2rem 1.25rem;
            }

            .rules-header h1 {
                font-size: 1.5rem;
            }

            .rules-list .rule-item {
                padding: 0.5rem 0.75rem;
            }

            .rules-list .rule-item .rule-text {
                font-size: 0.8125rem;
            }

            .rules-agreement label {
                font-size: 0.8125rem;
                flex-wrap: wrap;
            }
        }
    </style>
@endpush

@section('content')
<div class="rules-container">
    <div class="rules-card">
        <div class="rules-header">
            <span class="icon">📜</span>
            <h1>Кодекс Хранителя</h1>
            <p>Прежде чем войти в Галактический чат, прими Кодекс</p>
        </div>

        <div class="rules-list">
            <div class="rule-item">
                <span class="rule-number">1</span>
                <div class="rule-text">
                    <strong>Уважение ко всем Хранителям</strong> — Мы ценим друг друга. Оскорбления, агрессия и токсичность недопустимы.
                </div>
            </div>
            <div class="rule-item">
                <span class="rule-number">2</span>
                <div class="rule-text">
                    <strong>Знания превыше всего</strong> — Обсуждайте расширенную вселенную, делитесь теориями и открытиями.
                </div>
            </div>
            <div class="rule-item">
                <span class="rule-number">3</span>
                <div class="rule-text">
                    <strong class="warning">Без Диснея и Войн Клонов 2008</strong> — Мы храним чистоту Legends. Материалы нового канона здесь не обсуждаются.
                </div>
            </div>
            <div class="rule-item">
                <span class="rule-number">4</span>
                <div class="rule-text">
                    <strong>Конструктивные дискуссии</strong> — Споры приветствуются, но без личных переходов и агрессии.
                </div>
            </div>
            <div class="rule-item">
                <span class="rule-number">5</span>
                <div class="rule-text">
                    <strong class="gold">Хранители заботятся друг о друге</strong> — Помогайте новичкам, отвечайте на вопросы, создавайте уютную атмосферу.
                </div>
            </div>
            <div class="rule-item">
                <span class="rule-number">6</span>
                <div class="rule-text">
                    <strong class="highlight">Сила в знании</strong> — Каждый Хранитель — ценный источник знаний. Берегите Голокрон.
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('chat.agree') }}" id="rulesForm">
            @csrf
            <div class="rules-agreement">
                <label>
                    <input type="checkbox" name="agree" id="agreeCheckbox" value="1">
                    <span>Я прочитал и согласен с <span class="agree-text">Кодексом Хранителя</span></span>
                </label>
                <div class="error-message" id="errorMessage">❌ Вы должны согласиться с Кодексом, чтобы продолжить.</div>
            </div>

            <button type="submit" class="rules-btn" id="submitBtn">
                ⚔️ Стать Хранителем
            </button>
        </form>

        <div class="rules-footer">
            ⚡ Нарушение Кодекса может привести к ограничению прав в чате.
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkbox = document.getElementById('agreeCheckbox');
        const submitBtn = document.getElementById('submitBtn');
        const errorMessage = document.getElementById('errorMessage');

        checkbox.addEventListener('change', function() {
            if (this.checked) {
                submitBtn.classList.add('active');
                errorMessage.classList.remove('show');
            } else {
                submitBtn.classList.remove('active');
                errorMessage.classList.add('show');
            }
        });

        document.getElementById('rulesForm').addEventListener('submit', function(e) {
            if (!checkbox.checked) {
                e.preventDefault();
                errorMessage.classList.add('show');
                checkbox.focus();
            }
        });
    });
</script>
@endsection
