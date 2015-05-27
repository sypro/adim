<?php
/**
 *
 */

namespace frontend\models;

use front\components\ActiveRecord;
/**
 * This is the model class for table "{{order}}".
 *
 * The followings are the available columns in table '{{order}}':
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $message
 * @property integer $visible
 * @property integer $published
 * @property integer $position
 * @property integer $created
 * @property integer $modified
 */
class Order extends ActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Order the static model class
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
		return '{{order}}';
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
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
			array('name, email, message, created, modified', 'required'),
			array('visible, published, position, created, modified', 'numerical', 'integerOnly'=>true),
			array('name, email', 'length', 'max'=>200),
            array('message', 'safe'),
            array('email', 'email'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, email, message, visible, published, position, created, modified', 'safe', 'on'=>'search', ),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return \CMap::mergeArray(
			parent::attributeLabels(),
			array(
				'id' => 'ID',
				'name' => t('You Name'),
				'email' => t('You Email'),
				'message' => t('You Message'),
				'visible' => 'Visible',
				'published' => 'Published',
				'position' => 'Position',
				'created' => 'Created',
				'modified' => 'Modified',
			)
		);
	}

	/**
	 * Generate page url
	 *
	 * @param array $params
	 *
	 * @return array
	 */
	public function getPageUrl($params = array())
	{
		return self::createUrl(array(), $params);
	}

	/**
	 * Generate list page url
	 *
	 * @param array $params
	 *
	 * @return array
	 */
	public static function getListPageUrl($params = array())
	{
		return self::createUrl(array(), $params);
	}

	/**
	 * Returns a list of behaviors that this model should behave as.
	 *
	 * @return array the behavior configurations (behavior name=>behavior configuration)
	 */
	public function behaviors()
	{
		return \CMap::mergeArray(
			parent::behaviors(),
			array(
				'seo' => array(
					'class' => '\seo\components\SeoModelBehavior',
				),
			)
		);
	}
	// Typical usage in a controller or model
	public function afterSave()
	{
        $client_message = \Yii::app()->controller->renderPartial('mail/client', array('model'=>$this), true);
        $manager_message = \Yii::app()->controller->renderPartial('mail/manager', array('model'=>$this), true);
		$queue = new \emailQueue\models\EmailQueue();
        $queue->add('Adim Design Group',$this->email, $client_message);
        $queue->add('Adim Design Group',"itdep24@gmail.com", $manager_message);

	    parent::afterSave();
	}
}
