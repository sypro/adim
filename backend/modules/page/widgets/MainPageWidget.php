<?php
/**
 * Created by JetBrains PhpStorm.
 * User: alex
 * Date: 17.06.14
 * Time: 16:07
 * To change this template use File | Settings | File Templates.
 */
namespace page\widgets;

use back\components\Widget;
use page\models\Order;

/**
 * Class SocialLinks
 * @package front\widgets\socialLinks
 */
class MainPageWidget extends Widget
{

    public $model;

    public function run()
    {
        if (!$this->model) {
            $this->model = new Order();
        }

        $this->render('index',array('model'=>$this->model,'color'=> '#e0e0e0'));
    }
}