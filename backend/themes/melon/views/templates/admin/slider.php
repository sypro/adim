<?php
/**
 * Created by JetBrains PhpStorm.
 * User: alex
 * Date: 30.10.14
 * Time: 1:40
 * To change this template use File | Settings | File Templates.
 * @var $this \back\components\BackController
 * @var $model \back\components\IBackActiveRecord|\back\components\ActiveRecord
 */
$this->breadcrumbs = $model->genAdminBreadcrumbs('index');

$this->beginWidget(
    'bootstrap.widgets.TbModal',
    array('id' => 'addImageModal')
);
?>

    <div class="modal-header">
        <a class="close" data-dismiss="modal">&times;</a>
        <h4>Add image</h4>
    </div>

    <div class="modal-body">
        <p><?php print( $form->render());?></p>
    </div>


<?php $this->endWidget(); ?>

<?php

$box = $this->beginWidget('bootstrap.widgets.TbBox', $model->genPageName('index'));

    $this->widget(
        'bootstrap.widgets.TbButton',
        array(
            'icon'=>'icon-plus',
            'label' => ' Add image',
            'htmlOptions' => array(
                'data-toggle' => 'modal',
                'data-target' => '#addImageModal',
            ),
        )
    );
    $this->widget('bootstrap.widgets.TbExtendedGridView',array(
        'id' => class2id(get_class($model)) . '-grid',
        'type' => 'striped bordered',
        'dataProvider' => $model->resetScope()->search(),
        'filter' => $model,
        'columns' => $model->genColumns('index'),
    ));

$this->endWidget();
