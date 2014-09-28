<?php
/**
 *
 */

namespace emailQueue\models;

use back\components\ActiveRecord;
use CActiveRecord;
use CEvent;
use CModelEvent;

/**
 * This is the model class for table "{{email_queue}}".
 *
 * The followings are the available columns in table '{{email_queue}}':
 * @property integer $id
 * @property string $subject
 * @property string $to
 * @property string $body
 * @property integer $type
 * @property integer $errors
 * @property integer $last_attempt
 * @property integer $status
 * @property string $last_error
 */
class EmailQueue extends ActiveRecord
{
	/**
	 * waiting for send
	 */
	const STATUS_WAITING = 0;

	/**
	 * in progress
	 */
	const STATUS_IN_PROGRESS = 1;

	/**
	 * email was send
	 */
	const STATUS_SENDED = 2;

	/**
	 * error while sending
	 */
	const STATUS_ERROR = 3;

	/**
	 * general email
	 */
	const TYPE_GENERAL = 0;

	/**
	 * system emails: errors, logs, other
	 */
	const TYPE_SYSTEM = 1;

	/**
	 * @var
	 */
	public $email;

	/**
	 * @var
	 */
	public $name;

	/**
	 * @return array
	 */
	public static function getStatuses()
	{
		return array(
			self::STATUS_WAITING => 'В очереди',
			self::STATUS_IN_PROGRESS => 'Обрабатывается',
			self::STATUS_SENDED => 'Отправлено',
			self::STATUS_ERROR => 'Ошибка',
		);
	}

	/**
	 * @return null
	 */
	public function getStatus()
	{
		$array = self::getStatuses();
		return isset($array[$this->status]) ? $array[$this->status] : null;
	}

	/**
	 * @return array
	 */
	public static function getTypes()
	{
		return array(
			self::TYPE_GENERAL => 'Обычное',
			self::TYPE_SYSTEM => 'Системное',
		);
	}

	/**
	 * @return null
	 */
	public function getType()
	{
		$array = self::getTypes();
		return isset($array[$this->type]) ? $array[$this->type] : null;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return EmailQueue the static model class
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
		return '{{email_queue}}';
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
			array('email, name, body, subject', 'required'),
			array('type, errors, last_attempt, status', 'numerical', 'integerOnly' => true),
			array('email, name', 'length', 'max' => 200),
			array('email', 'email'),
			array('subject', 'length', 'max' => 300),
			array('to, last_error', 'length', 'max' => 500),
			array('body', 'safe'),
			// The following rule is used by search().
			array('id, subject, to, body, type, errors, last_attempt, status, last_error', 'safe', 'on' => 'search', ),
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
				'subject' => 'Тема',
				'to' => 'Кому',
				'body' => 'Сообщение',
				'type' => 'Тип',
				'errors' => 'Ошибки',
				'last_attempt' => 'Последняя попытка',
				'status' => 'Статус',
				'last_error' => 'Ошибка',
				'email' => 'Кому (почта)',
				'name' => 'Кому (имя)',
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
		$criteria->compare('t.subject', $this->subject, true);
		$criteria->compare('t.to', $this->to, true);
		$criteria->compare('t.body', $this->body, true);
		$criteria->compare('t.type', $this->type);
		$criteria->compare('t.errors', $this->errors);
		$criteria->compare('t.last_attempt', $this->last_attempt);
		$criteria->compare('t.status', $this->status);
		$criteria->compare('t.last_error', $this->last_error, true);

		return new \CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'pagination' => array(
				'pageSize' => $pageSize ? $pageSize : 50,
			),
			'sort' => array(
				'defaultOrder' => array(
					'id' => \CSort::SORT_DESC,
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
		return parent::genAdminBreadcrumbs($page, $title ? $title : 'Почта');
	}

	/**
	 * @param string $page
	 *
	 * @return array
	 */
	public function genAdminMenu($page)
	{
		$menu = parent::genAdminMenu($page);
		unset($menu['update']);
		unset($menu['delete']);
		return $menu;
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
					'subject',
					array(
						'name' => 'to',
						'type' => 'html',
						'value' => function (EmailQueue $data) {
							return \CHtml::tag('pre', array(), print_r(jd($data->to), true));
						},
					),
					array(
						'name' => 'type',
						'value' => function (EmailQueue $data) {
							return $data->getType();
						},
						'filter' => self::getTypes(),
						'htmlOptions' => array('class' => 'span1 center', ),
					),
					array(
						'name' => 'errors',
						'htmlOptions' => array('class' => 'span1 center', ),
					),
					array(
						'name' => 'status',
						'value' => function (EmailQueue $data) {
							return $data->getStatus();
						},
						'filter' => self::getStatuses(),
						'htmlOptions' => array('class' => 'span1 center', ),
					),
					array(
						'name' => 'last_error',
						'htmlOptions' => array('class' => 'span1 center', ),
					),
					array(
						'class' => 'bootstrap.widgets.TbButtonColumn',
						'template' => '{view}',
					),
				);
				break;
			case 'view':
				$columns = array(
					'id',
					'subject',
					array(
						'name' => 'to',
						'type' => 'html',
						'value' => \CHtml::tag('pre', array(), print_r(jd($this->to), true)),
					),
					'body:html',
					array(
						'name' => 'type',
						'value' => $this->getType(),
					),
					'errors',
					array(
						'name' => 'last_attempt',
						'value' => format()->formatDatetime($this->last_attempt),
					),
					array(
						'name' => 'status',
						'value' => $this->getStatus(),
					),
					'last_error',
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
				'subject' => array(
					'type' => 'text',
					'class' => 'span6',
				),
				'email' => array(
					'type' => 'text',
					'class' => 'span6',
				),
				'name' => array(
					'type' => 'text',
					'class' => 'span6',
				),
				'body' => array(
					'type' => 'textarea',
					'class' => 'span6',
					'rows' => 5,
				),
				'type' => array(
					'type' => 'dropdownlist',
					'items' => self::getTypes(),
					'class' => 'span3',
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
				)
			)
		);
	}

	/**
	 * Query default order
	 *
	 * @return $this
	 */
	public function ordered()
	{
		return $this->order('t.id DESC');
	}

	/**
	 * @param string $subject
	 * @param string $to
	 * @param string $body if array you need setup view file name
	 * @param null $view file name
	 * @param int $type
	 * @param int $status
	 *
	 * @return bool
	 */
	public static function add($subject, $to, $body, $view = null, $type = self::TYPE_GENERAL, $status = self::STATUS_WAITING)
	{
		if ($view && !empty($view) && is_array($body)) {
			$controller = new \CController('email');
			$bodyText = $controller->renderPartial($view, $body, true);
		} else {
			$bodyText = $body;
		}

		$queue = new EmailQueue();
		$queue->subject = $subject;
		$queue->to = json_encode($to);
		$queue->type = $type;
		$queue->status = $status;
		$queue->body = $bodyText;

		return $queue->save();
	}

	/**
	 * @return bool
	 */
	protected function beforeSave()
	{
		if (parent::beforeSave()) {
			$this->to = je(array($this->email => $this->name, ));
			return true;
		}
		return false;
	}
}
