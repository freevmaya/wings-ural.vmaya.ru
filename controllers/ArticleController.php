<?php

declare(strict_types=1);

namespace app\controllers;

use yii\web\Controller;

class ArticleController extends Controller
{
    /**
     * Страница "Что такое параплан?"
     * @return string
     */
    public function actionWhatIsParagrider(): string
    {
        $this->layout = 'main-fullscreen'; // или 'main' для обычного режима
        $this->view->title = 'Что такое параплан? | Параплан Челябинск';
        
        return $this->render('what_is_paragrider');
    }
}