<?php
/* @var $this PengajuanController */
/* @var $model Pengajuan */


$this->breadcrumbs=array(
	'Pengajuan'=>array('index'),
	'Bootcamp'=>array('index'),
	'Audit'
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
	<legend>Detail Bootcamp</legend>
    <p>
    	<b>Mitra</b> : <?php echo $modelB->mitra0->nama; ?><br />
        <b>Lokasi</b> : <?php echo $modelB->bootcamps->lokasi; ?><br />
        <b>Tgl Mulai</b> : <?php echo $modelB->bootcamps->tgl_mulai; ?><br />
        <b>Tgl Selesai</b> : <?php echo $modelB->bootcamps->tgl_selesai; ?><br />
    </p>
</fieldset>

<h1>Pengajuan Audit</h1>

<!-- ------------------------NEW CODE----------------------------- -->
<?php
	// Check IE browser
	$msie = strpos($_SERVER["HTTP_USER_AGENT"], 'MSIE') ? true : false;
?>

<?php
	if(Yii::app()->user->checkAccess('MITRA') && empty($check)){
		echo "<span id='pengajuanAudit'>";
		echo CHtml::link(TbHtml::icon(TbHtml::ICON_PLUS_SIGN).' Add new pengajuan','#',array('onclick'=>'if(confirm("Are you sure?")){$.post("'.Yii::app()->createUrl('pengajuan/addAudit').'", {id:'.$model->parent.'}, function(data) {if(data=="success"){$.fn.yiiGridView.update("pengajuan-grid"); $("#pengajuanAudit").hide();}}, "html");} return false;', 'class' => 'btn btn-success'));
		?><br /><br /></span><?php
	}
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
	'id'=>'pengajuan-grid',
	'type' => array(TbHtml::GRID_TYPE_BORDERED, TbHtml::GRID_TYPE_STRIPED, TbHtml::GRID_TYPE_HOVER),
	'dataProvider'=>$model->searchAudit(),
	//'filter'=>$model,
	'columns'=>array(
		'id',
		//'mitra',
		'updated',
		'type',
		'audits.countParty:raw:Auditor',
		//'status_bayar',
		array(            
            'name'=>'status_bayar',
            'type'=>'raw', //because of using html-code
            'value'=>'$data->status_bayar==0 ? TbHtml::labelTb("Belum Bayar", array("color" => TbHtml::LABEL_COLOR_WARNING)) : TbHtml::labelTb("Sudah Bayar", array("color" => TbHtml::LABEL_COLOR_SUCCESS))', //call this controller method for each row
        ),
		//'bukti_bayar',
		array(            
            'name'=>'bukti_bayar',
            'type'=>'raw', //because of using html-code
            'value'=>'!empty($data->bukti_bayar) ? TbHtml::labelTb("Ada", array("color" => TbHtml::LABEL_COLOR_SUCCESS)) : TbHtml::labelTb("Belum Ada", array("color" => TbHtml::LABEL_COLOR_WARNING));', //call this controller method for each row
        ),
		array(            
            'name'=>'ajukan',
            'type'=>'raw', //because of using html-code
            'value'=>'$data->ajukan == 1 ? TbHtml::labelTb("Telah diajukan", array("color" => TbHtml::LABEL_COLOR_SUCCESS)) : TbHtml::labelTb("Belum Diajukan", array("color" => TbHtml::LABEL_COLOR_WARNING));', //call this controller method for each row
        ),
		array(            
            'name'=>'audits.start',
            'type'=>'raw', //because of using html-code
            'value'=>'$data->audits->start == 1 ? TbHtml::labelTb("Ada", array("color" => TbHtml::LABEL_COLOR_SUCCESS)) : TbHtml::labelTb("Belum Ada", array("color" => TbHtml::LABEL_COLOR_WARNING));', //call this controller method for each row
        ),
		array(            
            'name'=>'audits.laporkan',
            'type'=>'raw', //because of using html-code
            'value'=>'$data->audits->laporkan == 1 ? TbHtml::labelTb("Ada", array("color" => TbHtml::LABEL_COLOR_SUCCESS)) : TbHtml::labelTb("Belum Ada", array("color" => TbHtml::LABEL_COLOR_WARNING));', //call this controller method for each row
        ),
		array(
            'class'=>$buttonColumn,
			'template'=>"{isiLaporan}{changeStatus}{viewAudit}{addAudit}{editAudit}{upload}{view}{delete}",
			'htmlOptions' => array('style' => 'white-space: nowrap'),
			'afterDelete'=>'function(link,success,data){window.parent.$("#pengajuanAudit").show()}',
            //--------------------- begin new code --------------------------
			//$modelA->laporkan == 0 || ($modelA->laporkan == 1 && $modelA->sidang == 0 && !empty($modelA->sidang))
            'buttons'=>array(
						'isiLaporan'=>
                            array(
									'label'=>'Isi Laporan',
									'imageUrl'=>Yii::app()->request->baseUrl.'/images/page_edit.png',
									'url'=>'$this->grid->controller->createUrl("laporan", array("id"=>$data->primaryKey))',
									'visible'=>'Yii::app()->user->checkAccess("AUDITOR") || ($data->audits->laporkan == 1 && Yii::app()->user->checkAccess("KORD. AUDITOR") || Yii::app()->user->checkAccess("KORD. ARBITRASE"))',
                                ),
						'changeStatus'=>
                            array(
									'label'=>'Change Status',
									'imageUrl'=>Yii::app()->request->baseUrl.'/images/accept.png',
									'url'=>'$this->grid->controller->createUrl("update", array("id"=>$data->primaryKey,"asDialog"=>1,"gridId"=>$this->grid->id,"scenario"=>"changeStatusAudit"))',
									'visible'=>'!empty($data->bukti_bayar) && $data->status_bayar==0 && Yii::app()->user->checkAccess("KORD. AUDITOR")',
									'options' => array('confirm' => 'Are you sure?'),
                                ),
						'addAudit'=>
                            array(
									'label'=>'Create Audit',
									'imageUrl'=>Yii::app()->request->baseUrl.'/images/cup_add.png',
									'url'=>'$this->grid->controller->createUrl("audit/create", array("id"=>$data->primaryKey,"asDialog"=>1,"gridId"=>$this->grid->id))',
									'visible'=>'empty($data->audits) && !empty($data->bukti_bayar) && $data->status_bayar==1 && Yii::app()->user->checkAccess("KORD. AUDITOR")',
									'click'=>$updateClick,
									'options'=>$options,
                                ),
						'editAudit'=>
                            array(
									'label'=>'Update Audit',
									'imageUrl'=>Yii::app()->request->baseUrl.'/images/cup_edit.png',
									'url'=>'$this->grid->controller->createUrl("audit/update", array("id"=>$data->audits->id,"asDialog"=>1,"gridId"=>$this->grid->id))',
									'visible'=>'!empty($data->audits) && $data->audits->start == 0 && Yii::app()->user->checkAccess("KORD. AUDITOR")',
									'click'=>$updateClick,
									'options'=>$options,
                                ),
						'viewAudit'=>
                            array(
									'label'=>'View Audit',
									'imageUrl'=>Yii::app()->request->baseUrl.'/images/cup.png',
									'url'=>'$this->grid->controller->createUrl("audit/view", array("id"=>$data->audits->id,"asDialog"=>1,"gridId"=>$this->grid->id))',
									'visible'=>'!empty($data->audits)',
									'click'=>$updateClick,
									'options'=>$options,
                                ),
						'upload'=>
                            array(
									'label'=>'Upload',
									'imageUrl'=>Yii::app()->request->baseUrl.'/images/drive_go.png',
									'url'=>'$this->grid->controller->createUrl("update", array("id"=>$data->primaryKey,"asDialog"=>1,"gridId"=>$this->grid->id,"scenario"=>"upload"))',
                                    'click'=>$updateClick,
									'options'=>$options,
									'visible'=>'$data->ajukan == 1 && $data->status_bayar==0 && Yii::app()->user->checkAccess("MITRA")',
                                ),
						'view'=>
                            array(
                                    'url'=>'$this->grid->controller->createUrl("view", array("id"=>$data->primaryKey,"asDialog"=>1,"gridId"=>$this->grid->id,"type"=>"audit"))',
                                    'click'=>$viewClick,
									'options'=>$options,
                                ),
						'delete'=>
                            array(
									'visible'=>'$data->ajukan == 0 && Yii::app()->user->checkAccess("MITRA")',
                                ),
						
			),
            //--------------------- end new code --------------------------
        ),
	),
)); ?>

