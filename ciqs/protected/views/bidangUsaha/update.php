<?php
/* @var $this BidangUsahaController */
/* @var $model BidangUsaha */
?>

<?php
$this->breadcrumbs=array(
	'Bidang Usahas'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List BidangUsaha', 'url'=>array('index')),
	array('label'=>'Create BidangUsaha', 'url'=>array('create')),
	array('label'=>'View BidangUsaha', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage BidangUsaha', 'url'=>array('admin')),
);
?>

    <h1>Update BidangUsaha <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>