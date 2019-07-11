<?php
/* @var $this AuditDokumenController */
/* @var $model AuditDokumen */
/* @var $form TbActiveForm */
?>

<div class="form">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'audit-dokumen-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

    <p class="help-block">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

            <?php //echo $form->textFieldControlGroup($model,'audit',array('span'=>5,'maxlength'=>10)); ?>

            <?php echo $form->textAreaControlGroup($model,'temuan',array('rows'=>3,'span'=>8)); ?>
            
            <?php //echo $form->textFieldControlGroup($model,'status_temuan',array('span'=>5,'maxlength'=>45)); ?>
            <?php echo $form->labelEx($model,'status_temuan'); ?>
        		<?php echo $form->radioButtonList($model,'status_temuan',array('MAYOR'=>'MAYOR','MINOR'=>'MINOR')); ?>
        	<?php echo $form->error($model,'status_temuan'); ?>
            
            <?php //echo $form->textFieldControlGroup($model,'tgl_penyelesaian',array('span'=>5)); ?>
            <?php echo $form->labelEx($model,'tgl_penyelesaian'); ?>
			<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
						'name'=>'tgl_mulai',
						'attribute'=>'tgl_penyelesaian', // Model attribute filed which hold user input
					  	'model'=>$model,            // Model name
					  	'language'=>'en',
					  	'value'=>date('Y-m-d'),
					  	'options'=>array(
							'showAnim'=>'slide',//'slide','fold','slideDown','fadeIn','blind','bounce','clip','drop'
							'dateFormat'=>'yy-mm-dd',//Date format 'mm/dd/yy','yy-mm-dd','d M, y','d MM, y','DD, d MM, yy'
						),
					  	'htmlOptions'=>array(
							'span'=>'5'
						),
					)
			);?>
			<?php echo $form->error($model,'tgl_mulai'); ?>

            <?php echo $form->textAreaControlGroup($model,'tindakan',array('rows'=>3,'span'=>8)); ?>

            <?php //echo $form->textFieldControlGroup($model,'updated',array('span'=>5)); ?>

            <?php echo $form->textAreaControlGroup($model,'evidence',array('rows'=>3,'span'=>8)); ?>

            <?php //echo $form->textFieldControlGroup($model,'status',array('span'=>5,'maxlength'=>10)); ?>
            <?php echo $form->labelEx($model,'status'); ?>
        		<?php echo $form->radioButtonList($model,'status',array('1'=>'OPEN','0'=>'CLOSED')); ?>
        	<?php echo $form->error($model,'status'); ?>

        <div class="form-actions">
        <?php echo TbHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array(
		    'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
		    'size'=>TbHtml::BUTTON_SIZE_LARGE,
		)); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->