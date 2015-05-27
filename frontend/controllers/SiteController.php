<?php
/**
 *
 */

namespace frontend\controllers;

use front\components\FrontController;
use frontend\models\Gallery;
use frontend\models\Order;
use frontend\models\Slider;
use frontend\models\Partners;
use frontend\models\Principles;
use frontend\widgets\OrderForm;
use frontend\widgets\QuestionForm;

// use front\modules\emailQueue\models;
// use emailQueue\models;
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
        $this->render('index',array('model' => Slider::getItems()));
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
               $model->save();
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
               $model->save();
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
   $this->layout = '//layouts/main';

   $model = Slider::getItems();
            $model = $this->loadAllModel(Slider::getClassName());

            // $this->getPageTitle($model);
        $this->render('index',array('model' =>$model));

// public function loadModel($id, $class = false, $attributes = false, $prepare = true, $seo = true, $condition = '', $params = array())
    // {
        // if ($class === false) {
        //     $class = $this->getModelClass();
        // }
        // /** @var ActiveRecord $finder */
        // $finder = ActiveRecord::model($class)->published();
        // if (is_array($id) && $attributes) {
        //     $model = $finder->findByAttributes($id, $condition, $params);
        // } else {
        //     $model = $finder->findByPk($id, $condition, $params);
        // }
        // if ($model === null) {
        //     throw new \CHttpException(404, t('The requested page does not exist.'));
        // }
        // if ($prepare) {
        //     $this->prepare($model);
        // }
        // if ($seo && $model->asa('seo') && $this->asa('seo')) {
        //     $this->registerSEO($model);
        // }
        // return $model;
    // }





            // $this->registerSEO(Slider::getClassName());

        // $this->render('index',array('model' => Slider::getItems()));

            // $model = $this->loadModel(array('id'=>'1'),Slider::getClassName(), true);
            // $this->render('index',array('model' =>$model));


// if ($seo && $model->asa('seo') && $this->asa('seo')) {
//             $this->registerSEO($model);
//         }

        // $this->render('index',array('model' =>$model));



// if ($seo && $model->asa('seo') && $this->asa('seo')) {
//             $this->registerSEO($model);
//         }

            // echo "<pre>";
            // var_dump($model);
        // $this->render('contact');
            // $this->metaKeywords = 'these, are, my, sample, page, meta, keywords';
    // $this->metaDescription = 'This is a sample page description';


// $this->layout = '//layouts/main';
//         $this->render('index',array('model' => Slider::getItems()));




//         $message = \Yii::app()->controller->renderPartial('mail/client', array( ), true); // Make sure to return true since we want to capture the output
//         $messagetwo = \Yii::app()->controller->renderPartial('mail/manager', array( ), true); // Make sure to return true since we want to capture the output
// echo $message;
// echo "<hr>";
// echo $messagetwo;



        // $queue = new \emailQueue\models\EmailQueue();
        // $queue->add('test', 'itdep24@gmail.com', 'message');
        // $queue->to_email = 'itdep24@gmail.com';
        // $queue->subject = "Mall Kids Are People Too, Damnit!";
        // // $queue->from_email = Yii::app()->params['adminEmail'];
        // // $queue->from_name = Yii::app()->name;
        // $queue->from_email = 'admin@adim-design.com';
        // $queue->from_name = Yii::app()->name;
        // $queue->date_published = new CDbExpression('NOW()');
        // $queue->message = 'allalla'; // Make sure to return true since we want to capture the output
        // // $queue->message = $this->message;
        // $queue->save();
     

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
