<?php

namespace modules\rbac\controllers;

use Yii;
use yii\helpers\Url;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use modules\rbac\Module;

/**
 * Class DefaultController
 * @package modules\rbac\controllers
 */
class DefaultController extends \modules\rbac\console\InitController
{
    /**
     * @inheritdoc
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['managerRbac'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'init' => YII_ENV_TEST ? ['GET'] : ['POST'],
                ],
            ],
        ];
    }

    /**
     * Renderiza a exibição do índice para o módulo
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Reinicializar o RBAC
     * com configurações padrão
     */
    public function actionInit()
    {
        if ($this->processInit()) {
            Yii::$app->session->setFlash('success', Module::t('module', 'The operation was successful!'));
        }
        Yii::$app->getResponse()->redirect(Url::to(['index']));
    }
}
