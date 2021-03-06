<?php
/**
 *
 */

namespace gallery\models;

use back\components\ActiveRecord;
use gallery\models\Images;
use fileProcessor\helpers\FPM;
use back\components\FileFormInputElement;
use back\components\MultiFileFormInputElement;

/**
 * This is the model class for table "{{gallery}}".
 *
 * The followings are the available columns in table '{{gallery}}':
 * @property integer $id
 * @property string $label
 * @property string $alias
 * @property integer $image_id
 * @property integer $visible
 * @property integer $published
 * @property integer $position
 *
 * The followings are the available model relations:
 * @property GalleryLang[] $galleryLangs
 */
class Gallery extends ActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Gallery the static model class
	 */

	// public $images = array();

	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{gallery}}';
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'galleryLangs' => array(self::HAS_MANY, 'GalleryLang', 'model_id'),
			'images' => array(self::HAS_MANY, 'id', 'gallery_id'),
		);
	}
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('visible, published, position', 'numerical', 'integerOnly' => true),
			array('label, alias', 'length', 'max' => 200),
			// The following rule is used by search().
			array('id, label, alias, visible, published, position', 'safe', 'on' => 'search', ),
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
				'uploadImages[]'=> 'Картинки',
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
        $criteria->compare('t.label', $this->alias, true);
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
		return parent::genAdminBreadcrumbs($page, $title ? $title : 'Gallery');
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
					'label',
					array(
						'class' => 'back\components\ImageColumn',
						'name' => 'image_id',
					),
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
					'label',
                    'alias',
					'image_id:fpmImage',
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
				'label' => array(
					'type' => 'text',
					'class' => 'for_translation span6',
				),
                'alias' => array(
                    'type' => 'text',
                    'class' => 'alias span6',
                ),
				'image_id' => array(
					'type' => '\back\components\FileFormInputElement',
					'content' => 'image',
				),
				// 'images' => array(
				// 	'type' => '\back\components\MultiFileFormInputElement',
				// 	'content' => 'image',
				// ),
				'uploadImages[]' => array(
                    'type' => MultiFileFormInputElement::getClassName(),
                    'content'=> 'image',
                    // 'link'=> '/gallery/image/delete',
                   // 'model'=> Image::getClassName(),
                   // 'attribute'=>'image_id',

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
						'class' => '\fileProcessor\components\FileUploadBehavior',
						'attributeName' => 'image_id',
						'fileTypes' => 'png, gif, jpeg, jpg',
					),
					'seo' => array(
						'class' => '\seo\components\SeoModelBehavior',
					),
					'multiLang' => array(
						'class' => '\language\components\MultilingualBehavior',
						'localizedAttributes' => self::getLocalizedAttributesList(),
						'languages' => \language\helpers\Lang::getLanguageKeys(),
						'defaultLanguage' => \language\helpers\Lang::getDefault(),
						'forceOverwrite' => true,
					),
				)
			)
		);
	}

	/**
	 * Get list of localized attributes
	 *
	 * @return array
	 */
	public static function getLocalizedAttributesList()
	{
		return array('label');
	}


	protected $relatedItem;

	public function setRelatedItem($relatedItem)
    {
        $this->relatedItem = $relatedItem;
    }

    protected function afterSave()
    {
        $images = \CUploadedFile::getInstances($this, 'uploadImages');
        foreach ($images as $image) {
            $imageId = FPM::transfer()->saveUploadedFile($image);
            $model = new Image;
            $model->image_id = $imageId;
            // $model->model_name = $this->getClassName();
            // $model->model_id = $this->id;
            $model->gallery_id = $this->id;
            $model->save();
        }

        // if ($this->scenario !== 'change') {
        //     // CoachStyle::model()->deleteAllByAttributes(array('style_id' => $this->id, ));
        //     if (is_array($this->relatedItem)) {
        //         foreach ($this->relatedItem as $relatedId) {
        //             $assign = new CoachStyle();
        //             $assign->coach_id = $relatedId;
        //             $assign->style_id = $this->id;
        //             $assign->save();
        //         }
        //     }
        // }
        parent::afterSave();
    }


    public function getRelatedFiles(){
        $items = array();
        $iamges = Image::model()->findAll(array('condition'=>'gallery_id=:gallery_id','params'=>array(':gallery_id'=>$this->id)));
        foreach($iamges as $image){
            $items[]=$image->image_id;
        }
        return $items;
    }



}
