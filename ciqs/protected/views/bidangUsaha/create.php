<?php
/* @var $this BidangUsahaController */
/* @var $model BidangUsaha */
?>

<?php
$this->breadcrumbs=array(
	'Bidang Usahas'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List BidangUsaha', 'url'=>array('index')),
	array('label'=>'Manage BidangUsaha', 'url'=>array('admin')),
);
?>

<h1>Create BidangUsaha</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>