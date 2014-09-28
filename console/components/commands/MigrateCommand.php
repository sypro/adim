<?php
/**
 * EMigrateCommand manages the database migrations.
 *
 * This class is an extension to yiis db migration command.
 *
 * It adds the following features:
 *  - module support
 *    you can create migrations in different modules
 *    so you are able to disable modules and also having their
 *    database tables removed/never set up
 *    yiic migrate to m000000_000000 --module=examplemodule
 *
 *  - module dependencies (planned, not yet implemented)
 *
 * @link http://www.yiiframework.com/extension/extended-database-migration/
 * @link http://www.yiiframework.com/doc/guide/1.1/en/database.migration
 * @author Carsten Brandt <mail@cebe.cc>
 * @version 0.8.0-dev
 */

namespace console\components\commands;

\Yii::import('system.cli.commands.MigrateCommand');

/**
 * EMigrateCommand manages the database migrations.
 *
 * @property array|null $modulePaths list of all modules
 * @property array $enabledModulePaths list of all enabled modules
 * @property array $disabledModules list of all disabled modules names
 *
 * @author Carsten Brandt <mail@cebe.cc>
 * @version 0.7.1
 */
class MigrateCommand extends \MigrateCommand
{
	/**
	 * @var string|null the current module(s) to use for current command (comma separated list)
	 * defaults to null which means all modules are used
	 * examples:
	 * --module=core
	 * --module=core,user,admin
	 */
	public $module;

	/**
	 * create a language model
	 *
	 * @var bool
	 */
	public $lang = false;

	/**
	 * @var string the application core is handled as a module named 'core' by default
	 */
	public $applicationModuleName = 'core';

	/**
	 * @var string delimiter for modulename and migration name for display
	 */
	public $moduleDelimiter = ': ';

	/**
	 * @var string subdirectory to use for migrations in Yii alias format
	 * this is only used if you do not set modulePath explicitly {@see setModulePaths()}
	 */
	public $migrationSubPath = 'migrations';

	/**
	 * @var array|null list of all modules
	 * @see getModulePaths()
	 * @see setModulePaths()
	 */
	private $_modulePaths = null;

	/**
	 * @var null
	 */
	private $_runModulePaths = null; // modules for current run

	/**
	 * @var array
	 * @see getDisabledModules()
	 * @see setDisabledModules()
	 */
	private $_disabledModules = array();

	/**
	 * set to not add modules when getHistory is called for getNewMigrations
	 */
	private $_scopeNewMigrations = false;

	/**
	 * @var bool
	 */
	private $_scopeAddModule = true;

	/**
	 * @return array list of all modules
	 */
	public function getModulePaths()
	{
		if ($this->_modulePaths === null) {
			$this->_modulePaths = array();
			foreach (\Yii::app()->modules as $module => $config) {
				if (is_array($config)) {
					$alias = 'application.modules.' . $module . '.' . ltrim($this->migrationSubPath, '.');
					if (isset($config['class'])) {
						\Yii::setPathOfAlias(
							$alias,
							dirname(\Yii::getPathOfAlias($config['class'])) . '/' .
							str_replace('.', '/', ltrim($this->migrationSubPath, '.'))
						);
					} elseif (isset($config['basePath'])) {
						\Yii::setPathOfAlias(
							$alias,
							$config['basePath'] . '/' .
							str_replace('.', '/', ltrim($this->migrationSubPath, '.'))
						);
					}
					$this->_modulePaths[$module] = $alias;
					$path = \Yii::getPathOfAlias($alias);
					if ($path === false || !is_dir($path)) {
						$this->_disabledModules[] = $module;
					}
				} else {
					$this->_modulePaths[$config] = 'application.modules.' . $config . '.' . ltrim(
							$this->migrationSubPath,
							'.'
						);
				}
			}
		}
		// add a pseudo-module 'core'
		$this->_modulePaths[$this->applicationModuleName] = $this->migrationPath;
		$path = \Yii::getPathOfAlias($this->migrationPath);
		if ($path === false || !is_dir($path)) {
			$this->_disabledModules[] = $this->applicationModuleName;
		}

		return $this->_modulePaths;
	}

