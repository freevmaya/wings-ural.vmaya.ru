<?php
declare(strict_types=1);

/** @var yii\web\View $this */
/** @var string $content */

use app\widgets\Alert;
use yii\helpers\Html;

$this->render('_head');

$cssVersion = 3;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100" data-bs-theme="light">
<head>
    <?php $this->head() ?>
    <title><?= Html::encode($this->title) ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="/css/site.css?v=<?= $cssVersion ?>">
</head>
<body class="fullscreen-mode">
<?php $this->beginBody() ?>

<?= $this->render('_fullscreen_header') ?>

<div class="scroll-container" id="scrollContainer">
    <?= $content ?>
</div>

<script>
    (function() {
        const container = document.getElementById('scrollContainer');
        const sections = Array.from(document.querySelectorAll('.page-section'));
        const arrowBtns = document.querySelectorAll('.scroll-down');
        
        let currentIndex = 0;
        let isScrolling = false;
        let scrollTimeout = null;
        
        // --- БУРГЕР-МЕНЮ ---
        const menuToggle = document.getElementById('menuToggle');
        const navLinks = document.getElementById('navLinks');
        const dropdowns = document.querySelectorAll('.dropdown');
        
        function closeMenu() {
            if (navLinks) navLinks.classList.remove('open');
            if (menuToggle) {
                menuToggle.classList.remove('active');
                const icon = menuToggle.querySelector('i');
                if (icon) {
                    icon.className = 'fas fa-bars';
                }
            }
            dropdowns.forEach(d => d.classList.remove('open'));
        }
        
        if (menuToggle && navLinks) {
            menuToggle.addEventListener('click', function(e) {
                e.stopPropagation();
                navLinks.classList.toggle('open');
                this.classList.toggle('active');
                
                const icon = this.querySelector('i');
                if (icon) {
                    if (navLinks.classList.contains('open')) {
                        icon.className = 'fas fa-times';
                    } else {
                        icon.className = 'fas fa-bars';
                    }
                }
            });
            
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.main-menu')) {
                    closeMenu();
                }
            });
        }
        
        // --- ДЛЯ МОБИЛЬНЫХ: открытие/закрытие dropdown ---
        document.querySelectorAll('.nav-links .dropdown > a').forEach(function(link) {
            link.addEventListener('click', function(e) {
                if (window.innerWidth <= 900) {
                    const href = this.getAttribute('href');
                    if (href && href.startsWith('#section') && href !== '#') {
                        e.preventDefault();
                        closeMenu();
                        const targetId = href.substring(1);
                        scrollToSectionById(targetId);
                        return;
                    }
                    e.preventDefault();
                    const parent = this.closest('.dropdown');
                    if (parent) {
                        const isOpen = parent.classList.contains('open');
                        dropdowns.forEach(d => d.classList.remove('open'));
                        if (!isOpen) {
                            parent.classList.add('open');
                        }
                    }
                    if (!navLinks.classList.contains('open')) {
                        navLinks.classList.add('open');
                        menuToggle.classList.add('active');
                        const icon = menuToggle.querySelector('i');
                        if (icon) {
                            icon.className = 'fas fa-times';
                        }
                    }
                }
            });
        });
        
        // --- ОБРАБОТЧИКИ ДЛЯ ССЫЛОК В МЕНЮ ---
        document.querySelectorAll('.nav-links a[href^="#section"]').forEach(function(link) {
            link.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                if (href && href.startsWith('#section')) {
                    e.preventDefault();
                    const targetId = href.substring(1);
                    closeMenu();
                    scrollToSectionById(targetId);
                }
            });
        });
        
        document.querySelectorAll('.nav-links .dropdown > a[href="#"]').forEach(function(link) {
            link.addEventListener('click', function(e) {
                if (window.innerWidth > 900) {
                    e.preventDefault();
                }
            });
        });
        // --- КОНЕЦ БУРГЕР-МЕНЮ ---
        
        // --- ОСНОВНАЯ ЛОГИКА СКРОЛЛА ---
        
        function scrollToSection(index) {
            if (index < 0 || index >= sections.length || isScrolling) return;
            
            isScrolling = true;
            currentIndex = index;
            
            // Используем scrollIntoView с плавной анимацией
            sections[index].scrollIntoView({ 
                behavior: 'smooth', 
                block: 'start' 
            });
            
            // Обновляем активную ссылку
            updateActiveLink();
            
            // Разрешаем следующий скролл через 600ms
            setTimeout(() => {
                isScrolling = false;
            }, 600);
        }
        
        function scrollToSectionById(sectionId) {
            const section = document.getElementById(sectionId);
            if (section) {
                const index = sections.findIndex(sect => sect === section);
                if (index !== -1) {
                    scrollToSection(index);
                }
            }
        }
        
        // --- ОБРАБОТЧИК КОЛЕСИКА МЫШИ ---
        let wheelTimeout = null;
        let wheelDeltaAccumulator = 0;
        const wheelThreshold = 50; // Чувствительность колесика
        
        function handleWheel(e) {
            if (isScrolling) {
                e.preventDefault();
                return;
            }
            
            // Аккумулируем дельту колесика
            wheelDeltaAccumulator += e.deltaY;
            
            // Если накопилось достаточно, срабатываем
            if (Math.abs(wheelDeltaAccumulator) > wheelThreshold) {
                e.preventDefault();
                
                if (wheelDeltaAccumulator > 0) {
                    // Скролл вниз
                    if (currentIndex < sections.length - 1) {
                        scrollToSection(currentIndex + 1);
                    }
                } else {
                    // Скролл вверх
                    if (currentIndex > 0) {
                        scrollToSection(currentIndex - 1);
                    }
                }
                
                // Сбрасываем аккумулятор
                wheelDeltaAccumulator = 0;
            }
            
            // Отключаем стандартный скролл
            if (e.cancelable) {
                e.preventDefault();
            }
        }
        
        // --- ОБРАБОТЧИК КАСАНИЙ (ТОЧНОЕ УПРАВЛЕНИЕ) ---
        let touchStartY = 0;
        let touchStartTime = 0;
        let touchMoveCount = 0;
        const touchThreshold = 30; // Минимальное расстояние для свайпа
        
        function handleTouchStart(e) {
            touchStartY = e.touches[0].clientY;
            touchStartTime = Date.now();
            touchMoveCount = 0;
        }
        
        function handleTouchMove(e) {
            // Считаем количество событий touchmove для определения быстрого свайпа
            touchMoveCount++;
            
            // Если скроллинг заблокирован, предотвращаем скролл
            if (isScrolling) {
                e.preventDefault();
                return;
            }
            
            // Разрешаем небольшой скролл внутри секции, если она прокручивается
            const currentSection = sections[currentIndex];
            if (currentSection) {
                const scrollTop = currentSection.scrollTop;
                const scrollHeight = currentSection.scrollHeight;
                const clientHeight = currentSection.clientHeight;
                const isAtTop = scrollTop <= 0;
                const isAtBottom = scrollTop + clientHeight >= scrollHeight - 5;
                
                // Если мы в середине секции, разрешаем прокрутку внутри
                if (!isAtTop && !isAtBottom) {
                    return; // Разрешаем стандартную прокрутку внутри секции
                }
                
                // Если в начале и пытаемся скроллить вверх - блокируем
                if (isAtTop && e.touches[0].clientY > touchStartY) {
                    e.preventDefault();
                    return;
                }
                
                // Если в конце и пытаемся скроллить вниз - блокируем
                if (isAtBottom && e.touches[0].clientY < touchStartY) {
                    e.preventDefault();
                    return;
                }
            }
        }
        
        function handleTouchEnd(e) {
            if (isScrolling) return;
            
            const touchEndY = e.changedTouches[0].clientY;
            const diff = touchStartY - touchEndY;
            const timeDiff = Date.now() - touchStartTime;
            
            // Определяем, был ли это быстрый свайп (меньше 200ms) или медленный
            const isFastSwipe = timeDiff < 200;
            const threshold = isFastSwipe ? 20 : touchThreshold;
            
            if (Math.abs(diff) > threshold) {
                if (diff > 0) {
                    // Свайп вверх -> следующая секция
                    if (currentIndex < sections.length - 1) {
                        scrollToSection(currentIndex + 1);
                    }
                } else {
                    // Свайп вниз -> предыдущая секция
                    if (currentIndex > 0) {
                        scrollToSection(currentIndex - 1);
                    }
                }
            }
        }
        
        // --- ОБРАБОТЧИК КНОПОК СО СТРЕЛКАМИ ---
        arrowBtns.forEach((btn) => {
            btn.addEventListener('click', () => {
                const currentSection = btn.closest('.page-section');
                const currentIdx = sections.findIndex(sect => sect === currentSection);
                if (currentIdx !== -1 && currentIdx < sections.length - 1) {
                    scrollToSection(currentIdx + 1);
                }
            });
        });
        
        // --- ОПРЕДЕЛЕНИЕ ТЕКУЩЕЙ СЕКЦИИ ---
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && entry.intersectionRatio >= 0.4) {
                    const idx = sections.findIndex(sect => sect === entry.target);
                    if (idx !== -1 && !isScrolling) {
                        currentIndex = idx;
                        updateActiveLink();
                    }
                }
            });
        }, { 
            threshold: [0.1, 0.2, 0.3, 0.4, 0.5],
            rootMargin: '0px 0px -50px 0px'
        });
        
        sections.forEach(section => observer.observe(section));
        
        // --- НАВЕШИВАЕМ ОБРАБОТЧИКИ ---
        container.addEventListener('wheel', handleWheel, { passive: false });
        container.addEventListener('touchstart', handleTouchStart, { passive: true });
        container.addEventListener('touchmove', handleTouchMove, { passive: false });
        container.addEventListener('touchend', handleTouchEnd, { passive: true });
        
        // --- ОБНОВЛЕНИЕ АКТИВНЫХ ССЫЛОК ---
        function updateActiveLink() {
            document.querySelectorAll('.nav-links a').forEach(link => {
                link.classList.remove('active');
            });
            
            if (sections[currentIndex]) {
                const activeId = sections[currentIndex].id;
                document.querySelectorAll('.nav-links a').forEach(link => {
                    const href = link.getAttribute('href');
                    if (href === '#' + activeId) {
                        link.classList.add('active');
                    }
                });
            }
        }
        
        // --- АДАПТАЦИЯ ПРИ ИЗМЕНЕНИИ РАЗМЕРА ---
        let resizeTimeout;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(function() {
                if (window.innerWidth > 900) {
                    closeMenu();
                }
                // Обновляем позицию при изменении размера
                if (!isScrolling) {
                    const currentSection = sections[currentIndex];
                    if (currentSection) {
                        currentSection.scrollIntoView({ block: 'start' });
                    }
                }
            }, 300);
        });
        
        // --- ИНИЦИАЛИЗАЦИЯ ---
        setTimeout(() => {
            // Прокручиваем к первой секции
            if (sections.length > 0) {
                sections[0].scrollIntoView({ block: 'start' });
            }
            updateActiveLink();
        }, 100);
        
    })();
</script>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>