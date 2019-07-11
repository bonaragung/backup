<?php
/* @var $this BootcampController */
/* @var $model Bootcamp */
/* @var $form TbActiveForm */
?>

<!-- ------------------------NEW CODE----------------------------- -->
<style>
	.modal-body{
		height:250px;
	}
</style>
<!-- ------------------------NEW CODE----------------------------- -->

<?php
	// Check IE browser
	$msie = strpos($_SERVER["HTTP_USER_AGENT"], 'MSIE') ? true : false;
?>

<script type="text/javascript">
	$( document ).ready(function() {
		$("#addField").click(function (e) {
			<?php if ($msie) { ?>
				$('#party').append('<fieldset><p>Nama : <input id="auditor_name[]" class="span2" type="text" name="instruktur_name[]" value="" disabled="disabled"> Email : <input id="email[]" class="span2" type="text" name="email[]" value="" disabled="disabled"> Telp : <input id="telp[]" class="span2" type="text" name="telp[]" value="" disabled="disabled"> <button class="btn btn-danger removeParty" type="button"><i class="icon-remove-sign"></i> Remove</button> <a class="btn btn-success" href="#" onclick="$('+"'#cru-frame'"+').attr('+"'src'"+','+"'/ciqs-certification/instruktur/admin.html?asDialog=1&scenario=choose'"+'); $(this).addClass('+"'choose'"+'); $('+"'#cru-dialog'"+').dialog('+"'open'"+');"><i class="icon-plus-sign"></i>Choose an Instruktur</a><input id="instrukturs" class="instrukturs" type="hidden" name="instrukturs[]" value="" span="2"></p></fieldset>');
			<?php }else{ ?>
				$('#party').append('<fieldset><p>Nama : <input id="auditor_name[]" class="span2" type="text" name="instruktur_name[]" value="" disabled="disabled"> Email : <input id="email[]" class="span2" type="text" name="email[]" value="" disabled="disabled"> Telp : <input id="telp[]" class="span2" type="text" name="telp[]" value="" disabled="disabled"> <button class="btn btn-danger removeParty" type="button"><i class="icon-remove-sign"></i> Remove</button> <a class="btn btn-success" href="#" data-target="#modal" data-toggle="modal" onclick="$('+"'#new-cru-frame'"+').attr('+"'src'"+','+"'/ciqs-certification/instruktur/admin.html?asDialog=1&scenario=choose'"+'); $(this).addClass('+"'choose'"+')"><i class="icon-plus-sign"></i>Choose an Instruktur</a><input id="instrukturs" class="instrukturs" type="hidden" name="instrukturs[]" value="" span="2"></p></fieldset>');
			<?php } ?>
			var count = $('#count').html();
			$('#count').html(parseInt(count) + 1);
		});
		
		$('.removeParty').live('click', function (e) {
			if(confirm('remove this auditor?')){
				$( this ).closest( "fieldset" ).hide('slow', function(){ $( this ).closest( "fieldset" ).remove(); });
				var count = $('#count').html();
				$('#count').html(parseInt(count) - 1);
			}
		});
		
		$('.removePartyExist').live('click', function (e) {
			if(confirm('remove this auditor?')){
				$.post('<?php echo Yii::app()->createUrl('groupInstruktur/deleteGet'); ?>', {
						'id':$( this ).closest( "fieldset" ).find('input[name="id[]"][type=hidden]').val(),
					}, function(data) {
					}, 'html'
				);
				$( this ).closest( "fieldset" ).hide('slow', function(){ $( this ).closest( "fieldset" ).remove(); });
				var count = $('#count').html();
				$('#count').html(parseInt(count) - 1);
			}
		});
		
		$( "#bootcamp-form" ).submit(function( event ) {
			
			var ready = 1;
			
			$("#bootcamp-form :input").not("[type=submit],[type=button]").removeClass('error').each(function () {
				 if ($.trim($(this).val()).length == 0){
					  $(this).addClass('error');
					  ready = 0;
				 }
			});
			
			if(ready == 1){
				return true;
			}else{
				alert('Tidak boleh kosong');
				return false;
			}
		});
	});
	
</script>

