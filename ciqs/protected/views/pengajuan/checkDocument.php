<?php
$this->breadcrumbs=array(
	'Pengajuan'=>array('index'),
	'Bootcamp'=>array('index'),
	'Check Dokumen',
);

?>

<h1>Check Bootcamp Dokumen</h1>

<fieldset>
	<legend>Detail Bootcamp</legend>
    <p>
    	<?php
			echo "<b>Tanggal Mulai</b> : ".$bootcamp->tgl_mulai."<br>";
			echo "<b>Tanggal Selesai</b> : ".$bootcamp->tgl_selesai."<br>";
			echo "<b>Lokasi</b> : ".$bootcamp->lokasi."<br>";
			echo "<b>Instruktur</b> : <br>";
			echo "<ol>";
			foreach($bootcamp->groupInstrukturs as $row){
				echo "<li>".$row->instruktur0->nama."</li>";
			}
			echo "</ol>";
		?>
    </p>
</fieldset>
<hr />

<h3>Question</h3>

<?php
	if($bootcamp->checked == 0 && Yii::app()->user->checkAccess('MGR. Q&A')){ ?>
    <div class="form">
        <?php echo CHtml::beginForm(); ?>
    
        <?php
			if(!empty($model)){
				foreach($model as $row){
					echo "<span class='span5'>";
						echo CHtml::activeCheckBox($row,'answer',array('name'=>'BootcampDokumen['.$row->id.']'));
						echo " : ".$row->question;
					echo "</span>";
				}
			}else{
				foreach($modelQD as $row){
					echo "<span class='span5'>";
						echo CHtml::CheckBox('BootcampDokumen['.$row->id.']',false);
						echo " : ".$row->question;
					echo "</span>";
				}
			}
        ?>
        <div class="clear"></div>
        
        <div class="form-actions">
            <?php echo TbHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array(
                'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
                'size'=>TbHtml::BUTTON_SIZE_LARGE,
            )); ?>
            <?php
				if(!empty($model) && !$model->isNewRecord){
					echo CHtml::link(TbHtml::icon(TbHtml::ICON_OK).' Checked',array('checkedDocument','id'=>$bootcamp->id,'scenario'=>'checkedDokumen'),array('class' => 'btn btn-success btn-large pull-right', 'confirm'=>'Apakah persyaratannya suadah lengkap?'));
				}
			?>
        </div>
        
        <?php echo CHtml::endForm(); ?>
    </div>
<?php
	}else { ?>
    	<?php
			if(!empty($model)){
				foreach($model as $row){
					echo "<span class='span5'>";
						echo CHtml::activeCheckBox($row,'answer',array('name'=>'BootcampDokumen['.$row->id.']','disabled'=>true));
						echo " : ".$row->question;
					echo "</span>";
				}
			}else{
				echo "Belum tersedia";
			}
        ?>
<?php
	}
?>