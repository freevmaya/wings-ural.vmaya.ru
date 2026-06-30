<?php
/* @var $this yii\web\View */
use yii\helpers\Url;

$this->title = 'Параплан Челябинск | Полеты и обучение';

// Используем специальный layout для полноэкранного режима
$this->context->layout = 'main-fullscreen';
?>

<!-- СЕКЦИЯ 1: ВИДЕО И ГЛАВНЫЙ ЭКРАН -->
<section class="page-section video-section" id="section1">
    <video autoplay muted loop playsinline>
        <source src="/video/section-2.mp4" type="video/mp4">
    </video>
    <div class="overlay"></div>

    <div class="hero-text">
        <h1>Небо ближе, чем ты думаешь</h1>
        <p>Полеты на параплане в Челябинске и выездные школы. Ощути свободу полета!</p>
        <a href="<?= Url::to(['article/what-is-paragrider']) ?>">Что такое параплан?</a>
    </div>

    <div class="scroll-down" id="arrowDown">
        <i class="fas fa-chevron-down"></i>
    </div>
</section>

<!-- СЕКЦИЯ 2: Выезды и планы -->
<section class="page-section video-section" id="section2">
    <video autoplay muted loop playsinline>
        <source src="/video/background-video-2.mp4" type="video/mp4">
    </video>
    <div class="overlay"></div>

    <div class="hero-text">
        <h2>Выезды и планы</h2>
        <p>Еженедельные выезды в лучшие летные места Южного Урала: Аушкуль, Алтынташ, Аскарово, Банное, Воронино, Большеустьикинское и т.д.</p>
        <p>Для новичков - старт с небольшой высоты под присмотром инструктора. Для опытных - маршруты на 50+ км.
Планируем совместные выезды в Чегем, Крым, Дагестан и Гималаи. Следи за <a href="https://vk.me/join/LljJrc91zZTC5P8HeL1OnKLDTcONvQ95Ufg=" target="_blank">анонсами!</a></p>
</p>
    </div>

    <div class="scroll-down" id="arrowDown2">
        <i class="fas fa-chevron-down"></i>
    </div>
</section>

<!-- СЕКЦИЯ 3: Обучение -->
<section class="page-section video-section" id="section3">
    <video autoplay muted loop playsinline>
        <source src="/video/section-3.mp4" type="video/mp4">
    </video>
    <div class="overlay"></div>

    <div class="hero-text">
        <h2>Первоначальное обучение полетам на параплане в Челябинске</h2>
        <p>Теория и наземная подготовка. Выездные сборы активных полетов с инструктором. Итог: навыки самостоятельного пилота.</p>
        <p>От курсантов требуется желание научится летать (аки птицы), легкая но прочная одежда брюки/куртка/обувь по типу трекинговых, при наличии, шлем. При необходимости, парапланерное снаряжение выдается в аренду.<br>
        Мы делаем акцент на безопасность!</p>

        <p>Для участия свяжитесь с инструктором:</p>
        <p style="display: flex; gap: 20px; justify-content: center; align-items: center; font-size: 2rem; margin-top: 10px;">
            <a href="https://vk.com/fwadim" target="_blank">
                <i class="fab fa-vk"></i>
            </a>
            <a href="https://t.me/FreeVmaya" target="_blank">
                <i class="fab fa-telegram"></i>
            </a>
            <a href="tel:+79227540997">
                <i class="fas fa-phone"></i>
            </a>
        </p>
    </div>
    
    <div class="scroll-down" id="arrowDown3">
        <i class="fas fa-chevron-down"></i>
    </div>
</section>

<!-- СЕКЦИЯ 4: Тандемный полет -->
<section class="page-section video-section" id="section4">
    <video autoplay muted loop playsinline>
        <source src="/video/section-4.mp4" type="video/mp4">
    </video>
    <div class="overlay"></div>

    <div class="hero-text">
        <h2>✨ Тандем – полет в подарок</h2>
        <p>Полет с сертифицированным инструктором. Без подготовки, максимальная безопасность. Длительность – 15-25 минут, высота до 800 метров.</p>
        <p>Заказать сейчас 
        <p style="display: flex; gap: 20px; justify-content: center; align-items: center; font-size: 2rem; margin-top: 10px;">
            <a href="https://vk.com/fwadim" target="_blank">
                <i class="fab fa-vk"></i>
            </a>
            <a href="https://t.me/FreeVmaya" target="_blank">
                <i class="fab fa-telegram"></i>
            </a>
            <a href="tel:+79227540997">
                <i class="fas fa-phone"></i>
            </a>
        </p>
    </div>
    
    <div class="scroll-down" id="arrowDown4">
        <i class="fas fa-chevron-down"></i>
    </div>
</section>

<!-- СЕКЦИЯ 5: О нас -->
<section class="page-section content-block" id="section5">
    <h2>🏆 О нас</h2>
    <p>Команда инструкторов с опытом полетов более 10 лет. Члены Федерации парапланерного спорта. Множество успешных тандемов и выпущенных пилотов.</p>
    <p>Приходи знакомиться - проведём экскурсию и бесплатную лекцию о безопасности.</p>
</section>