<?php
/**
 *
 */

namespace user\models;

use backstage\components\ActiveRecord;
use core\helpers\Core;

/**
 * This is the model class for table "{{user}}".
 *
 * The followings are the available columns in table '{{user}}':
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $role
 * @property string $password
 * @property string $salt
 * @property integer $visible
 * @property integer $published
 * @property integer $position
 */
class User extends ActiveRecord
{
	const ROLE_ADMIN = 'admin';

	public $new_password;

	public static function getRoles()
	{
		return array(
			self::ROLE_ADMIN => 'администратор',
		);
	}

	public static function genRoleText($id)
	{
		$array = self::getRoles();
		return isset($array[$id]) ? $array[$id] : null;
	}

	public function getRoleText()
	{
		return self::genRoleText($this->role);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{user}}';
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
			array('name, email, role', 'required'),
			array('name', 'length', 'max'=>75),
			array('email', 'length', 'max'=>45),
			array('role', 'length', 'max'=>20),
			array('email', 'email', ),
			array('new_password', 'length', 'min' => 6, ),

			array('new_password', 'required', 'on'=>'insert',),
			array('email', 'unique', 'on'=>'insert'),

			array('id, name, email, role', 'safe', 'on'=>'search', ),
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
				'name' => 'Имя',
				'email' => 'Email (для входа)',
				'role' => 'Доступ',
				'password' => 'Пароль',
				'new_password' => 'Новый пароль',
				'salt' => 'Соль',
			)
		);
	}

	public function getPageUrl($params = array())
	{
		return self::createUrl(array(), $params);
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
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria = new \CDbCriteria();

		$criteria->compare('id', $this->id);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('email', $this->email, true);
		$criteria->compare('role', $this->role, true);

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

	public function genAdminBreadcrumbs($page, $title = null)
	{
		return parent::genAdminBreadcrumbs($page, 'Пользователи');
	}

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
					'name',
					'email',
					'role',
					array(
						'class' => 'bootstrap.widgets.TbButtonColumn',
					),
				);
				break;
			case 'view':
				$columns = array(
					'id',
					'name',
					'email',
					'role',
				);
				break;
			default: break;
		}
		return $columns;
	}

	public function getFormConfig()
	{
		return array(
			'showErrorSummary' => true,
			'attributes' => array(
				'enctype' => 'multipart/form-data',
			),
			'elements' => array(
				'name' => array(
					'type' => 'text',
					'class' => 'span6',
				),
				'email' => array(
					'type' => 'text',
					'class' => 'span6',
				),
				'role' => array(
					'type' => 'dropdownlist',
					'class' => 'span3',
					'items' => self::getRoles(),
					'empty' => '',
				),
				'new_password' => array(
					'type' => 'text',
					'class' => 'span6',
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
	 * Validate password
	 *
	 * @param $password
	 *
	 * @return bool
	 */
	public function validatePassword($password)
	{
		return Core::genHashPassword($this->salt, $password) === $this->password;
	}

	protected function beforeSave()
	{
		if(parent::beforeSave())
		{
			if(!empty($this->new_password))
			{
				$this->salt = Core::genSalt();
				$this->password = Core::genHashPassword($this->salt, $this->new_password);
			}

			return true;
		}

		return false;
	}
}
