<?php
/* @var $this GroupInstrukturController */
/* @var $model GroupInstruktur */
?>

<?php
$this->breadcrumbs=array(
	'Group Instrukturs'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List GroupInstruktur', 'url'=>array('index')),
	array('label'=>'Create GroupInstruktur', 'url'=>array('create')),
	array('label'=>'Update GroupInstruktur', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete GroupInstruktur', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage GroupInstruktur', 'url'=>array('admin')),
);
?>

<h1>View GroupInstruktur #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView',array(
    'htmlOptions' => array(
        'class' => 'table table-striped table-condensed table-hover',
    ),
    'data'=>$model,
    'attributes'=>array(
		'id',
		'bootcamp',
		'instruktur',
		'updated',
	),
)); ?>