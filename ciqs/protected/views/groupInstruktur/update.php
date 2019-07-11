<?php
/* @var $this GroupInstrukturController */
/* @var $model GroupInstruktur */
?>

<?php
$this->breadcrumbs=array(
	'Group Instrukturs'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List GroupInstruktur', 'url'=>array('index')),
	array('label'=>'Create GroupInstruktur', 'url'=>array('create')),
	array('label'=>'View GroupInstruktur', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage GroupInstruktur', 'url'=>array('admin')),
);
?>

    <h1>Update GroupInstruktur <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>