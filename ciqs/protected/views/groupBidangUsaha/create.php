<?php
/* @var $this GroupBidangUsahaController */
/* @var $model GroupBidangUsaha */
?>

<?php
$this->breadcrumbs=array(
	'Group Bidang Usahas'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List GroupBidangUsaha', 'url'=>array('index')),
	array('label'=>'Manage GroupBidangUsaha', 'url'=>array('admin')),
);
?>

<h1>Create GroupBidangUsaha</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>