<div class="span12">
<div class="form span5">
    <h1>Sidang</h1>
	<?php if(!empty($sidang)){ ?>
        
        <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id'=>'sidang-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation'=>false,
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
    )); ?>
    
        <p class="help-block">Fields with <span class="required">*</span> are required.</p>
    
        <?php echo $form->errorSummary($modelSidang); ?>
    
                <?php //echo $form->textFieldControlGroup($modelSidang,'pengajuan',array('span'=>5,'maxlength'=>10)); ?>
    
                <?php //echo $form->textFieldControlGroup($modelSidang,'tgl_sidang',array('span'=>5)); ?>
                <?php echo $form->labelEx($modelSidang,'tgl_sidang'); ?>
                <?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                            'name'=>'tgl_mulai',
                            'attribute'=>'tgl_sidang', // Model attribute filed which hold user input
                            'model'=>$modelSidang,            // Model name
                            'language'=>'en',
                            'value'=>date('Y-m-d'),
                            'options'=>array(
                                'showAnim'=>'slide',//'slide','fold','slideDown','fadeIn','blind','bounce','clip','drop'
                                'dateFormat'=>'yy-mm-dd',//Date format 'mm/dd/yy','yy-mm-dd','d M, y','d MM, y','DD, d MM, yy'
                            ),
                            'htmlOptions'=>array(
                                'span'=>'5',
                                'disabled'=>($modelSidang->isNewRecord && !Yii::app()->user->checkAccess("KORD. ARBITRASE")) || $modelSidang->penerbitan == 1,
                            ),
                        )
                );?>
                <?php echo $form->error($modelSidang,'tgl_sidang'); ?>
                
                <p class="hint">
                    Note: Isi setelah sidang
                </p>
                <?php echo $form->textAreaControlGroup($modelSidang,'hasil',array('rows'=>6,'span'=>5, 'disabled'=>!Yii::app()->user->checkAccess("KORD. ARBITRASE") || $modelSidang->penerbitan == 1)); ?>
                
                <p class="hint">
                                Note: Isi setelah sidang
                            </p>
                <?php echo $form->labelEx($modelSidang,'upload_hasil'); ?>
                <?php echo CHtml::activeFileField($modelSidang, 'upload_hasil'); ?>
                <p class="hint">
                    Note: file upload must .pdf and max size 500kb.
                </p>
                <br><br>
                <?php //echo $form->textFieldControlGroup($modelSidang,'status',array('span'=>5,'maxlength'=>10)); ?>
                <p class="hint">
                    Note: Isi setelah sidang
                </p>
                <?php echo $form->LabelEx($modelSidang, 'status'); ?>
                <?php echo $form->dropDownList($modelSidang, 'status', array('1'=>'TIDAK LULUS','2'=>'LULUS'), array('empty'=>'-', 'disabled'=>!Yii::app()->user->checkAccess("KORD. ARBITRASE") || $modelSidang->penerbitan == 1)); ?>
    
                <?php //echo $form->textFieldControlGroup($modelSidang,'updated',array('span'=>5)); ?>

    <?php } else { ?>
    	Belum Tersedia
    <?php } ?>