	/**
	 * @var array|null list of all modules
	 * If set to null, which is default, yii applications module config will be used
	 * If modules are taken from yii application config, all entries will be
	 * 'moduleName' => 'application.modules.<moduleName>.migrations',
	 * You can change the subpath name by setting {@see migrationSubPath} which is 'migrations' per default.
	 * If 'class' or 'basePath' are set in module config the above path alias is
	 * adjusted to class/basePath with {@see \Yii::setPathOfAlias()}.
	 *
	 * example:
	 * array(
	 *      'moduleName' => 'application.modules.moduleName.db.migrations',
	 * )
	 */
	public function setModulePaths($modulePaths)
	{
		$this->_modulePaths = $modulePaths;
	}

	/**
	 * @return array list of all disabled modules names
	 */
	public function getDisabledModules()
	{
		// make sure modules are initialized
		$this->getModulePaths();
		foreach ($this->_disabledModules as $module) {
			if (!array_key_exists($module, $this->modulePaths)) {
				unset($this->_disabledModules[$module]);
			}
		}

		return array_unique($this->_disabledModules);
	}

	/**
	 * @param array $modules list of all disabled modules names
	 * you can add modules here to temporarily disable them
	 * array(
	 *      'examplemodule1',
	 *      'examplemodule2',
	 *      ...
	 * )
	 */
	public function setDisabledModules($modules)
	{
		$this->_disabledModules = is_array($modules) ? $modules : array();
	}

	/**
	 * @return array list of all enabled modules
	 */
	public function getEnabledModulePaths()
	{
		$modules = $this->getModulePaths();
		foreach ($this->getDisabledModules() as $module) {
			unset($modules[$module]);
		}

		return $modules;
	}

	/**
	 * prepare paths before any action
	 *
	 * @param $action
	 * @param $params
	 *
	 * @return bool
	 */
	public function beforeAction($action, $params)
	{
		$tmpMigrationPath = $this->migrationPath;
		$this->migrationPath = 'application';
		if (parent::beforeAction($action, $params)) {
			$this->migrationPath = $tmpMigrationPath;

			echo "Active database component (connectionString):\n    " . \Yii::app(
				)->{$this->connectionID}->connectionString . "\n\n";

			// check --module parameter
			if ($action == 'create' && !is_null($this->module)) {
				$this->usageError('create command can not be called with --module parameter!');
			}
			if (!is_null($this->module) && !is_string($this->module)) {
				$this->usageError(
					'parameter --module must be a comma seperated list of modules or a single module name!'
				);
			}

			// inform user about disabled modules
			if (!empty($this->disabledModules)) {
				echo "The following modules are disabled: " . implode(', ', $this->disabledModules) . "\n";
			}

			// only add modules that are desired by command
			$modules = false;
			if ($this->module !== null) {
				$modules = explode(',', $this->module);

				// error if specified module does not exist
				foreach ($modules as $module) {
					if (in_array($module, $this->disabledModules)) {
						echo "\nError: module '$module' is disabled!\n\n";
						exit(1);
					}
					if (!isset($this->enabledModulePaths[$module])) {
						echo "\nError: module '$module' is not available!\n\n";
						exit(1);
					}
				}
				echo "Current call is limited to module" . (count($modules) > 1 ? "s" : "") . ": " . implode(
						', ',
						$modules
					) . "\n";
			}
			echo "\n";

			// initialize modules
			foreach ($this->getEnabledModulePaths() as $module => $pathAlias) {
				if ($modules === false || in_array($module, $modules)) {
					\Yii::import($pathAlias . '.*');
					$this->_runModulePaths[$module] = $pathAlias;
				}
			}

			return true;
		}

		return false;
	}

