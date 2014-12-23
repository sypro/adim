<?php
/**
 *
 */

namespace gallery\models;

use back\components\ActiveRecord;
use gallery\models\Gallery;
use fileProcessor\helpers\FPM;
use back\components\FileFormInputElement;
use back\components\MultiFileFormInputElement;

/**
 * This is the model class for table "{{image}}".
 *
 * The followings are the available columns in table '{{image}}':
 * @property integer $id
 * @property string $label
 * @property integer $image_id
 * @property integer $gallery_id
 * @property integer $visible
 * @property integer $published
 * @property integer $position
 */
class Image extends ActiveRecord
{

	public $images;

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Image the static model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{image}}';
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'gallery'    => array(self::BELONGS_TO, Gallery::getClassName(), 'gallery_id'),
		);
	}

	public function getRelatedFiles(){
			if($this->gallery_id){
				$images = Image::model()->findAllByAttributes(array('gallery_id'=>$this->gallery_id));
			}else{
				$images = new Image();
			}
		    return $images;
		    //foreach ($images as $image)
	        //	$this->images[] =  $image->image_id ;
	}
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('gallery_id', 'required'),
			array('gallery_id, visible, published, position', 'numerical', 'integerOnly' => true),
			array('label', 'length', 'max' => 200),
			// The following rule is used by search().
			array('id, label, gallery_id, visible, published, position', 'safe', 'on' => 'search', ),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		$labels = \CMap::mergeArray(
			parent::attributeLabels(),
			array(
				'gallery_id' => 'Gallery',
			)
		);
		$labels = $this->generateLocalizedAttributeLabels($labels);
		return $labels;
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * @param bool $pageSize
	 *
	 * @return \CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search($pageSize = false)
	{
		$criteria = new \CDbCriteria();

		$criteria->compare('t.id', $this->id);
		$criteria->compare('t.label', $this->label, true);
		$criteria->compare('t.gallery_id', $this->gallery_id);
		$criteria->compare('t.visible', $this->visible);
		$criteria->compare('t.published', $this->published);
		$criteria->compare('t.position', $this->position);

		return new \CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'pagination' => array(
				'pageSize' => $pageSize ? $pageSize : 50,
			),
			'sort' => array(
				'defaultOrder' => array(
					'position' => \CSort::SORT_DESC,
				),
			),
		));
	}

	/**
	 * Generate breadcrumbs
	 *
	 * @param string $page
	 * @param null|string $title
	 *
	 * @return array
	 */
	public function genAdminBreadcrumbs($page, $title = null)
	{
		return parent::genAdminBreadcrumbs($page, $title ? $title : 'Image');
	}

	/**
	 * Get columns configs to specified page for grid or detail view
	 *
	 * @param $page
	 *
	 * @return array
	 */
	public function genColumns($page)
	{
		$columns = array();
		switch ($page) {
			case 'index':
				$columns = array(
					array(
						'name' => 'id',
						'htmlOptions' => array('class' => 'span1 center', ),
					),
					array(
                        'name' => 'gallery_id',
                        'value' => function($data){
                            echo $data->gallery->label;
                        },
                        'filter' => \CHtml::listData(Gallery::getItems(), 'id', 'label'),
                    ),
					// 'gallery.label',
					// array(
					// 	'name' => 'gallery'
					// 	),
					array(
						'class' => 'back\components\ImageColumn',
						'name' => 'image_id',
					),
//                    'label',
//                    'gallery_id',
					array(
						'class' => 'back\components\CheckColumn',
						'header' => 'Видим',
						'name' => 'visible',
					),
					array(
						'class' => 'back\components\CheckColumn',
						'header' => 'Опубликовано',
						'name' => 'published',
					),
					array(
						'name' => 'position',
						'htmlOptions' => array('class' => 'span1 center', ),
					),
					array(
						'class' => 'bootstrap.widgets.TbButtonColumn',
					),
				);
				break;
			case 'view':
				$columns = array(
					'id',
					//'label',
					'image_id:fpmImage',
					'gallery_id',
					'visible:boolean',
					'published:boolean',
					'position',
				);
				break;
			default:
				break;
		}
		return $columns;
	}

	/**
	 * Get form config
	 *
	 * @return array
	 */
	public function getFormConfig()
	{
		return array(
			'showErrorSummary' => true,
			'attributes' => array(
				'enctype' => 'multipart/form-data',
			),
			'elements' => array(
//				'label' => array(
//					'type' => 'text',
//					'class' => 'span6',
//				),
				'image_id' => array(
					'type' => '\back\components\FileFormInputElement',
					'content' => 'image',
				),
				// 'relatedFiles' => array(
				// 	'type' => '\back\components\MultiFileFormInputElement',
				// 	// 'content' => 'image',
				// ),
				'gallery_id' => array(
                    'type' => 'dropdownlist',
                    'items' => \CHtml::listData(Gallery::getItems(), 'id', 'label'),
                    'empty'=>array(''=>''),
                    'class' => 'span3',
				),
				'visible' => array(
					'type' => 'checkbox',
				),
				'published' => array(
					'type' => 'checkbox',
				),
				'position' => array(
					'type' => 'text',
					'class' => 'span2',
				),
			),

			'buttons' => array(
				'submit' => array(
					'type' => 'submit',
					'layoutType' => 'primary',
					'label' => $this->isNewRecord ? 'Создать' : 'Сохранить',
				),
				'reset' => array(
					'type' => 'reset',
					'label' => 'Сбросить',
				),
			),
		);
	}
/*
	public function beforeSave(){
		if(is_array($this->image_id))
			foreach ($this->image_id as $key => $value) {
				$new_image = new Image();
				$new_image->image_id = $value;
				$new_image->label = $this->label;
				$new_image->gallery_id = $this->gallery_id;
				$new_image->save();
				
				//'image_id:fpmImage',label
					// 'gallery_id',
					// 'visible:boolean',
					// 'published:boolean',
					// 'position',
				// $this->image_id = $value;
				// $this->save();
				# code...
			}
	}

	*/
	/**
	 * Returns a list of behaviors that this model should behave as.
	 *
	 * @return array the behavior configurations (behavior name=>behavior configuration)
	 */
	public function behaviors()
	{
		/*
		 * Warning: every behavior need contains fields:
		 * 'configLanguageAttribute' required
		 * 'configBehaviorAttribute' required
		 * 'configBehaviorKey' optional (default: b_originKey_lang, where originKey is key of the row in array
		 * lang will be added in tail
		 */
		$languageBehaviors = array();
		$behaviors = $this->prepareBehaviors($languageBehaviors);
		return \CMap::mergeArray(
			parent::behaviors(),
			\CMap::mergeArray(
				$behaviors,
				array(
					'b_image_id' => array(
						'class' => '\fileProcessor\components\FileMultiUploadBehavior',
						// 'attributeName' => 'image_id',
						'fileTypes' => 'png, gif, jpeg, jpg',
					),
					'seo' => array(
						'class' => '\seo\components\SeoModelBehavior',
					),
				)
			)
		);
	}
}
