<?php
	$model->statusBootcamp = $status;
?>
<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'pengajuan-grid-'.$status,
	'type' => array(TbHtml::GRID_TYPE_BORDERED, TbHtml::GRID_TYPE_STRIPED, TbHtml::GRID_TYPE_HOVER),
	'dataProvider'=>$model->searchBootcamp(),
	//'filter'=>$model,
	'columns'=>array(
		'id',
		//'mitra',
		'mitra0.nama:raw:Mitra',
		'updated',
		//'type',
		'countParty',
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
            'name'=>'bootcamps.start',
            'type'=>'raw', //because of using html-code
            'value'=>'$data->bootcamps->start == 1 ? TbHtml::labelTb("Ada", array("color" => TbHtml::LABEL_COLOR_SUCCESS)) : TbHtml::labelTb("Belum Ada", array("color" => TbHtml::LABEL_COLOR_WARNING));', //call this controller method for each row
        ),
		array(            
            'name'=>'sidang0.status',
            'type'=>'raw', //because of using html-code
            'value'=>'!empty($data->sidang0->status) ? ($data->sidang0->status == 2 ? TbHtml::labelTb("LULUS", array("color" => TbHtml::LABEL_COLOR_SUCCESS)) : TbHtml::labelTb("GAGAL", array("color" => TbHtml::LABEL_COLOR_WARNING))) : TbHtml::labelTb("Belum Ada");', //call this controller method for each row
        ),
		array(            
            'name'=>'sidang0.status_sertifikat',
            'type'=>'raw', //because of using html-code
            'value'=>'!empty($data->sidang0->status_sertifikat) ? ($data->sidang0->status_sertifikat == 2 ? TbHtml::labelTb("Telah Dikirim", array("color" => TbHtml::LABEL_COLOR_SUCCESS)) : TbHtml::labelTb("Pencetakan", array("color" => TbHtml::LABEL_COLOR_WARNING))) : TbHtml::labelTb("Belum Ada");', //call this controller method for each row
        ),
		array(
            'class'=>$buttonColumn,
			'template'=>"{pengajuanAudit}{checkDokumen}{changeStatus}{viewBootcamp}{addBootcamp}{editBootcamp}{upload}{view}{update}{delete}",
			'htmlOptions' => array('style' => 'white-space: nowrap'),
            //--------------------- begin new code --------------------------
            'buttons'=>array(
						'pengajuanAudit'=>
                            array(
									'label'=>'Audit',
									'imageUrl'=>Yii::app()->request->baseUrl.'/images/book_open.png',
									'url'=>'$this->grid->controller->createUrl("audit", array("id"=>$data->id))',
									'visible'=>'$data->bootcamps->checked == 1 && (Yii::app()->user->checkAccess("MITRA") || Yii::app()->user->checkAccess("KORD. AUDITOR") || Yii::app()->user->checkAccess("AUDITOR") || Yii::app()->user->checkAccess("MGR. Q&A") || Yii::app()->user->checkAccess("KORD. ARBITRASE"))',
                                ),
						'checkDokumen'=>
                            array(
									'label'=>'Check Dokumen',
									'imageUrl'=>Yii::app()->request->baseUrl.'/images/book.png',
									'url'=>'$this->grid->controller->createUrl("checkDocument", array("id"=>$data->bootcamps->id))',
									'visible'=>'$data->bootcamps->start == 1',
                                ),
						'changeStatus'=>
                            array(
									'label'=>'Change Status',
									'imageUrl'=>Yii::app()->request->baseUrl.'/images/accept.png',
									'url'=>'$this->grid->controller->createUrl("update", array("id"=>$data->primaryKey,"asDialog"=>1,"gridId"=>$this->grid->id,"scenario"=>"changeStatusBootcamp"))',
									//'visible'=>'!empty($data->bukti_bayar) && $data->status_bayar==0 && Yii::app()->user->checkAccess("ADMIN MARKETING")',
                                    'visible'=>'!empty($data->bukti_bayar) && $data->status_bayar==0 && Yii::app()->user->checkAccess("MGR. Q&A")',
									'options' => array('confirm' => 'Are you sure?'),
                                ),
						'addBootcamp'=>
                            array(
									'label'=>'Create Bootcamp',
									'imageUrl'=>Yii::app()->request->baseUrl.'/images/cup_add.png',
									'url'=>'$this->grid->controller->createUrl("bootcamp/create", array("id"=>$data->primaryKey,"asDialog"=>1,"gridId"=>$this->grid->id))',
									'visible'=>'empty($data->bootcamps) && !empty($data->bukti_bayar) && $data->status_bayar==1 && Yii::app()->user->checkAccess("ADMIN MARKETING")',
									'click'=>$updateClick,
									'options'=>$options,
                                ),
						'editBootcamp'=>
                            array(
									'label'=>'Update Bootcamp',
									'imageUrl'=>Yii::app()->request->baseUrl.'/images/cup_edit.png',
									'url'=>'$this->grid->controller->createUrl("bootcamp/update", array("id"=>$data->bootcamps->primaryKey,"asDialog"=>1,"gridId"=>$this->grid->id))',
									'visible'=>'!empty($data->bootcamps) && $data->bootcamps->start == 0 && Yii::app()->user->checkAccess("ADMIN MARKETING")',
									'click'=>$updateClick,
									'options'=>$options,
                                ),
						'viewBootcamp'=>
                            array(
									'label'=>'View Bootcamp',
									'imageUrl'=>Yii::app()->request->baseUrl.'/images/cup.png',
									'url'=>'$this->grid->controller->createUrl("bootcamp/view", array("id"=>$data->bootcamps->id,"asDialog"=>1,"gridId"=>$this->grid->id))',
									'visible'=>'!empty($data->bootcamps)',
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
                                    'url'=>'$this->grid->controller->createUrl("view", array("id"=>$data->primaryKey,"asDialog"=>1,"gridId"=>$this->grid->id,"type"=>"bootcamp"))',
                                    'click'=>$viewClick,
									'options'=>$options,
                                ),
                        'update'=>
                            array(
                                    'url'=>'$this->grid->controller->createUrl("update", array("id"=>$data->primaryKey,"asDialog"=>1,"gridId"=>$this->grid->id))',
                                    'click'=>$updateClick,
									'options'=>$options,
									'visible'=>'$data->ajukan == 0 && Yii::app()->user->checkAccess("MITRA")',
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