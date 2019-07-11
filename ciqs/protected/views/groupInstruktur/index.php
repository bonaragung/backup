<?php
/* @var $this GroupInstrukturController */
/* @var $dataProvider CActiveDataProvider */
?>

<?php
$this->breadcrumbs=array(
	'Group Instrukturs',
);

$this->menu=array(
	array('label'=>'Create GroupInstruktur','url'=>array('create')),
	array('label'=>'Manage GroupInstruktur','url'=>array('admin')),
);
?>

<h1>Group Instrukturs</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>