	/**
	 * @param $args
	 *
	 * @return int
	 */
	public function actionCreate($args)
	{
		// if module is given adjust path
		if (count($args) == 2) {
			if (!isset($this->modulePaths[$args[0]])) {
				echo "\nError: module '{$args[0]}' is not available!\n\n";

				return 1;
			}
			$this->migrationPath = \Yii::getPathOfAlias($this->modulePaths[$args[0]]);
			$args = array($args[1]);
		} else {
			$this->migrationPath = \Yii::getPathOfAlias($this->modulePaths[$this->applicationModuleName]);
		}
		if (!is_dir($this->migrationPath)) {
			echo "\nError: '{$this->migrationPath}' does not exist or is not a directory!\n\n";

			return 1;
		}

		if (isset($args[0])) {
			$name = $args[0];
		} else {
			$this->usageError('Please provide the name of the new migration.');
			return 1;
		}

		if (!preg_match('/^\w+$/', $name)) {
			echo "Error: The name of the migration must contain letters, digits and/or underscore characters only.\n";

			return 1;
		}

		$tableName = self::prompt('Migration table name (without prefix):');

		$time = time();
		$className = 'm' . gmdate('ymd_His', $time) . '_' . $name;
		$content = strtr($this->getTemplate($tableName), array('{ClassName}' => $className));
		$file = $this->migrationPath . DIRECTORY_SEPARATOR . $className . '.php';

		if ($this->confirm("Create new migration '{$file}'?")) {
			file_put_contents($file, $content);
			echo "New migration created successfully.\n";
			if ($this->lang === true) {
				$className = 'm' . gmdate('ymd_His', $time + 1) . '_' . $name . '_lang';
				$content = strtr($this->getTemplate($tableName, true), array('{ClassName}' => $className));
				$file = $this->migrationPath . DIRECTORY_SEPARATOR . $className . '.php';
				file_put_contents($file, $content);
				echo "New migration for language model created successfully.\n";
			}
		}

		return true;
	}

	/**
	 * @param $args
	 *
	 * @return int
	 */
	public function actionUp($args)
	{
		$this->_scopeAddModule = true;
		$exitCode = parent::actionUp($args);
		$this->_scopeAddModule = false;

		return $exitCode;
	}

	/**
	 * @param $args
	 *
	 * @return int
	 */
	public function actionDown($args)
	{
		$this->_scopeAddModule = true;
		$exitCode = parent::actionDown($args);
		$this->_scopeAddModule = false;

		return $exitCode;
	}

	/**
	 * @param $args
	 *
	 * @return int
	 */
	public function actionTo($args)
	{
		$this->_scopeAddModule = false;
		$exitCode = parent::actionTo($args);
		$this->_scopeAddModule = true;

		return $exitCode;
	}

	/**
	 * @param $args
	 *
	 * @return int
	 */
	public function actionMark($args)
	{
		// migrations that need to be updated after command
		$migrations = $this->getNewMigrations();

		// run mark action
		$this->_scopeAddModule = false;
		$exitCode = parent::actionMark($args);
		$this->_scopeAddModule = true;

		// update migration table with modules
		/** @var \CDbCommand $command */
		$command = $this->getDbConnection()->createCommand()
			->select('version')
			->from($this->migrationTable)
			->where('module IS NULL');

		foreach ($command->queryColumn() as $version) {
			$module = null;
			foreach ($migrations as $migration) {
				list($module, $migration) = explode($this->moduleDelimiter, $migration);
				if ($migration == $version) {
					break;
				}
			}

			$this->ensureBaseMigration($module);

			$this->getDbConnection()->createCommand()->update(
				$this->migrationTable,
				array('module' => $module),
				'version=:version',
				array(':version' => $version)
			);
		}

		return $exitCode;
	}

	/**
	 * @return array
	 */
	protected function getNewMigrations()
	{
		$this->_scopeNewMigrations = true;
		$migrations = array();
		// get new migrations for all new modules
		foreach ($this->_runModulePaths as $module => $path) {
			$this->migrationPath = \Yii::getPathOfAlias($path);
			foreach (parent::getNewMigrations() as $migration) {
				if ($this->_scopeAddModule) {
					$migrations[$migration] = $module . $this->moduleDelimiter . $migration;
				} else {
					$migrations[$migration] = $migration;
				}
			}
		}
		$this->_scopeNewMigrations = false;

		ksort($migrations);

		return array_values($migrations);
	}

