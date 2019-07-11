<?php
/* @var $this SidangController */
/* @var $model Sidang */
?>

<?php
$this->breadcrumbs=array(
	'Sidangs'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Sidang', 'url'=>array('index')),
	array('label'=>'Create Sidang', 'url'=>array('create')),
	array('label'=>'Update Sidang', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Sidang', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Sidang', 'url'=>array('admin')),
);
?>

<h1>View Sidang #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView',array(
    'htmlOptions' => array(
        'class' => 'table table-striped table-condensed table-hover',
    ),
    'data'=>$model,
    'attributes'=>array(
		'id',
		'pengajuan',
		'tgl_sidang',
		'hasil',
		'status',
		'updated',
	),
)); ?>