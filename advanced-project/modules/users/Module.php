<?php

namespace modules\users;

use Yii;
use yii\console\Application as ConsoleApplication;

/**
 * Class Module
 * @package modules\users
 */
class Module extends \yii\base\Module
{
    /**
     * Tempo em segundos, quando usuários com o status "Pendente" podem ser excluídos
     * Basicamente para a tarefa cron.
     * ```
     * php yii users/cron/remove-overdue  ->> IMPORTANTE!! DIGITAR ISSO NO TERMINAL PARA RODAR O PROJETO!!!!
     * ```
     * @var int
     */
    public $emailConfirmTokenExpire = 259200; // 3 days

    /**
     * @var int
     */
    public static $passwordResetTokenExpire = 3600;

    /**
     * @var string
     */
    public $controllerNamespace = 'modules\users\controllers\frontend';

    /**
     * @var bool Se o módulo for usado no painel de administração.
     */
    public $isBackend; //ESSE VALOR VEM DO "main.php" DO BACKEND!!

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // Aternar entre frontend e backend.
        if ($this->isBackend === true) {
            $this->controllerNamespace = 'modules\users\controllers\backend';
            $this->setViewPath('@modules/users/views/backend');
        } else {
            $this->setViewPath('@modules/users/views/frontend');
        }
        if (Yii::$app instanceof ConsoleApplication) {
            $this->controllerNamespace = 'modules\users\commands';
        }
    }

    /**
     * @param string $category
     * @param string $message
     * @param array $params
     * @param null|string $language
     * @return string
     */
    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('modules/users/' . $category, $message, $params, $language);
    }
}
