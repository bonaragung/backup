<?php
/* @var $this GroupBidangUsahaController */
/* @var $model GroupBidangUsaha */
?>

<?php
$this->breadcrumbs=array(
	'Group Bidang Usahas'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List GroupBidangUsaha', 'url'=>array('index')),
	array('label'=>'Create GroupBidangUsaha', 'url'=>array('create')),
	array('label'=>'Update GroupBidangUsaha', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete GroupBidangUsaha', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage GroupBidangUsaha', 'url'=>array('admin')),
);
?>

<h1>View GroupBidangUsaha #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView',array(
    'htmlOptions' => array(
        'class' => 'table table-striped table-condensed table-hover',
    ),
    'data'=>$model,
    'attributes'=>array(
		'id',
		'mitra',
		'bidang_usaha',
	),
)); ?>