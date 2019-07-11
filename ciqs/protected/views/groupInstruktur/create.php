<?php
/* @var $this GroupInstrukturController */
/* @var $model GroupInstruktur */
?>

<?php
$this->breadcrumbs=array(
	'Group Instrukturs'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List GroupInstruktur', 'url'=>array('index')),
	array('label'=>'Manage GroupInstruktur', 'url'=>array('admin')),
);
?>

<h1>Create GroupInstruktur</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>