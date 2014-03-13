<?php
/**
 * This is the template for generating a controller class file for CRUD feature.
 * The following variables are available in this template:
 * @var CrudCode $this: the CrudCode object
 */
?>
<?php echo "<?php\n"; ?>
/**
 *
 */

<?php if($namespace = $this->getNameSpace()): ?>
namespace <?php echo $namespace; ?>;
<?php endif; ?>

<?php if ($baseClassNamespace = $this->getBaseControllerClassNamespace()) : ?>
use <?php echo $baseClassNamespace; ?>;

<?php endif; ?>
/**
 * Class <?php echo $this->controllerClass, "\n"; ?>
 */
class <?php echo $this->controllerClass; ?> extends <?php echo $this->getBaseControllerClassWithoutNamespace(), "\n"; ?>
{
	public function getModelClass()
	{
		return '<?php echo $this->getModelClass(); ?>';
	}
}
