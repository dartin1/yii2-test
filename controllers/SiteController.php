<?php

namespace app\controllers;

use app\models\Employer;
use app\models\EmployerSearch;
use app\models\RegForm;
use app\models\SignupForm;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage with employers list.
     *
     * @return ActiveDataProvider
     */
    public function actionIndex()
    {
        $query = Employer::find()->where(['Chief' => 0]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->pagination = false;
        return $this->render('index', [
            'dataProvider' => $dataProvider,

        ]);

    }

    /**
     * Displays homepage with tree list.
     *
     * @param integer $id
     *
     * @return ActiveDataProvider
     */
    public function actionTree($id)
    {
        $data = new Employer();
        $dataProvider = $data->findTree($id);
        $dataProvider->pagination = false;

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Fill Data Base 'Employer' .
     *
     */
    public function actionSql()
    {
        $data = new Employer();
        $data->SQL();
    }

    /**
     * Displays page with best employers .
     *
     * @return mixed
     */
    public function actionBestemployer()
    {
        $query = Employer::find()->where(['BestEmployer' => '1']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->pagination = false;
        return $this->render('bestemployer', [
            'dataProvider' => $dataProvider,
        ]);

    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Registration action.
     *
     * @return mixed
     */
    public function actionReg()
    {
        $model = new RegForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }
        return $this->render('reg', ['model' => $model]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }


}
