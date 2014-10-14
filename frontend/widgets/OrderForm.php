<?php
/**
 * Created by JetBrains PhpStorm.
 * User: alex
 * Date: 17.06.14
 * Time: 16:07
 * To change this template use File | Settings | File Templates.
 */
namespace frontend\widgets;

use front\components\Widget;
use frontend\models\Order;

/**
 * Class SocialLinks
 * @package front\widgets\socialLinks
 */
class OrderForm extends Widget
{

    public $model;

    public function run()
    {
        if (!$this->model) {
            $this->model = new Order();
        }

        $this->render('orderform',array('model'=>$this->model,'color'=> '#e0e0e0'));
    }
}