<div class="form">

	<?php echo TbHtml::button(TbHtml::icon(TbHtml::ICON_PLUS_SIGN).' Add an Instruktur', array('color' => TbHtml::BUTTON_COLOR_SUCCESS,'id'=>'addField')); ?> Total Instruktur : <b><span id="count"><?php echo empty($modelGroupInstruktur) ? '1' : count($modelGroupInstruktur); ?></span></b>
    <br /><br />

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'bootcamp-form',
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

            <?php //echo $form->textFieldControlGroup($model,'tgl_mulai',array('span'=>5)); ?>
            <?php echo $form->labelEx($model,'tgl_mulai'); ?>
			<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
						'name'=>'tgl_mulai',
						'attribute'=>'tgl_mulai', // Model attribute filed which hold user input
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


            <?php //echo $form->textFieldControlGroup($model,'tgl_selesai',array('span'=>5)); ?>
            <?php echo $form->labelEx($model,'tgl_selesai'); ?>
			<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
					  'name'=>'tgl_selesai',
					  'attribute'=>'tgl_selesai', // Model attribute filed which hold user input
					  'model'=>$model,            // Model name
					  'language'=>'en',
					  'value'=>date('Y-m-d'),
					  'options'=>array(
							'showAnim'=>'slide',//'slide','fold','slideDown','fadeIn','blind','bounce','clip','drop'
							'dateFormat'=>'yy-mm-dd',//Date format 'mm/dd/yy','yy-mm-dd','d M, y','d MM, y','DD, d MM, yy'
						),
					)
			);?>
			<?php echo $form->error($model,'tgl_selesai'); ?>

            <?php echo $form->textFieldControlGroup($model,'lokasi',array('span'=>5,'maxlength'=>100)); ?>

            <?php //echo $form->textFieldControlGroup($model,'pengajuan',array('span'=>5,'maxlength'=>10)); ?>
            <?php echo $form->hiddenField($model,'pengajuan'); ?>

            <?php //echo $form->textFieldControlGroup($model,'updated',array('span'=>5)); ?>
			
            <?php //echo $form->textFieldControlGroup($model,'instruktur',array('span'=>5,'maxlength'=>10)); ?>
            
            <?php
				$createUrl = $this->createUrl('instruktur/admin',array("asDialog"=>1,"scenario"=>"choose"));
				// IE
				if ($msie) {
					$onclickCreate = array('onclick'=>"$('#cru-frame').attr('src','$createUrl '); $('#cru-dialog').dialog('open'); $(this).addClass('choose');", 'class' => 'btn btn-success');
				}else{
					$onclickCreate = array('onclick'=>"$('#new-cru-frame').attr('src','$createUrl '); $(this).addClass('choose');", 'data-toggle' => 'modal', 'data-target' => '#modal', 'class' => 'btn btn-success');
				}
				
				?><div id="party"><?php
				echo $form->labelEx($model,'groupInstruktur');
				if($model['scenario'] == 'insert' || ($model->isNewRecord && empty($modelGroupInstruktur))){
					?>
                    <fieldset>
                        <p>
                            Nama : <?php echo TbHtml::textField('instruktur_name[]','',array('span'=>2,'disabled'=>true)); ?>
                            Email : <?php echo TbHtml::textField('email[]','',array('span'=>2,'disabled'=>true)); ?>
                            Telp : <?php echo TbHtml::textField('telp[]','',array('span'=>2,'disabled'=>true)); ?>
                        </p>
                        <?php
							echo CHtml::link(TbHtml::icon(TbHtml::ICON_PLUS_SIGN).' Choose an Instruktur','#',$onclickCreate);
							echo CHtml::hiddenField('instrukturs[]','',array('class'=>'instrukturs','span'=>2));
						?>
                    </fieldset>
                    <?php
				}else{
					foreach($modelGroupInstruktur as $row){
						echo "<fieldset><p>";
						echo $form->hiddenField($row,'id',array('name'=>'id[]','span'=>'2'));
						echo "Nama : ".CHtml::textField('instruktur_name',$row->instruktur0->nama,array('id'=>'auditor_name','class'=>'span5','readonly'=>true));
						echo "Email : ".CHtml::textField('email',$row->instruktur0->email,array('id'=>'email','class'=>'span5','disabled'=>true));
						echo "Telp : ".CHtml::textField('telp',$row->instruktur0->telp,array('id'=>'telp','class'=>'span5','disabled'=>true));
						echo "</p>";
						echo $form->hiddenField($row,'instruktur',array('name'=>'instrukturs[]','class'=>'instrukturs','span'=>'2'));
						?> <button class="btn btn-danger removePartyExist" type="button"><i class="icon-remove-sign"></i> Remove</button>
                        <?php echo CHtml::link(TbHtml::icon(TbHtml::ICON_PLUS_SIGN).' Choose an Instruktur','#',$onclickCreate); ?>
						</fieldset>
                <?php
					}
				}
				?></div>

        <div class="form-actions">
        <?php echo TbHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array(
		    'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
		    'size'=>TbHtml::BUTTON_SIZE_LARGE,
		)); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->

<?php 
	$this->widget('bootstrap.widgets.TbModal', array(
		'id' => 'modal',
		'header' => 'Bootstrap Modal',
		'content' => '<iframe id="new-cru-frame" width="100%" height="100%" frameBorder="0"></iframe>',
	)); 
?>

<?php
//--------------------- begin new code --------------------------
   // add the (closed) dialog for the iframe
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'cru-dialog',
    'options'=>array(
        'title'=>'Jquery Modal',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>750,
        'height'=>400,
    ),
    ));
	?>
	<iframe id="cru-frame" width="100%" height="100%"></iframe>
	<?php
 
	$this->endWidget();
//--------------------- end new code --------------------------
?>