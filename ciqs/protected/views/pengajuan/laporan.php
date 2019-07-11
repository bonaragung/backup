<?php

$this->breadcrumbs=array(
	'Pengajuan'=>array('index'),
	'Bootcamp'=>array('index'),
	'Audit'=>array('audit','id'=>$model->parent),
	'Audit Document'
);

?>

<!-- ------------------------NEW CODE----------------------------- -->
<script>
	$(document).ready(function() {
		$('#modal').on('shown', function() {
			window.parent.$('body').css('overflow','hidden');
		});
		$('#modal').on('hidden', function () {
			window.parent.$('body').css('overflow','auto');
		});
	});
</script>

<style>
	.modal-body{
		height:550px;
	}
</style>
<!-- ------------------------NEW CODE----------------------------- -->

<fieldset>
	<legend>Detail Audit</legend>
    <p>
    	<?php
			echo 'Mitra : '.$model->mitra0->nama."<br>";
			echo 'Tgl Mulai : '.$model->audits->tgl_mulai."<br>";
			echo 'Tgl Selesai : '.$model->audits->tgl_selesai."<br>";
			echo 'Laporkan : ';
			echo $model->audits->laporkan == 1 ? TbHtml::labelTb("Ada", array("color" => TbHtml::LABEL_COLOR_SUCCESS)) : TbHtml::labelTb("Belum Ada", array("color" => TbHtml::LABEL_COLOR_WARNING));
			echo "<br>";
		?>
    </p>
</fieldset>

<h1>Laporan</h1>

<!-- ------------------------NEW CODE----------------------------- -->
<?php
	// Check IE browser
	$msie = strpos($_SERVER["HTTP_USER_AGENT"], 'MSIE') ? true : false;
?>

<?php
	if($modelA->laporkan == 0 && Yii::app()->user->checkAccess("AUDITOR")){
		$createUrl = $this->createUrl('auditDokumen/create',array("audit"=>$model->audits->id,"asDialog"=>1,"gridId"=>'audit-dokumen-grid'));
		// IE
		if ($msie) {
			$onclickCreate = array('onclick'=>"$('#cru-frame').attr('src','$createUrl '); $('#cru-dialog').dialog('open');", 'class' => 'btn btn-success');
		}else{
			$onclickCreate = array('onclick'=>"$('#new-cru-frame').attr('src','$createUrl ');", 'data-toggle' => 'modal', 'data-target' => '#modal', 'class' => 'btn btn-success');
		}
		echo CHtml::link(TbHtml::icon(TbHtml::ICON_PLUS_SIGN).' Add new item','#',$onclickCreate);
	}?><br /><br /><?php
?>

<?php
// IE
if ($msie) {
	$buttonColumn = 'CButtonColumn';
	$viewClick = 'function(){$("#cru-frame").attr("src",$(this).attr("href")); $("#cru-dialog").dialog("open");  return false;}';
	$updateClick = 'function(){$("#cru-frame").attr("src",$(this).attr("href")); $("#cru-dialog").dialog("open");  return false;}';
	$options = array();
}else{
	$buttonColumn = 'bootstrap.widgets.TbButtonColumn';
	$viewClick = 'function(){$("#new-cru-frame").attr("src",$(this).attr("href"));  return false;}';
	$updateClick = 'function(){$("#new-cru-frame").attr("src",$(this).attr("href"));  return false;}';
	$options = array('data-toggle' => 'modal', 'data-target' => '#modal');
}
?>
<!-- ------------------------NEW CODE----------------------------- -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'audit-dokumen-grid',
	'type' => array(TbHtml::GRID_TYPE_BORDERED, TbHtml::GRID_TYPE_STRIPED, TbHtml::GRID_TYPE_HOVER),
	'dataProvider'=>$modelAD->search(),
	//'filter'=>$modelAD,
	'columns'=>array(
		'id',
		//'audit',
		'temuan',
		//'status_temuan',
		array(            
            'name'=>'status_temuan',
            'type'=>'raw', //because of using html-code
            'value'=>'$data->status_temuan == "MAYOR" ? TbHtml::labelTb("MAYOR", array("color" => TbHtml::LABEL_COLOR_IMPORTANT)) : TbHtml::labelTb("MINOR", array("color" => TbHtml::LABEL_COLOR_INFO));', //call this controller method for each row
        ),
		//'tindakan',
		//'updated',
		//'evidence',
		//'tgl_penyelesaian',
		//'status',
		array(            
            'name'=>'status',
            'type'=>'raw', //because of using html-code
            'value'=>'$data->status == 1 ? TbHtml::labelTb("OPEN", array("color" => TbHtml::LABEL_COLOR_SUCCESS)) : TbHtml::labelTb("CLOSED");', //call this controller method for each row
        ),
		array(
            'class'=>$buttonColumn,
            //--------------------- begin new code --------------------------
            'buttons'=>array(
						'view'=>
                            array(
                                    'url'=>'$this->grid->controller->createUrl("auditDokumen/view", array("id"=>$data->primaryKey,"asDialog"=>1,"gridId"=>$this->grid->id))',
                                    'click'=>$viewClick,
									'options'=>$options,
                                ),
                        'update'=>
                            array(
                                    'url'=>'$this->grid->controller->createUrl("auditDokumen/update", array("id"=>$data->primaryKey,"asDialog"=>1,"gridId"=>$this->grid->id))',
                                    'click'=>$updateClick,
									'options'=>$options,
                                ),
						'delete'=>
                            array(
                                    'url'=>'$this->grid->controller->createUrl("auditDokumen/delete", array("id"=>$data->primaryKey,"asDialog"=>1,"gridId"=>$this->grid->id))',
									'visible'=>'$data->status == 1',
                                ),
			),
			'visible'=>($modelA->laporkan == 0 && Yii::app()->user->checkAccess("AUDITOR"))
            //--------------------- end new code --------------------------
        ),
	),
)); ?>

