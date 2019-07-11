<?php
/* @var $this GroupInstrukturController */
/* @var $data GroupInstruktur */
?>

<div class="view">

    	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('bootcamp')); ?>:</b>
	<?php echo CHtml::encode($data->bootcamp); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('instruktur')); ?>:</b>
	<?php echo CHtml::encode($data->instruktur); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('updated')); ?>:</b>
	<?php echo CHtml::encode($data->updated); ?>
	<br />


</div>