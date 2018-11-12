<?php

namespace api\modules\v1\controllers;

use yii\filters\ContentNegotiator;
use yii\rest\Controller;
use api\modules\v1\models\Message;
use yii\web\Response;

/**
 * Class MessageController
 * @package api\modules\v1\controllers
 */
class MessageController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        // Add CORS filter
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::class,
        ];

        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::className(),
            'formatParam' => 'format',
            'formats' => [
                'application/json' => Response::FORMAT_JSON
            ]
        ];

        return $behaviors;
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $model = new Message();
        return [
            $model->message
        ];
    }
}
