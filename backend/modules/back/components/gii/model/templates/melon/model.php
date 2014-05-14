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

use back\helpers\GiiHelper;

$propertyColumns = $this->preparePropertyColumns($columns);
$searchColumns = $this->prepareSearchColumns($propertyColumns);

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
<?php foreach($relations as $name => $relation): ?>
			<?php echo "'$name' => $relation,\n"; ?>
<?php endforeach; ?>
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
<?php foreach($rules as $rule): ?>
			<?php echo $rule.",\n"; ?>
<?php endforeach; ?>
			// The following rule is used by search().
			array('<?php echo implode(', ', array_keys($searchColumns)); ?>', 'safe', 'on' => 'search', ),
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
<?php foreach($labels as $name => $label): ?>
				<?php echo "'$name' => '$label',\n"; ?>
<?php endforeach; ?>
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

<?php
foreach($searchColumns as $name => $column)
{
	if($column->type === 'string')
	{
		echo "\t\t\$criteria->compare('t.$name', \$this->$name, true);\n";
	}
	else
	{
		echo "\t\t\$criteria->compare('t.$name', \$this->$name);\n";
	}
}
?>

		return new \CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'pagination' => array(
				'pageSize' => $pageSize ? $pageSize : 50,
			),
			'sort' => array(
				'defaultOrder' => array(
<?php if (in_array('posted', array_keys($columns))) : ?>
					'posted' => \CSort::SORT_DESC,
<?php elseif (in_array('position', array_keys($columns))) : ?>
					'position' => \CSort::SORT_DESC,
<?php elseif (in_array('id', array_keys($columns))) : ?>
					'id' => \CSort::SORT_DESC,
<?php endif; ?>
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
		return parent::genAdminBreadcrumbs($page, $title ? $title : '<?php echo $modelClass; ?>');
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
<?php foreach(GiiHelper::getAdminPageTypes() as $page): ?>
			case '<?php echo $page; ?>':
				$columns = array(
<?php foreach($columns as $column): ?>
<?php $row = $this->generateViewRow($page, $column); ?>
<?php if($row): ?>
					<?php echo $row, "\n"; ?>
<?php endif; ?>
<?php endforeach; ?>
<?php if($page === 'index'): ?>
					array(
						'class' => 'bootstrap.widgets.TbButtonColumn',
					),
<?php endif; ?>
				);
				break;
<?php endforeach; ?>
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
<?php foreach($columns as $column): ?>
<?php $row = GiiHelper::generateFormRow($column); ?>
<?php if($row): ?>
				<?php echo $row, "\n"; ?>
<?php endif; ?>
<?php endforeach; ?>
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
<?php if (in_array('image_id', array_keys($columns))) :?>
					'b_image_id' => array(
						'class' => '\fileProcessor\components\FileUploadBehavior',
						'attributeName' => 'image_id',
						'fileTypes' => 'png, gif, jpeg, jpg',
					),
<?php endif; ?>
<?php if (in_array('file_id', array_keys($columns))) :?>
					'b_file_id' => array(
						'class' => '\fileProcessor\components\FileUploadBehavior',
						'attributeName' => 'file_id',
						'fileTypes' => 'png, gif, jpeg, jpg, doc, pdf, ppt, zip, rar',
					),
<?php endif; ?>
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
<?php endif; ?>
<?php if (in_array('posted', array_keys($columns))) :?>

	/**
	 * This method is invoked before validation starts.
	 * @return boolean whether validation should be executed. Defaults to true.
	 */
	protected function beforeValidate()
	{
		if (parent::beforeValidate()) {
			if (!$this->posted) {
				$this->posted = date('Y-m-d H:i:s');
			}
			return true;
		}
		return false;
	}
<?php endif; ?>
<?php if (in_array('posted', array_keys($columns))) : ?>

	/**
	 * Query default order
	 *
	 * @return $this
	 */
	public function ordered()
	{
		return $this->order('t.posted DESC');
	}
<?php elseif (in_array('id', array_keys($columns)) && !in_array('position', array_keys($columns))): ?>

	/**
	 * Query default order
	 *
	 * @return $this
	 */
	public function ordered()
	{
		return $this->order('t.id DESC');
	}
<?php elseif (!in_array('id', array_keys($columns))): ?>

	/**
	 * Query default order
	 *
	 * @return $this
	 */
	public function ordered()
	{
		return $this;
	}
<?php endif; ?>
<?php endif; ?>
}
