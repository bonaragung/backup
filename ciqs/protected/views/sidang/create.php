<?php
/* @var $this SidangController */
/* @var $model Sidang */
?>

<?php
$this->breadcrumbs=array(
	'Sidangs'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Sidang', 'url'=>array('index')),
	array('label'=>'Manage Sidang', 'url'=>array('admin')),
);
?>

<h1>Create Sidang</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>