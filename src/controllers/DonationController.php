<?php
/**
 * donations-free plugin for Craft CMS 3.x
 *
 * Free Braintree Donation System
 *
 * @link      https://endurant.org
 * @copyright Copyright (c) 2017 endurant
 */

namespace infoservio\donatefast\controllers;

use infoservio\donatefast\DonateFast;

use Craft;
use infoservio\donatefast\records\StripeDonationSetting;
use yii\web\BadRequestHttpException;

/**
 * Donation Controller
 *
 * @author    infoservio
 * @package   Donationsfree
 * @since     1.0.0
 */
class DonationController extends BaseController
{
    // Protected Properties
    // =========================================================================

    /**
     * @var    bool|array Allows anonymous access to this controller's actions.
     *         The actions must be in 'kebab-case'
     * @access protected
     */
    protected $allowAnonymous = ['donate', 'success', 'error'];

    // Public Methods
    // =========================================================================

    public function actionSuccess()
    {
        $successMessage = StripeDonationSetting::find()->where(['name' => 'successMessage'])->one()->value;
        $resetForm = Craft::$app->session->get('donation');

        return $this->renderTemplate('donation-success', [
            'baseUrl' => $resetForm['currentUrl'],
            'successMessage' => $successMessage,
            'resetForm' => $resetForm,
        ]);
    }

    public function actionError() 
    {
        $view = $this->getView();
        $view->setTemplatesPath($this->getViewPath());
        $resetForm = Craft::$app->session->get('donation');

        try {
            $errorMessage = StripeDonationSetting::find()->where(['name' => 'errorMessage'])->one()->value;

            return $this->renderTemplate('donation-error', [
                'errorMessage' => $errorMessage,
                'baseUrl' => $resetForm['currentUrl']
            ]);
        } catch (\Exception $e) {
            die($e->getMessage());
        }
    }

    /**
     * @return \yii\web\Response
     * @throws \yii\web\BadRequestHttpException
     * @throws \infoservio\donatefast\errors\StripeDonationsPluginException
     */
    public function actionDonate()
    {
        $this->requirePostRequest();
        $post = Craft::$app->request->getBodyParams();

        if (!$post) {
            throw new BadRequestHttpException('Wrong data.');
        }

        Craft::$app->session->set('donation', $post);
        try {
            DonateFast::$plugin->donation->donate($post);
        } catch (\Exception $e) {
            return $this->redirect('/donate-fast/error');
        }

        return $this->redirect('/donate-fast/success');
    }
}
