<?php
/* @var $this BidangUsahaController */
/* @var $model BidangUsaha */
?>

<?php
$this->breadcrumbs=array(
	'Bidang Usahas'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List BidangUsaha', 'url'=>array('index')),
	array('label'=>'Create BidangUsaha', 'url'=>array('create')),
	array('label'=>'Update BidangUsaha', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete BidangUsaha', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage BidangUsaha', 'url'=>array('admin')),
);
?>

<h1>View BidangUsaha #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView',array(
    'htmlOptions' => array(
        'class' => 'table table-striped table-condensed table-hover',
    ),
    'data'=>$model,
    'attributes'=>array(
		'id',
		'nama',
	),
)); ?>