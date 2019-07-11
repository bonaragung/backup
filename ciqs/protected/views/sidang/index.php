<?php
/* @var $this SidangController */
/* @var $dataProvider CActiveDataProvider */
?>

<?php
$this->breadcrumbs=array(
	'Sidangs',
);

$this->menu=array(
	array('label'=>'Create Sidang','url'=>array('create')),
	array('label'=>'Manage Sidang','url'=>array('admin')),
);
?>

<h1>Sidangs</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>