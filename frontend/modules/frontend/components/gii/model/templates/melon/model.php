<?php
/**
 * This is the template for generating the model class of a specified table.
 * @var ModelCode $this: the ModelCode object
 * @var string $tableName: the table name for this class (prefix is already removed if necessary)
 * @var string $modelClass: the model class name
 * @var CDbColumnSchema[] $columns: list of table columns (name=>CDbColumnSchema)
 * @var string[] $labels: list of attribute labels (name=>label)
 * @var array $rules: list of validation rules
 * @var array $relations: list of relations (name=>relation declaration)
 * @var string $connectionId
 */

?>
<?php echo "<?php\n"; ?>
/**
 *
 */

namespace <?php echo $this->getNameSpace(); ?>;

<?php if ($baseClassNamespace = $this->getBaseClassNamespace()) : ?>
use <?php echo $baseClassNamespace; ?>;

<?php endif; ?>
/**
 * This is the model class for table "<?php echo $tableName; ?>".
 *
 * The followings are the available columns in table '<?php echo $tableName; ?>':
<?php $propertyColumns = $this->preparePropertyColumns($columns); ?>
<?php foreach($propertyColumns as $column): ?>
 * @property <?php echo $column->type.' $'.$column->name."\n"; ?>
<?php endforeach; ?>
<?php if(!empty($relations) && !$this->langModel): ?>
 *
 * The followings are the available model relations:
<?php foreach($relations as $name=>$relation): ?>
 * @property <?php
	if (preg_match("~^array\(self::([^,]+), '([^']+)', '([^']+)'\)$~", $relation, $matches))
    {
        $relationType = $matches[1];
        $relationModel = $matches[2];

        switch($relationType){
            case 'HAS_ONE':
                echo $relationModel.' $'.$name."\n";
            break;
            case 'BELONGS_TO':
                echo $relationModel.' $'.$name."\n";
            break;
            case 'HAS_MANY':
                echo $relationModel.'[] $'.$name."\n";
            break;
            case 'MANY_MANY':
                echo $relationModel.'[] $'.$name."\n";
            break;
            default:
                echo 'mixed $'.$name."\n";
        }
	}
    ?>
<?php endforeach; ?>
<?php endif; ?>
 */
class <?php echo $modelClass; ?> extends <?php echo $this->getBaseClassWithoutNamespace()."\n"; ?>
{
<?php if ($connectionId!='db') : ?>
	/**
	 * @return CDbConnection the database connection used for this class
	 */
	public function getDbConnection()
	{
		return Yii::app()-><?php echo $connectionId ?>;
	}

<?php endif; ?>
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return <?php echo $modelClass; ?> the static model class
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
		return '<?php echo $tableName; ?>';
	}
<?php if (!$this->langModel) : ?>

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
<?php foreach($relations as $name=>$relation): ?>
			<?php echo "'$name' => $relation,\n"; ?>
<?php endforeach; ?>
		);
	}
<?php if ($this->rulesAndLabels) : ?>

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
<?php foreach($rules as $rule): ?>
			<?php echo $rule.",\n"; ?>
<?php endforeach; ?>
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('<?php echo implode(', ', array_keys($columns)); ?>', 'safe', 'on'=>'search', ),
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
<?php foreach($labels as $name=>$label): ?>
				<?php echo "'$name' => '$label',\n"; ?>
<?php endforeach; ?>
			)
		);
	}
<?php endif; ?>

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
<?php if ($this->seoModel) : ?>
				'seo' => array(
					'class' => '\seo\components\SeoModelBehavior',
				),
<?php endif; ?>
<?php if ($this->multiLang) : ?>
				'multiLang' => array(
					'class' => '\language\components\MultilingualBehavior',
					'localizedAttributes' => self::getLocalizedAttributesList(),
					'languages' => \language\helpers\Lang::getLanguageKeys(),
					'defaultLanguage' => \language\helpers\Lang::getDefault(),
					'forceOverwrite' => true,
				),
<?php endif; ?>
			)
		);
	}
<?php if ($this->multiLang) : ?>

	/**
	 * Get list of localized attributes
	 *
	 * @return array
	 */
	public static function getLocalizedAttributesList()
	{
		return array();
	}

	/**
	 * Return default query params
	 *
	 * @return array
	 */
	public function defaultScope()
	{
		$localized = $this->multiLang->localizedCriteria();
		return \CMap::mergeArray(
			parent::defaultScope(),
			$localized
		);
	}
<?php endif; ?>
<?php endif; ?>
}