	/**
	 * @param $limit
	 *
	 * @return array
	 */
	protected function getMigrationHistory($limit)
	{
		/** @var \CDbConnection $db */
		$db = $this->getDbConnection();

		// avoid getTable trying to hit a db cache and die in endless loop
		$db->schemaCachingDuration = 0;
		\Yii::app()->coreMessages->cacheID = false;

		$this->getDbConnection()->schema->refresh();
		if ($db->schema->getTable($this->migrationTable) === null) {
			echo 'Creating migration history table "' . $this->migrationTable . '"...';
			$db->createCommand()->createTable(
				$this->migrationTable,
				array(
					'version' => 'string NOT NULL PRIMARY KEY',
					'apply_time' => 'integer',
					'module' => 'VARCHAR(32) NOT NULL DEFAULT ""',
				)
			);
			echo "done.\n";
		} elseif (!in_array('module', array_keys($this->getDbConnection()->schema->getTable($this->migrationTable)->columns))) {
			$this->getDbConnection()->createCommand(
				$this->getDbConnection()->schema->addColumn($this->migrationTable, 'module', 'VARCHAR(32) NOT NULL DEFAULT ""')
			)->execute();
		}

		if ($this->_scopeNewMigrations || !$this->_scopeAddModule) {
			$select = "version AS version_name, apply_time";
			$params = array();
		} else {
			/*
			 * switch concat functions for different db systems
			 * please let me know if your system is not switched
			 * correctly here. File a bug here:
			 * https://github.com/yiiext/migrate-command/issues
			 */
			switch ($db->getDriverName()) {
				case 'mysql':
					$select = "CONCAT(module, :delimiter, version) AS version_name, apply_time";
					break;
				case 'mssql': // http://msdn.microsoft.com/en-us/library/aa276862%28v=sql.80%29.aspx
				case 'sqlsrv':
				case 'cubrid': // http://www.cubrid.org/manual/840/en/Concatenation%20Operator
					$select = "(module + :delimiter + version) AS version_name, apply_time";
					break;
				default: // SQL-ANSI default: sqlite, firebird, ibm, informix, oci, pgsql, sqlite, sqlite2
					// not sure what to do with odbc
					$select = "(module || :delimiter || version) AS version_name, apply_time";
			}
			$params = array(':delimiter' => $this->moduleDelimiter);
		}

		/** @var \CDbCommand $command */
		$command = $db->createCommand()
			->select($select)
			->from($this->migrationTable)
			->order('version DESC')
			->limit($limit);

		if (!is_null($this->module)) {
			$criteria = new \CDbCriteria();
			$criteria->addInCondition('module', explode(',', $this->module));
			$command->where = $criteria->condition;
			$params += $criteria->params;
		}

		return \CHtml::listData($command->queryAll(true, $params), 'version_name', 'apply_time');
	}

	/**
	 * create base migration for module if none exists
	 *
	 * @param $module
	 *
	 * @return void
	 */
	protected function ensureBaseMigration($module)
	{
		$baseName = self::BASE_MIGRATION . '_' . $module;
		/** @var \CDbConnection $db */
		$db = $this->getDbConnection();
		if (!$db->createCommand()->select('version')
			->from($this->migrationTable)
			->where('module=:module AND version=:version')
			->queryRow(true, array(':module' => $module, 'version' => $baseName))
		) {
			$db->createCommand()->insert(
				$this->migrationTable,
				array(
					'version' => $baseName,
					'apply_time' => time(),
					'module' => $module,
				)
			);
		}
	}

	/**
	 * @param $class
	 *
	 * @return bool
	 */
	protected function migrateUp($class)
	{
		$module = $this->applicationModuleName;
		// remove module if given
		if (($pos = mb_strpos($class, $this->moduleDelimiter)) !== false) {
			$module = mb_substr($class, 0, $pos);
			$class = mb_substr($class, $pos + mb_strlen($this->moduleDelimiter));
		}

		$this->ensureBaseMigration($module);

		if (mb_strpos($class, self::BASE_MIGRATION) === 0) {
			return false;
		}
		if (($ret = parent::migrateUp($class)) !== false) {
			// add module information to migration table
			$this->getDbConnection()->createCommand()->update(
				$this->migrationTable,
				array('module' => $module),
				'version=:version',
				array(':version' => $class)
			);
		}

		return $ret;
	}

	/**
	 * @param $class
	 *
	 * @return \CDbMigration
	 */
	protected function instantiateMigration($class)
	{
		require_once($class . '.php');
		/** @var \CDbMigration $migration */
		$migration=new $class;
		$migration->setDbConnection($this->getDbConnection());
		return $migration;
	}

