<?php

declare(strict_types=1);

/** @var yii\web\View $this */
/** @var string $content */

use app\widgets\Alert;
use yii\helpers\Html;

$this->render('_head');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100" data-bs-theme="light">
<head>
    <?php $this->head() ?>
    <title><?= Html::encode($this->title) ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
        
        function scrollToSection(index) {
            if (index < 0 || index >= sections.length || isScrolling) return;
            isScrolling = true;
            sections[index].scrollIntoView({ behavior: 'smooth', block: 'start' });
            setTimeout(() => { isScrolling = false; }, 800);
            currentIndex = index;
            updateActiveLink();
        }
        
        // Функция для скролла по ID секции
        function scrollToSectionById(sectionId) {
            const section = document.getElementById(sectionId);
            if (section) {
                const index = sections.findIndex(sect => sect === section);
                if (index !== -1) {
                    scrollToSection(index);
                }
            }
        }
        
        // Обработчики для всех кнопок "вниз"
        arrowBtns.forEach((btn) => {
            btn.addEventListener('click', () => {
                const currentSection = btn.closest('.page-section');
                const currentIdx = sections.findIndex(sect => sect === currentSection);
                if (currentIdx !== -1 && currentIdx < sections.length - 1) {
                    scrollToSection(currentIdx + 1);
                }
            });
        });
        
        // Обработчики для ссылок в меню
        document.querySelectorAll('.main-menu a[href^="#section"]').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('href').substring(1);
                scrollToSectionById(targetId);
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
        
        // Для мобильных устройств - тач-события
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
        
        // Обновляем активную ссылку в меню
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
        
        // Инициализация активной ссылки
        setTimeout(updateActiveLink, 100);
    })();
</script>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>