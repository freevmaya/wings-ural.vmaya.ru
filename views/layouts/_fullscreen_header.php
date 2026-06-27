<?php

declare(strict_types=1);

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\helpers\Url;

?>
<div class="main-menu">
    <div class="logo">
        <a href="<?= Url::home() ?>"><img src="images/logo.png"></a>
    </div>
    <ul class="nav-links">
        <!-- Пункт 1: Полеты -->
        <li class="dropdown">
            <a href="#section2">Полеты <i class="fas fa-chevron-down"></i></a>
        </li>
        <!-- Пункт 2: Обучение -->
        <li class="dropdown">
            <a href="#section3">Обучение <i class="fas fa-chevron-down"></i></a>
        </li>
        <!-- Пункт 3: Тандемный полет -->
        <li class="dropdown">
            <a href="#section4">Тандемный полет <i class="fas fa-chevron-down"></i></a>
        </li>
        <li><a href="#section5">О нас</a></li>
    </ul>
    <div class="social-icons">
        <a href="https://vk.com/parachelovek" target="_blank"><i class="fab fa-vk"></i></a>
        <a href="https://t.me/FreeVmaya" target="_blank"><i class="fab fa-telegram"></i></a>
        <a href="https://www.youtube.com/watch?v=91N4xSpAqcU&list=PLoIsyK8Icrv3F6OcKH-w5OpjKuV30OYNq&index=3" target="_blank"><i class="fab fa-youtube"></i></a>
    </div>
</div>