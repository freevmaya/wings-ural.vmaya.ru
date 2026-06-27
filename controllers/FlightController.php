<?php

namespace app\controllers;

use yii\web\Controller;

class FlightController extends Controller
{
    public function actionVyezdy()
    {
        $this->layout = 'main';
        return $this->render('vyezdy');
    }
    
    public function actionPlany()
    {
        $this->layout = 'main';
        return $this->render('plany');
    }
}