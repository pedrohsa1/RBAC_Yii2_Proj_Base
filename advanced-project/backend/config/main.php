<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'homeUrl' => '/',

    'language' => 'pt',
    'sourceLanguage' => 'pt-BR',
    'timeZone' => 'America/Fortaleza',
    'charset' => 'UTF-8',

    'basePath' => dirname(__DIR__),

    'defaultRoute' => 'main/default/index', // Caso nenhuma Rota for Encontrada

    //Olhar o README.md na Raiz do modulo backend o config que é necessário
    'bootstrap' => [
        'log',
        //https://stackoverflow.com/questions/24308881/how-to-use-the-yii2-groupurlrule-class
        //Olhar a segunda resposta, explica o uso do Bootstrap com Module
        'modules\main\Bootstrap',
        'modules\users\Bootstrap',
        'modules\rbac\Bootstrap',
    ],
    'modules' => [
        'main' => [
            'isBackend' => true, //Se o módulo for usado no painel de administração (modules\main\Module.php).
        ],
        'users' => [
            'isBackend' => true, //Se o módulo for usado no painel de administração (modules\users\Module.php).
        ],
        'rbac' => [
            'class' => 'modules\rbac\Module',
            'params' => [
                'userClass' => 'modules\users\models\User',
            ]
        ],
    ],
    'components' => [
        'request' => [
            'cookieValidationKey' => '',
            'csrfParam' => '_csrf-backend',
            'baseUrl' => '/',
        ],
        'assetManager' => [
            'bundles' => [
                'yii\bootstrap\BootstrapAsset' => [
                    'sourcePath' => '@vendor/almasaeed2010/adminlte/bower_components/bootstrap/dist',
                    'css' => [
                        YII_ENV_DEV ? 'css/bootstrap.css' : 'css/bootstrap.min.css',
                    ]
                ],
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'sourcePath' => '@vendor/almasaeed2010/adminlte/bower_components/bootstrap/dist',
                    'js' => [
                        YII_ENV_DEV ? 'js/bootstrap.js' : 'js/bootstrap.min.js',
                    ]
                ],
            ],
        ],
        'user' => [
            'identityClass' => 'modules\users\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
            'loginUrl' => ['/users/default/login'],
        ],
        'session' => [
            // Este é o nome do cookie de sessão usado para login no backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'backend/error',
        ],

        /*
         * https://stackoverflow.com/questions/26206370/yii2-links-between-frontend-and-backend-advanced-template
           Pergunta: Se eu precisar adicionar links para coisas frontend da parte do backend no menu
           (ou do backend para o admin), como eu posso fazer isso sem o hardcode? Este:

            \Yii::$app->request->BaseUrl

            Retorna o caminho do diretório dos pais

            /sitename/backend/web
            /sitename/frontend/web

           Na sua configuração de aplicativo de BACKEND você deve adicionar um componente 'urlManager'
           com nome e configuração diferentes ao usado no aplicativo FRONTEND:
        */
        'urlManager' => [
            'enablePrettyUrl' => true,
            //'showScriptName' => false, //Não mostrar o "index.php" na URL
            //'enableStrictParsing' => true,
            'rules' => [],
        ],
        'urlManagerFrontend' => [
            'class' => 'yii\web\UrlManager',
            'baseUrl' => '',
            'enablePrettyUrl' => true, //Habilitar URL bonita
            //'showScriptName' => false,
            //'enableStrictParsing' => true,
            'rules' => [
                'email-confirm' => 'users/default/email-confirm'
            ],
        ],
    ],
    // Última visita
    'as afterAction' => [ // como depois da ação
        'class' => '\modules\users\behavior\LastVisitBehavior',
    ],
    // Acesso de administrador
    'as AccessBehavior' => [ // como comportamento de acesso
        'class' => '\modules\rbac\components\behavior\AccessBehavior',
        'permission' => \modules\rbac\models\Permission::PERMISSION_VIEW_ADMIN_PAGE, // Permitir acesso ao painel de administração
    ],
    'params' => $params,
];
