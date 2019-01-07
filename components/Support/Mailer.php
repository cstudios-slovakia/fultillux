<?php

namespace app\components\Support;

use Yii;
use dektrium\user\Mailer as BaseMailer;
use yii\base\InvalidConfigException;

/**
 * Class Mailer
 * @package app\components\Support
 */
class Mailer extends BaseMailer
{

    /**
     * @param $user
     * @return bool
     * @throws InvalidConfigException
     */
    public function sendNewProjectMessage($user)
    {
        return $this->sendMessage(
            $user->email,
            Yii::t('mail', 'New Project'),
            'newproject',
            ['username' => $user->username]
        );
    }

    /**
     * @param $user
     * @param string $url
     * @return bool
     * @throws InvalidConfigException
     */
    public function sendUploadMessage($user, $url = '')
    {
        return $this->sendMessage(
            $user->email,
            Yii::t('mail', 'A designer sent you files'),
            'upload',
            [
                'username' => $user->username,
                'url' => $url,
            ]
        );
    }

    /**
     * @param $user
     * @param $title
     * @param $url
     * @return bool
     * @throws InvalidConfigException
     */
    public function sendSorryMessage($user, $title, $url)
    {
        return $this->sendMessage(
            $user->email,
            Yii::t('mail', 'Sorry, your assignment did not win'),
            'sorry',
            [
                'username' => $user->username,
                'title' => $title,
                'url' => $url,
            ]
        );
    }

    /**
     * @param $user
     * @param $title
     * @param $url
     * @return bool
     * @throws InvalidConfigException
     */
    public function sendCongratsMessage($user, $title, $url)
    {
        return $this->sendMessage(
            $user->email,
            Yii::t('mail', 'Congratulations! Your assignment won. Here is what to do now.'),
            'congrats',
            [
                'username' => $user->username,
                'title' => $title,
                'url' => $url,
            ]
        );
    }


    /**
     * @return |null
     */
    public static function something()
    {
        return null;
    }

    /**
     * @param string $to
     * @param string $subject
     * @param string $view
     * @param array $params
     * @return bool
     * @throws InvalidConfigException
     */
    protected function sendMessage($to, $subject, $view, $params = [])
    {
        $mailer = $this->mailerComponent === null ? Yii::$app->mailer : Yii::$app->get($this->mailerComponent);
        $mailer->viewPath = $this->viewPath;
        $mailer->getView()->theme = Yii::$app->view->theme;

        if ($this->sender === null) {
            $this->sender = isset(Yii::$app->params['adminEmail']) ?
                Yii::$app->params['adminEmail']
                : 'no-reply@example.com';
        }

        return Yii::$app->mailer->compose()// a view rendering result becomes the message body here
        ->setFrom($this->sender)
            ->setTo($to)
            ->setSubject($subject)
            ->setHtmlBody(Yii::$app->view->render('@app/templates/mail/' . $view . '.twig', $params))
            ->send();

    }

}
