<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Request;
use app\models\RegisterModel;

class AuthController extends Controller
{
    public function login()
    {
        $this->layout = 'auth';
        return $this->render('login');
    }

    public function register(Request $request)
    {
        $this->layout = 'auth';
        $model = new RegisterModel($request->getBody());
        if ($request->isPost()) {

            if ($model->validate() && $model->register()) {
                return 'register user';
            }
        }

        return $this->render('register', ['model' => $model]);
    }
}
