<?php
/* @var $this AuditController */
/* @var $model Audit */
?>

<?php
$this->breadcrumbs=array(
	'Audits'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Audit', 'url'=>array('index')),
	array('label'=>'Create Audit', 'url'=>array('create')),
	array('label'=>'Update Audit', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Audit', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Audit', 'url'=>array('admin')),
);
?>

<h1>View Audit #<?php echo $model->id; ?></h1>

<?php if($model->start == 0 && Yii::app()->user->checkAccess("KORD. AUDITOR")){ 
		echo CHtml::link(TbHtml::icon(TbHtml::ICON_OK).' Start',array('startAudit','id'=>$model->id,'asDialog'=>1,'gridId'=>'pengajuan-grid','scenario'=>'startAudit'),array('class' => 'btn btn-success', 'confirm'=>'Sudah konfirmasi ke Mitra dan Auditor?'));
		?><br /><br />
<?php } ?>

<?php $this->widget('zii.widgets.CDetailView',array(
    'htmlOptions' => array(
        'class' => 'table table-striped table-condensed table-hover',
    ),
    'data'=>$model,
    'attributes'=>array(
		'id',
		'tgl_mulai',
		'tgl_selesai',
		//'pengajuan',
		'updated',
		array(            
            'name'=>'start',
            'type'=>'raw', //because of using html-code
            'value'=>$model->start == 1 ? TbHtml::labelTb("Ada", array("color" => TbHtml::LABEL_COLOR_SUCCESS)) : TbHtml::labelTb("Belum Ada", array("color" => TbHtml::LABEL_COLOR_WARNING)), //call this controller method for each row
        ),
	),
)); ?>

<h5>Auditor</h5>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'group-auditor-grid',
	'dataProvider'=>$modelGroupAudit,
	'type' => array(TbHtml::GRID_TYPE_BORDERED, TbHtml::GRID_TYPE_STRIPED, TbHtml::GRID_TYPE_HOVER, TbHtml::GRID_TYPE_CONDENSED),
	'columns'=>array(
		'id',
		//'audit',
		'auditor0.nama',
		'auditor0.telp',
		'auditor0.email',
		//'updated',
	),
)); ?>