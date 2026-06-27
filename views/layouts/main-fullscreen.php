<?php
declare(strict_types=1);

/** @var yii\web\View $this */
/** @var string $content */

use app\widgets\Alert;
use yii\helpers\Html;

$this->render('_head');

$cssVersion = 1;
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
        
        // --- БУРГЕР-МЕНЮ ---
        const menuToggle = document.getElementById('menuToggle');
        const navLinks = document.getElementById('navLinks');
        const dropdowns = document.querySelectorAll('.dropdown');
        
        // Функция закрытия меню
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
            
            // Клик вне меню закрывает его
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.main-menu')) {
                    closeMenu();
                }
            });
        }
        
        // --- ДЛЯ МОБИЛЬНЫХ: открытие/закрытие dropdown ---
        dropdowns.forEach(dropdown => {
            const link = dropdown.querySelector('a');
            if (link) {
                link.addEventListener('click', function(e) {
                    if (window.innerWidth <= 900) {
                        // Проверяем, является ли ссылка якорем секции
                        const href = this.getAttribute('href');
                        if (href && href.startsWith('#section')) {
                            // Это ссылка на секцию - закрываем меню и скроллим
                            e.preventDefault();
                            closeMenu();
                            const targetId = href.substring(1);
                            scrollToSectionById(targetId);
                            return;
                        }
                        // Это ссылка с выпадающим меню
                        e.preventDefault();
                        const isOpen = dropdown.classList.contains('open');
                        dropdowns.forEach(d => d.classList.remove('open'));
                        if (!isOpen) {
                            dropdown.classList.add('open');
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
            }
        });
        
        // --- ОБРАБОТЧИКИ ДЛЯ ССЫЛОК В МЕНЮ (включая десктоп) ---
        document.querySelectorAll('.main-menu a[href^="#section"]').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('href').substring(1);
                // Закрываем меню перед скроллом
                closeMenu();
                scrollToSectionById(targetId);
            });
        });
        // --- КОНЕЦ БУРГЕР-МЕНЮ ---
        
        function scrollToSection(index) {
            if (index < 0 || index >= sections.length || isScrolling) return;
            isScrolling = true;
            sections[index].scrollIntoView({ behavior: 'smooth', block: 'start' });
            setTimeout(() => { isScrolling = false; }, 800);
            currentIndex = index;
            updateActiveLink();
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
        
        arrowBtns.forEach((btn) => {
            btn.addEventListener('click', () => {
                const currentSection = btn.closest('.page-section');
                const currentIdx = sections.findIndex(sect => sect === currentSection);
                if (currentIdx !== -1 && currentIdx < sections.length - 1) {
                    scrollToSection(currentIdx + 1);
                }
            });
        });
        
        let wheelTimeout = null;
        function handleWheel(e) {
            if (isScrolling) return;
            const delta = e.deltaY;
            if (wheelTimeout) clearTimeout(wheelTimeout);
            wheelTimeout = setTimeout(() => {
                if (delta > 30) {
                    if (currentIndex < sections.length - 1) {
                        scrollToSection(currentIndex + 1);
                    }
                } else if (delta < -30) {
                    if (currentIndex > 0) {
                        scrollToSection(currentIndex - 1);
                    }
                }
                wheelTimeout = null;
            }, 100);
        }
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && entry.intersectionRatio >= 0.5) {
                    const idx = sections.findIndex(sect => sect === entry.target);
                    if (idx !== -1) {
                        currentIndex = idx;
                        updateActiveLink();
                    }
                }
            });
        }, { threshold: 0.5 });
        
        sections.forEach(section => observer.observe(section));
        container.addEventListener('wheel', handleWheel, { passive: false });
        
        let touchStartY = 0;
        container.addEventListener('touchstart', (e) => {
            touchStartY = e.touches[0].clientY;
        }, { passive: true });
        
        container.addEventListener('touchend', (e) => {
            const touchEndY = e.changedTouches[0].clientY;
            const diff = touchStartY - touchEndY;
            if (Math.abs(diff) > 50) {
                if (diff > 0 && currentIndex < sections.length - 1) {
                    scrollToSection(currentIndex + 1);
                } else if (diff < 0 && currentIndex > 0) {
                    scrollToSection(currentIndex - 1);
                }
            }
        }, { passive: true });
        
        function updateActiveLink() {
            document.querySelectorAll('.main-menu a[href^="#section"]').forEach(link => {
                link.classList.remove('active');
            });
            if (sections[currentIndex]) {
                const activeId = sections[currentIndex].id;
                const activeLink = document.querySelector(`.main-menu a[href="#${activeId}"]`);
                if (activeLink) {
                    activeLink.classList.add('active');
                }
            }
        }
        
        setTimeout(updateActiveLink, 100);
        
        let resizeTimeout;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(function() {
                if (window.innerWidth > 900) {
                    closeMenu();
                }
            }, 250);
        });
    })();
</script>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>