<?php
/* @var $this GroupBidangUsahaController */
/* @var $dataProvider CActiveDataProvider */
?>

<?php
$this->breadcrumbs=array(
	'Group Bidang Usahas',
);

$this->menu=array(
	array('label'=>'Create GroupBidangUsaha','url'=>array('create')),
	array('label'=>'Manage GroupBidangUsaha','url'=>array('admin')),
);
?>

<h1>Group Bidang Usahas</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>