</div><!-- form -->

<div class="form span3">
	<h1>Status Kelulusan</h1>
	<?php if(!empty($modelSidang->status)){ ?>
        <?php if($modelSidang->status == 2){ ?>
                <?php echo TbHtml::labelTb('<h1>LULUS</h1>', array('color' => TbHtml::LABEL_COLOR_SUCCESS)); ?>
        <?php }else if($modelSidang->status == 1){ ?>
                <?php echo TbHtml::labelTb('<h1>GAGAL</h1>', array('color' => TbHtml::LABEL_COLOR_INVERSE)); ?>
        <?php } ?>
    <?php } else {?>
    	Belum Tersedia
    <?php } ?>
</div><!-- form -->

<?php if($modelSidang->penerbitan == 1 && $modelSidang->status == 2){ ?>
    <div class="form span3">
        <h1>Sertifikat</h1>
    <?php //echo $form->LabelEx($modelSidang, 'status_sertifikat'); ?>
                    <?php echo $form->dropDownList($modelSidang, 'status_sertifikat', array('1'=>'DALAM PEMBUATAN','2'=>'TELAH DIKIRIM'), array('disabled'=>!Yii::app()->user->checkAccess("MGR. Q&A"))); ?>
    </div>
<?php } ?>

<div class="clear"></div>

<?php if(Yii::app()->user->checkAccess("KORD. ARBITRASE") || Yii::app()->user->checkAccess("MGR. Q&A")){?>
    <div class="form-actions">
    	<?php if(($modelSidang->penerbitan == 1 && Yii::app()->user->checkAccess("MGR. Q&A")) || ($modelSidang->penerbitan == 0 && !Yii::app()->user->checkAccess("MGR. Q&A"))) { ?>
			<?php echo TbHtml::submitButton($modelSidang->isNewRecord ? 'Create' : 'Save',array(
                'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
                'size'=>TbHtml::BUTTON_SIZE_LARGE,
                'class'=>'pull-left',
            )); ?>
        <?php } ?>
        <?php if($modelSidang->penerbitan == 0){ 
            echo CHtml::link(TbHtml::icon(TbHtml::ICON_OK).' Penerbitan sertifikat',array('audit','id'=>$modelB->id,'scenario'=>'penerbitan'),array('class' => 'btn btn-success btn-large pull-right', 'confirm'=>'Are you sure?'));
        } ?>
    </div>
<?php } ?>

<?php if(!empty($sidang)){ $this->endWidget(); } ?>
</div>

<?php 
	$this->widget('bootstrap.widgets.TbModal', array(
		'id' => 'modal',
		'header' => 'Bootstrap Modal',
		'content' => '<iframe id="new-cru-frame" width="100%" height="100%" frameBorder="0"></iframe>',
		//'htmlOptions' => array('class' => 'modal-sm')
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