<div class="form">

<?php if($modelA->laporkan == 0 && Yii::app()->user->checkAccess("AUDITOR")){ ?>
    
        <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
            'id'=>'audit-form',
            // Please note: When you enable ajax validation, make sure the corresponding
            // controller action is handling ajax validation correctly.
            // There is a call to performAjaxValidation() commented in generated controller code.
            // See class documentation of CActiveForm for details on this.
            'enableAjaxValidation'=>false,
            'htmlOptions' => array('enctype' => 'multipart/form-data'),
        )); ?>
            
            <?php echo $form->labelEx($modelA,'upload_temuan'); ?>
            <?php echo CHtml::activeFileField($modelA, 'upload_temuan'); ?>
            <?php 
                if(!empty($modelA->upload_temuan)){
                    echo 'Ada Temuan';
                } 
            ?>
            <p class="hint">
                Note: file upload must .pdf and max size 500kb.
            </p>
            <br>
            
            <?php echo $form->textAreaControlGroup($modelA,'kesimpulan',array('rows'=>3,'span'=>12)); ?>
            
            <?php echo $form->textAreaControlGroup($modelA,'saran_rekomendasi',array('rows'=>3,'span'=>12)); ?>
            
            <div class="form-actions">
                <?php echo TbHtml::submitButton($modelA->isNewRecord ? 'Create' : 'Save',array(
                    'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
                    'size'=>TbHtml::BUTTON_SIZE_LARGE,
                )); ?>
                <?php
                    echo CHtml::link(TbHtml::icon(TbHtml::ICON_OK).' Laporkan',array('laporan','id'=>$model->id,'scenario'=>'laporkan'),array('class' => 'btn btn-success btn-large pull-right', 'confirm'=>'Are you sure?'));
                ?>
            </div>
        
        <?php $this->endWidget(); ?>

<?php }else{ ?>
        <?php echo TbHtml::Label('Upload Temuan',''); ?>
        <?php 
            if(!empty($modelA->upload_temuan)){
                echo 'Ada Temuan';
            } 
        ?>
        <br><br>
		<?php echo TbHtml::label('Kesimpulan',''); ?>
        <?php echo TbHtml::textAreaControlGroup('',$modelA->kesimpulan,array('rows'=>3,'span'=>12,'disabled'=>true)); ?>
        <?php echo TbHtml::label('Saran & Rekomendasi',''); ?>
        <?php echo TbHtml::textAreaControlGroup('',$modelA->saran_rekomendasi,array('rows'=>3,'span'=>12,'disabled'=>true)); ?>
        
        <?php if($modelA->laporkan == 1 && $modelA->sidang != 1 && Yii::app()->user->checkAccess("KORD. AUDITOR")) { ?>
            <div class="form-actions">
                <?php
                    echo CHtml::link(TbHtml::icon(TbHtml::ICON_THUMBS_DOWN).' Tolak',array('laporan','id'=>$model->id,'scenario'=>'tolakLaporan'),array('class' => 'btn btn-warning btn-large pull-left', 'confirm'=>'Are you sure?'));
                ?>
                <?php
                    echo CHtml::link(TbHtml::icon(TbHtml::ICON_THUMBS_UP).' Terima & Sidang',array('laporan','id'=>$model->id,'scenario'=>'terimaLaporan'),array('class' => 'btn btn-success btn-large pull-right', 'confirm'=>'Are you sure?'));
                ?>
            </div>
        <?php } ?>
<?php } ?>

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