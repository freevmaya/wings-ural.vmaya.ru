<?php

declare(strict_types=1);

/** @var yii\web\View $this */

use yii\bootstrap5\Nav;
use yii\helpers\Html;
use yii\helpers\Url;

// Определяем, находимся ли мы на главной странице
$isHomePage = Yii::$app->controller->id === 'site' && Yii::$app->controller->action->id === 'index';

// Функция для формирования URL ссылок меню
function getMenuUrl($anchor, $isHomePage) {
    if ($isHomePage) {
        // На главной странице — просто якорь
        return '#' . $anchor;
    } else {
        // На других страницах — ссылка на главную с якорем
        return Url::to(['site/index', '#' => $anchor]);
    }
}
?>
<div class="main-menu">
    <div class="logo">
        <a href="<?= Url::home() ?>"><img src="images/logo.png" alt="Logo"></a>
    </div>
    
    <!-- Кнопка бургер-меню (только на мобильных) -->
    <button class="menu-toggle" id="menuToggle" aria-label="Toggle navigation">
        <i class="fas fa-bars"></i>
    </button>
    
    <?php
    // Генерация меню через Nav::widget
    echo Nav::widget([
        'options' => [
            'class' => 'nav-links',
            'id' => 'navLinks',
        ],
        'encodeLabels' => false,
        'items' => [
            [
                'label' => 'Полеты',
                'url' => getMenuUrl('section2', $isHomePage),
                'items' => [
                    ['label' => 'История', 'url' => Url::to(['article/history'])],
                    ['label' => 'Планы', 'url' => Url::to(['article/plans'])],
                ],
                'linkOptions' => ['data-target' => 'section2'],
            ],
            [
                'label' => 'Обучение',
                'url' => getMenuUrl('section3', $isHomePage),
                'linkOptions' => ['data-target' => 'section3'],
            ],
            [
                'label' => 'Тандемный полет',
                'url' => getMenuUrl('section4', $isHomePage),
                'linkOptions' => ['data-target' => 'section4'],
            ],
            [
                'label' => 'О нас',
                'url' => getMenuUrl('section5', $isHomePage),
                'linkOptions' => ['data-target' => 'section5'],
            ],
        ],
    ]);
    ?>
    
    <div class="social-icons">
        <a href="https://vk.com/parachelovek" target="_blank"><i class="fab fa-vk"></i></a>
        <a href="https://t.me/FreeVmaya" target="_blank"><i class="fab fa-telegram"></i></a>
        <a href="https://www.youtube.com/watch?v=91N4xSpAqcU&list=PLoIsyK8Icrv3F6OcKH-w5OpjKuV30OYNq&index=3" target="_blank"><i class="fab fa-youtube"></i></a>
    </div>
</div>