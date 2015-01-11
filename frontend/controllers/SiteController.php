<?php
/**
 *
 */

namespace frontend\controllers;

use front\components\FrontController;
use frontend\models\Gallery;
use frontend\models\Order;
use frontend\models\Partners;
use frontend\models\Principles;
use frontend\widgets\OrderForm;
use frontend\widgets\QuestionForm;

/**
 * Class SiteController
 *
 * @package frontend\controllers
 */
class SiteController extends FrontController
{
    public function actions()
    {
        return array(
            'captcha'=>array(
                'class'=>'CCaptchaAction',
                'backColor'=>0xFFFFFF,
            ),
        );
    }
	/**
	 * @var string
	 */
	public $layout = '//layouts/sub';

	/**
	 * index page of the site
	 */
	public function actionIndex()
	{
        $this->layout = '//layouts/main';
        $this->render('index');
	}
    public function actionAbout()
    {
        $this->render('about');
    }
    public function actionGallery($alias=null)
    {
        if($alias === null)
            $this->render('gallery',array('model'=> Gallery::getItems()));
        else{
            $model = $this->loadModel(array('alias' => $alias), Gallery::getClassName(), true);
            $this->render('gallery_one', array(
                'model' => $model,
            ));
        }
    }

    public function actionOrder()
    {
        $model = new Order();
        $modelName = \CHtml::modelName($model);
        $data = null;
        $sucsess_html = '<div class="modal-header"><button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">'.t('close').'</span></button><h3>'.t('Thanks').', '.t('we will contact with you').'</h3></div>';
        if (isset($_POST[$modelName])) {
            //use ajax and funcybox so we must upload js again
            cs()->registerScriptFile('/js/application.js');
            $model->setAttributes($_POST[$modelName]);
            if ($model->validate()) {
                $data = array(
                    'replaces' => array(
                        array(
                            'what' => '#claims-form',
                            'data' => $sucsess_html,
                        ),
                    ),
                );
//                $model->save();
            } else {
                $form = $this->widget(OrderForm::getClassName(), array('model' => $model, ), true);
                $data = array(
                    'replaces' => array(
                        array(
                            'what' => '#claims-form',
                            'data' => $form,
                        ),
                    ),
                );
            }
        } else {
            throw new \CHttpException(400, t('No data received'));
        }
        $this->renderJson($data);

    }
    public function actionQuestion()
    {
        $model = new Order();
        $modelName = \CHtml::modelName($model);
        $data = null;
        $sucsess_html = '<h3>'.t('Thanks').', '.t('we will contact with you').'</h3>';
        if (isset($_POST[$modelName])) {
            //use ajax and funcybox so we must upload js again
            cs()->registerScriptFile('/js/application.js');
            $model->setAttributes($_POST[$modelName]);
            if ($model->validate()) {
                $data = array(
                    'replaces' => array(
                        array(
                            'what' => '#question-form',
                            'data' => $sucsess_html,
                        ),
                    ),
                );
//                $model->save();
            } else {
                $form = $this->widget(QuestionForm::getClassName(), array('model' => $model, ), true);
                $data = array(
                    'replaces' => array(
                        array(
                            'what' => '#question-form',
                            'data' => $form,
                        ),
                    ),
                );
            }
        } else {
            throw new \CHttpException(400, t('No data received'));
        }
        $this->renderJson($data);

    }
    public function actionPartners()
    {
        $this->render('partners',array('model' => Partners::getItems()));
    }
    public function actionPrinciples()
    {
        $this->render('principles',array('model' => Principles::getItems()));
    }
    public function actionContacts()
    {
        $this->render('contact');
    }
    public function actionNewsite()
    {
        echo 'OK';
//        var_dump($_GET);
    }

	public function actionMaintenance()
	{
		$this->layout = false;
		$this->render('maintenance');
	}

	public function actionCms()
	{
		$this->layout = false;
		$this->render('cms');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if (($error = app()->errorHandler->error)) {
			if (r()->isAjaxRequest) {
				echo $error['message'];
			} else {
				$this->render('error', $error);
			}
		}
	}
}
