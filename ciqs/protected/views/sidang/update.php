<?php
/* @var $this SidangController */
/* @var $model Sidang */
?>

<?php
$this->breadcrumbs=array(
	'Sidangs'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Sidang', 'url'=>array('index')),
	array('label'=>'Create Sidang', 'url'=>array('create')),
	array('label'=>'View Sidang', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Sidang', 'url'=>array('admin')),
);
?>

    <h1>Update Sidang <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>