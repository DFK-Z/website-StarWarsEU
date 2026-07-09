@extends('layouts.app')

@section('title', 'О проекте — EU Holocron')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/about.css') }}">
@endpush

@section('content')
<div class="about-container">
    <div class="about-header">
        <h1>📖 О проекте EU Holocron</h1>
        <p>Хранители знаний о расширенной вселенной «Звёздных войн»</p>
    </div>

    <div class="about-grid">
        <div class="about-main">
            <div class="about-card">
                <h2><span class="icon">🌟</span> Что такое EU Holocron?</h2>
                <p>
                    <strong>EU Holocron</strong> — это фанатский проект, посвящённый <span class="highlight">Расширенной вселенной «Звёздных войн»</span> (Star Wars Expanded Universe, он же <span class="highlight-gold">Legends</span>).
                    Мы собираем, систематизируем и сохраняем знания о той самой вселенной, которая существовала <span class="highlight">до Войн Клонов 2008 года и до приобретения Lucasfilm компанией Disney</span>.
                </p>
                <p style="margin-top:0.75rem;">
                    Наш проект — это <span class="highlight">голокрон</span> (древнее устройство джедаев для хранения знаний), в котором каждый Хранитель может найти информацию о персонажах, планетах, событиях и технологиях далёкой-далёкой галактики.
                </p>
            </div>

            <div class="about-card">
                <h2><span class="icon">📚</span> Что хранится на сайте?</h2>
                <ul>
                    <li><span class="bullet">✦</span> <span><strong>Персонажи</strong> — от Люка Скайуокера до Трауна и Марa Джейд</span></li>
                    <li><span class="bullet">✦</span> <span><strong>Хронология</strong> — от основания Старой Республики до битвы при Явине</span></li>
                    <li><span class="bullet">✦</span> <span><strong>Планеты и локации</strong> — Корусант, Татуин, Бастион и другие миры</span></li>
                    <li><span class="bullet">✦</span> <span><strong>Технологии и артефакты</strong> — световые мечи, звёздные разрушители, голокроны</span></li>
                    <li><span class="bullet">✦</span> <span><strong>События и битвы</strong> — от Войн ситхов до вторжения юужань-вонгов</span></li>
                    <li><span class="bullet">✦</span> <span><strong>Фракции и организации</strong> — Джедаи, Ситхи, Новая Республика, Империя</span></li>
                </ul>
            </div>

            <div class="about-card">
                <h2><span class="icon">⚖️</span> Наши принципы</h2>
                <ul>
                    <li><span class="bullet">✦</span> <span><span class="highlight">Канон Legends</span> — мы строго придерживаемся хронологии и фактов старой расширенной вселенной</span></li>
                    <li><span class="bullet">✦</span> <span><span class="highlight-gold">Без Диснея</span> — мы не включаем информацию из новой канонической вселенной (фильмы 2015+, сериалы Диснея+)</span></li>
                    <li><span class="bullet">✦</span> <span><span class="highlight-red">Без Войн Клонов 2008</span> — мы используем только материалы, созданные до выхода мультсериала, который изменил хронологию</span></li>
                    <li><span class="bullet">✦</span> <span><strong>Достоверность</strong> — вся информация проверяется по первоисточникам: книгам, комиксам, играм и энциклопедиям</span></li>
                </ul>
            </div>
        </div>

        <div class="about-sidebar">
            <div class="rules-card">
                <h2>📜 Правила</h2>
                <ol class="rules-list">
                    <li><span class="rule-highlight">Уважение к вселенной</span> — мы чтим наследие расширенной вселенной и не допускаем оскорблений или насмешек над материалами.</li>
                    <li><span class="rule-highlight">Достоверность информации</span> — все данные должны подтверждаться первоисточниками (книги, комиксы, энциклопедии).</li>
                    <li><span class="rule-warning">Запрещено использовать материалы Disney</span> — на сайте публикуется только информация из классической EU (Legends).</li>
                    <li><span class="rule-warning">Запрещено использовать Войны Клонов 2008</span> — мультсериал и связанные с ним материалы не считаются каноничными для нашего проекта.</li>
                    <li><span class="rule-gold">Уважение к другим Хранителям</span> — мы ценим мнение каждого пользователя и не допускаем оскорблений.</li>
                    <li><span class="rule-highlight">Конструктивные обсуждения</span> — мы поощряем дискуссии о вселенной, но без агрессии и токсичности.</li>
                    <li><span class="rule-highlight">Обновление контента</span> — мы постоянно дополняем базу знаний новыми материалами из проверенных источников.</li>
                </ol>
            </div>

            <div style="background:rgba(27,32,40,0.3);border-radius:1.25rem;padding:1.5rem;border:1px solid rgba(255,255,255,0.05);">
                <h3 style="font-size:1rem;font-weight:600;color:var(--text-primary);margin-bottom:0.75rem;">🏷️ Теги проекта</h3>
                <div class="badge-list">
                    <span class="badge-item">#StarWarsEU</span>
                    <span class="badge-item gold">#Legends</span>
                    <span class="badge-item red">#NotDisney</span>
                    <span class="badge-item">#ThrawnTrilogy</span>
                    <span class="badge-item gold">#NewJediOrder</span>
                    <span class="badge-item">#ХранителиГолокрона</span>
                    <span class="badge-item red">#NoCloneWars2008</span>
                    <span class="badge-item">#OriginalEU</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
