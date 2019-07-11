<?php
/* @var $this GroupBidangUsahaController */
/* @var $model GroupBidangUsaha */
?>

<?php
$this->breadcrumbs=array(
	'Group Bidang Usahas'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List GroupBidangUsaha', 'url'=>array('index')),
	array('label'=>'Create GroupBidangUsaha', 'url'=>array('create')),
	array('label'=>'View GroupBidangUsaha', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage GroupBidangUsaha', 'url'=>array('admin')),
);
?>

    <h1>Update GroupBidangUsaha <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>