<?php
/* @var $this BootcampController */
/* @var $model Bootcamp */
?>

<?php
$this->breadcrumbs=array(
	'Bootcamps'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Bootcamp', 'url'=>array('index')),
	array('label'=>'Create Bootcamp', 'url'=>array('create')),
	array('label'=>'Update Bootcamp', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Bootcamp', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Bootcamp', 'url'=>array('admin')),
);
?>

<h1>View Bootcamp #<?php echo $model->id; ?></h1>

<?php if($model->start == 0 && Yii::app()->user->checkAccess("ADMIN MARKETING")){ 
		echo CHtml::link(TbHtml::icon(TbHtml::ICON_OK).' Start',array('startBootcamp','id'=>$model->id,'asDialog'=>1,'gridId'=>'pengajuan-grid','scenario'=>'startBootcamp'),array('class' => 'btn btn-success', 'confirm'=>'Sudah konfirmasi ke Mitra?'));
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
		'lokasi',
		//'pengajuan',
		'updated',
		array(            
            'name'=>'start',
            'type'=>'raw', //because of using html-code
            'value'=>$model->start == 1 ? TbHtml::labelTb("Ada", array("color" => TbHtml::LABEL_COLOR_SUCCESS)) : TbHtml::labelTb("Belum Ada", array("color" => TbHtml::LABEL_COLOR_WARNING)), //call this controller method for each row
        ),
	),
)); ?>

<h5>Instruktur</h5>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'group-instruktur-grid',
	'dataProvider'=>$modelGroupInstruktur,
	'type' => array(TbHtml::GRID_TYPE_BORDERED, TbHtml::GRID_TYPE_STRIPED, TbHtml::GRID_TYPE_HOVER, TbHtml::GRID_TYPE_CONDENSED),
	'columns'=>array(
		'id',
		//'bootcamp',
		//'instruktur',
		'instruktur0.nama',
		'instruktur0.telp',
		'instruktur0.email',
		//'updated',
	),
)); ?>