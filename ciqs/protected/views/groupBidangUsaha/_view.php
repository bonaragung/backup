<?php
/* @var $this GroupBidangUsahaController */
/* @var $data GroupBidangUsaha */
?>

<div class="view">

    	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mitra')); ?>:</b>
	<?php echo CHtml::encode($data->mitra); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('bidang_usaha')); ?>:</b>
	<?php echo CHtml::encode($data->bidang_usaha); ?>
	<br />


</div>