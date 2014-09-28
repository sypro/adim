<?php
/**
 * Author: Ivan Pushkin
 * Email: metal@vintage.com.ua
 */

namespace core\components;

/**
 * Class ActiveRecord
 * @package core\components
 *
 * @method integer[] getRelatedFiles()
 */
abstract class ActiveRecord extends \CActiveRecord
{
	/**
	 * Status false
	 */
	const STATUS_NOT = 0;

	/**
	 * Status true
	 */
	const STATUS_YES = 1;

	/**
	 * Cached page url
	 *
	 * @var
	 */
	protected $pageUrl;

	/**
	 * Cached list page url
	 *
	 * @var
	 */
	protected static $listPageUrl;

	/**
	 * Query order
	 *
	 * @param $order
	 *
	 * @return $this
	 */
	public function order($order)
	{
		$this->getDbCriteria()->order = $order;
		return $this;
	}

	/**
	 * Query compare
	 *
	 * @param $column
	 * @param $value
	 * @param bool $partialMatch
	 * @param string $operator
	 * @param bool $escape
	 *
	 * @return $this
	 */
	public function compare($column, $value, $partialMatch = false, $operator = 'AND', $escape = true)
	{
		$this->getDbCriteria()->compare($column, $value, $partialMatch, $operator, $escape);
		return $this;
	}

	/**
	 * Query in
	 *
	 * @param $field
	 * @param $ids
	 *
	 * @return $this
	 */
	public function in($field, $ids)
	{
		$ids = (array)$ids;
		$this->getDbCriteria()->addInCondition($field, $ids);
		return $this;
	}

	/**
	 * Query not in
	 *
	 * @param $field
	 * @param $ids
	 *
	 * @return $this
	 */
	public function notIn($field, $ids)
	{
		$ids = (array)$ids;
		$this->getDbCriteria()->addNotInCondition($field, $ids);
		return $this;
	}

	/**
	 * Query default order
	 *
	 * @return $this
	 */
	public function ordered()
	{
		return $this->order('t.position DESC');
	}

	/**
	 * Query limit
	 *
	 * @param int $limit
	 *
	 * @return $this
	 */
	public function limit($limit = 10)
	{
		$this->getDbCriteria()->limit = $limit;
		return $this;
	}

	/**
	 * @param $field
	 *
	 * @return $this
	 */
	public function groupBy($field)
	{
		$this->getDbCriteria()->group = $field;
		return $this;
	}

	/**
	 * @param $field
	 *
	 * @return $this
	 */
	public function isNotNull($field)
	{
		$this->getDbCriteria()->addCondition($field . ' IS NOT NULL');
		return $this;
	}

	/**
	 * @param $field
	 *
	 * @return $this
	 */
	public function isNull($field)
	{
		$this->getDbCriteria()->addCondition($field . ' IS NULL');
		return $this;
	}

	/**
	 * Query select
	 *
	 * @param string $select
	 *
	 * @return $this
	 */
	public function select($select = '*')
	{
		$this->getDbCriteria()->select = $select;
		return $this;
	}

	public function between($column, $valueStart, $valueEnd, $operator = 'AND')
	{
		$this->getDbCriteria()->addBetweenCondition($column, $valueStart, $valueEnd, $operator);
		return $this;
	}

	/**
	 * Returns a list of behaviors that this model should behave as.
	 * The return value should be an array of behavior configurations indexed by
	 * behavior names. Each behavior configuration can be either a string specifying
	 * the behavior class or an array of the following structure:
	 * <pre>
	 * 'behaviorName'=>array(
	 *     'class'=>'path.to.BehaviorClass',
	 *     'property1'=>'value1',
	 *     'property2'=>'value2',
	 * )
	 * </pre>
	 *
	 * Note, the behavior classes must implement {@link IBehavior} or extend from
	 * {@link CBehavior}. Behaviors declared in this method will be attached
	 * to the model when it is instantiated.
	 *
	 * For more details about behaviors, see {@link CComponent}.
	 * @return array the behavior configurations (behavior name=>behavior configuration)
	 */
	public function behaviors()
	{
		return array(
			'ensureNull' => array(
				'class' => '\core\components\EnsureNullBehavior',
			),
		);
	}

	/**
	 * Get only published models
	 *
	 * @return $this
	 */
	public function published()
	{
		if ($this->hasAttribute('published')) {
			$this->getDbCriteria()->compare('t.published', self::STATUS_YES);
		}
		return $this;
	}

	/**
	 * Get only visible models
	 *
	 * @return $this
	 */
	public function visible()
	{
		if ($this->hasAttribute('visible')) {
			$this->getDbCriteria()->compare('t.visible', self::STATUS_YES);
		}
		return $this;
	}

	/**
	 * Generate url
	 *
	 * @param array $url
	 * @param array $params
	 *
	 * @return array
	 */
	public static function createUrl($url = array(''), $params = array())
	{
		$url = (array)$url;
		unset($params[0]);
		foreach ($params as $key => $value) {
			$url[$key] = $value;
		}
		return $url;
	}

	/**
	 * Get attribute from related model first level
	 *
	 * @param $relation
	 * @param $attribute
	 *
	 * @return null
	 */
	public function getValue($relation, $attribute)
	{
		if (!$relation || !$attribute) {
			return null;
		}
		if (isset($this->$relation)) {
			if ($this->$relation) {
				if (isset($this->$relation->$attribute)) {
					if ($this->$relation->$attribute) {
						return $this->$relation->$attribute;
					}
				}
			}
		}
		return null;
	}

	/**
	 * @param bool $published
	 * @param bool $visible
	 * @param string $select
	 * @param array $with
	 * @param string $condition
	 * @param array $params
	 *
	 * @return static[]
	 */
	public static function getItems(
					$published = true,
					$visible = true,
					$select = '*',
					$with = array(),
					$condition = '',
					$params = array()
	)
	{
		// TODO: add caching
		$finder = static::model()->select($select)->ordered()->with($with);
		if ($published) {
			$finder->published();
		}
		if ($visible) {
			$finder->visible();
		}
		return $finder->findAll($condition, $params);
	}

	/**
	 * Return class name
	 *
	 * @return string
	 */
	public static function getClassName()
	{
		return get_called_class();
	}

	/**
	 * This method is invoked before validation starts.
	 * The default implementation calls {@link onBeforeValidate} to raise an event.
	 * You may override this method to do preliminary checks before validation.
	 * Make sure the parent implementation is invoked so that the event can be raised.
	 * @return boolean whether validation should be executed. Defaults to true.
	 * If false is returned, the validation will stop and the model is considered invalid.
	 */
	protected function beforeValidate()
	{
		if (parent::beforeValidate()) {
			if ($this->isNewRecord) {
				if ($this->hasAttribute('created')) {
					$this->created = time();
				}
			}
			if ($this->hasAttribute('modified')) {
				$this->modified = time();
			}
			return true;
		}
		return false;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return $this
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return bool
	 */
	public function loadData()
	{
		$modelName = \CHtml::modelName($this);
		if (isset($_POST[$modelName])) {
			$this->setAttributes($_POST[$modelName]);

			return true;
		}

		return false;
	}
}
