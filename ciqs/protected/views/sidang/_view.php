<?php
/* @var $this SidangController */
/* @var $data Sidang */
?>

<div class="view">

    	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pengajuan')); ?>:</b>
	<?php echo CHtml::encode($data->pengajuan); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tgl_sidang')); ?>:</b>
	<?php echo CHtml::encode($data->tgl_sidang); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hasil')); ?>:</b>
	<?php echo CHtml::encode($data->hasil); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('updated')); ?>:</b>
	<?php echo CHtml::encode($data->updated); ?>
	<br />


</div>