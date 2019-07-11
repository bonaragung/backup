<?php
/* @var $this PengajuanController */
/* @var $model Pengajuan */
?>

<?php
$this->breadcrumbs=array(
	'Pengajuans'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Pengajuan', 'url'=>array('index')),
	array('label'=>'Create Pengajuan', 'url'=>array('create')),
	array('label'=>'Update Pengajuan', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Pengajuan', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Pengajuan', 'url'=>array('admin')),
);
?>

<h1>View Pengajuan #<?php echo $model->id; ?></h1>

<?php if($model->ajukan == 0 && Yii::app()->user->checkAccess("MITRA")){ 
		echo CHtml::link(TbHtml::icon(TbHtml::ICON_OK).' Ajukan',array('ajukanPengajuan','id'=>$model->id,'asDialog'=>1,'gridId'=>'pengajuan-grid','type'=>$type,),array('class' => 'btn btn-success', 'confirm'=>'Are you sure?'));
		?><br /><br />
<?php } ?>

<?php $this->widget('zii.widgets.CDetailView',array(
    'htmlOptions' => array(
        'class' => 'table table-striped table-condensed table-hover',
    ),
    'data'=>$model,
    'attributes'=>array(
		'id',
		//'mitra',
		'mitra0.nama:raw:Mitra',
		'type',
		//'status_bayar',
		array(            
            'name'=>'status_bayar',
            'type'=>'raw', //because of using html-code
            'value'=>$model->status_bayar==0 ? TbHtml::labelTb("Belum Bayar", array("color" => TbHtml::LABEL_COLOR_WARNING)) : TbHtml::labelTb("Sudah Bayar", array("color" => TbHtml::LABEL_COLOR_SUCCESS)), //call this controller method for each row
        ),
		//'bukti_bayar',
		array(            
            'name'=>'bukti_bayar',
            'type'=>'raw', //because of using html-code
            'value'=>!empty($model->bukti_bayar) ? TbHtml::labelTb("Ada", array("color" => TbHtml::LABEL_COLOR_SUCCESS)) : TbHtml::labelTb("Belum Ada", array("color" => TbHtml::LABEL_COLOR_WARNING)), //call this controller method for each row
        ),
		array(            
            'name'=>'ajukan',
            'type'=>'raw', //because of using html-code
            'value'=>$model->ajukan == 1 ? TbHtml::labelTb("Telah diajukan", array("color" => TbHtml::LABEL_COLOR_SUCCESS)) : TbHtml::labelTb("Belum Diajukan", array("color" => TbHtml::LABEL_COLOR_WARNING)), //call this controller method for each row
        ),
		array(
			'name'=>'bukti bayar', 
			'type'=>'raw', 
			'value'=>CHtml::link('download', array('buktiBayar','id'=>$model->id))
		),
		'updated',
        'tgl_pengajuan',
	),
)); ?>

<?php if($model->type == 'BOOTCAMP'){ ?>

<h5>Participants</h5>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'participant-grid',
	'dataProvider'=>$modelParticipant,
	'type' => array(TbHtml::GRID_TYPE_BORDERED, TbHtml::GRID_TYPE_STRIPED, TbHtml::GRID_TYPE_HOVER, TbHtml::GRID_TYPE_CONDENSED),
	'columns'=>array(
		'id',
		'nama',
		'telp',
		'email',
        'jabatan',
		//'updated',
	),
)); ?>

<?php } ?>