	/**
	 * @param $class
	 *
	 * @return bool
	 */
	protected function migrateDown($class)
	{
		// remove module if given
		if (($pos = mb_strpos($class, $this->moduleDelimiter)) !== false) {
			$class = mb_substr($class, $pos + mb_strlen($this->moduleDelimiter));
		}

		if (mb_strpos($class, self::BASE_MIGRATION) !== 0) {
			return parent::migrateDown($class);
		}
		return false;
	}

	/**
	 * @return string
	 */
	public function getHelp()
	{
		return parent::getHelp() . <<<EOD

EXTENDED USAGE EXAMPLES (with modules)
  for every action except create you can specify the modules to use
  with the parameter --module=<moduleNames>
  where <moduleNames> is a comma separated list of module names (or a single name)

 * yiic migrate create moduleName create_user_table
   Creates a new migration named 'create_user_table' in module 'moduleName'.

  all other commands work exactly as described above.

EOD;
	}

	/**
	 * @param string $tableName
	 * @param bool $lang
	 *
	 * @return string
	 */
	protected function getTemplate($tableName = '', $lang = false)
	{
		if ($this->templateFile !== null) {
			return file_get_contents(\Yii::getPathOfAlias($this->templateFile) . '.php');
		} elseif ($lang) {
			$relatedTableName = $tableName;
			if ($tableName) {
				$tableName .= '_lang';
			}
			return <<<EOD
<?php

/**
 * Class {ClassName}
 */
class {ClassName} extends \\CDbMigration
{
	/**
	 * migration related table name
	 */
	public \$tableName = '{{{$tableName}}}';

	/**
	 * main table name, to make constraints
	 */
	public \$relatedTableName = '{{{$relatedTableName}}}';

	/**
	 * commands will be executed in transaction
	 */
	public function safeUp()
	{
		\$this->createTable(
			\$this->tableName,
			array(
				'l_id' => 'INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT',
				'model_id' => 'INT UNSIGNED NOT NULL',
				'lang_id' => 'VARCHAR(5) NULL DEFAULT NULL',

				// examples:
				//'l_label' => 'VARCHAR(200) NULL DEFAULT NULL',
				//'l_announce' => 'TEXT NULL DEFAULT NULL',
				//'l_content' => 'TEXT NULL DEFAULT NULL',

				'INDEX key_model_id_lang_id (model_id, lang_id)',
				'INDEX key_model_id (model_id)',
				'INDEX key_lang_id (lang_id)',

				'CONSTRAINT fk_{$tableName}_model_id_to_main_model_id FOREIGN KEY (model_id) REFERENCES ' . \$this->relatedTableName . ' (id) ON DELETE CASCADE ON UPDATE CASCADE',
				'CONSTRAINT fk_{$tableName}_lang_id_to_language_id FOREIGN KEY (lang_id) REFERENCES {{language}} (code) ON DELETE RESTRICT ON UPDATE CASCADE',
			),
			'ENGINE=InnoDB DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci'
		);
	}

	/**
	 * commands will be executed in transaction
	 */
	public function safeDown()
	{
		\$this->dropTable(\$this->tableName);
	}
}

EOD;
		} else {
			return <<<EOD
<?php

/**
 * Class {ClassName}
 */
class {ClassName} extends \\CDbMigration
{
	/**
	 * migration related table name
	 */
	public \$tableName = '{{{$tableName}}}';

	/**
	 * commands will be executed in transaction
	 */
	public function safeUp()
	{
		\$this->createTable(
			\$this->tableName,
			array(
				'id' => 'INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT',

				'label' => 'VARCHAR(200) NULL DEFAULT NULL COMMENT "Заголовок"',

				'visible' => 'TINYINT(1) UNSIGNED NOT NULL DEFAULT 1',
				'published' => 'TINYINT(1) UNSIGNED NOT NULL DEFAULT 1',
				'position' => 'INT UNSIGNED NOT NULL DEFAULT 0',
				'created' => 'INT UNSIGNED NOT NULL',
				'modified' => 'INT UNSIGNED NOT NULL',
			),
			'ENGINE=InnoDB DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci'
		);
	}

	/**
	 * commands will be executed in transaction
	 */
	public function safeDown()
	{
		/*
		uncomment if you need to drop table or delete this lines
		\$this->dropTable(\$this->tableName);
		*/
	}
}

EOD;
		}
	}
}
