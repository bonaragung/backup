<?php

class PengajuanController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','create','update','index','view','audit','addAudit','checkDocument','persetujuan','ajukanPengajuan','buktiBayar'),
				'roles'=>array('MITRA'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','update','index','view','checkDocument','audit','checkedDocument','buktiBayar'),
				'roles'=>array('MGR. Q&A'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','index','view','update','audit','checkDocument','buktiBayar','laporan'),
				'roles'=>array('KORD. AUDITOR'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','update','index','view','buktiBayar','audit','checkDocument'),
				'roles'=>array('ADMIN MARKETING'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','index','view','update','audit','checkDocument','buktiBayar','laporan'),
				'roles'=>array('AUDITOR'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','index','view','update','audit','checkDocument','buktiBayar','laporan'),
				'roles'=>array('KORD. ARBITRASE'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	public function actionLaporan($id){
		
		$model = $this->loadModel($id);
		
		$modelA = Audit::model()->findByPk($model->audits->id);
		
		if(isset($_GET['scenario'])){
			if($_GET['scenario'] == 'laporkan'){
				$modelA->laporkan = 1;
				if($modelA->save()){
					
					$email = User::model()->findAllByAttributes(array('level'=>3));
					foreach($email as $row){
						$to = $row->email;
						$from = Yii::app()->params['adminEmail'];
						$subject = 'Laporan Audit';
						$message = '<h2>Detail Audit</h2><p>';
							$message .= '<b>Mitra</b> : '.$model->mitra0->nama.'<br>';
							$message .= '<b>Tgl Mulai</b> : '.$model->audits->tgl_mulai.'<br>';
							$message .= '<b>Tgl Selesai</b> : '.$model->audits->tgl_selesai.'<br>';
							$message .= '<br><br><b>Auditor</b> : <br>';
							$gA = GroupAudit::model()->findAllByAttributes(array('audit'=>$modelA->id));
							$i = 1;
							foreach($gA as $rows){
								$message .= $i.'. '.$rows->auditor0->nama.'<br>';
								$i++;
							}
						$message .= '</p>';
						$message .= '<p>Demikian pemberitahuan, terima kasih</p>';
						
						SendEmail::mailsend($to,$from,$subject,$message);
					}
				}
				
				$this->redirect(array('laporan', 'id'=>$id));
			}
			if($_GET['scenario'] == 'tolakLaporan'){
				$modelA->laporkan = 0;
				$modelA->sidang = 0;
				if($modelA->save()){
					$gA = GroupAudit::model()->findAllByAttributes(array('audit'=>$modelA->id));
					foreach($gA as $row){
						$to = $row->auditor0->email;
						$from = Yii::app()->params['adminEmail'];
						$subject = 'Penolakan Laporan Audit';
						$message = '<h2>Detail Audit</h2><p>';
							$message .= '<b>Mitra</b> : '.$model->mitra0->nama.'<br>';
							$message .= '<b>Tgl Mulai</b> : '.$model->audits->tgl_mulai.'<br>';
							$message .= '<b>Tgl Selesai</b> : '.$model->audits->tgl_selesai.'<br>';
							$message .= '<br><br><b>Auditor</b> : <br>';
							$i = 1;
							foreach($gA as $rows){
								$message .= $i.'. '.$rows->auditor0->nama.'<br>';
								$i++;
							}
						$message .= '</p>';
						$message .= '<p>Demikian pemberitahuan, terima kasih</p>';
						
						SendEmail::mailsend($to,$from,$subject,$message);
					}
				}
				
				$this->redirect(array('audit', 'id'=>$modelA->pengajuan0->parent));
			}
			if($_GET['scenario'] == 'terimaLaporan'){
				$modelA->sidang = 1;
				if($modelA->save()){
					$email = User::model()->findAllByAttributes(array('level'=>6));
					foreach($email as $row){
						$to = $row->email;
						$from = Yii::app()->params['adminEmail'];
						$subject = 'Permintaan Sidang';
						$message = '<h2>Detail Audit</h2><p>';
							$message .= '<b>Mitra</b> : '.$model->mitra0->nama.'<br>';
							$message .= '<b>Tgl Mulai</b> : '.$model->audits->tgl_mulai.'<br>';
							$message .= '<b>Tgl Selesai</b> : '.$model->audits->tgl_selesai.'<br>';
							$message .= '<br><br><b>Auditor</b> : <br>';
							$gA = GroupAudit::model()->findAllByAttributes(array('audit'=>$modelA->id));
							$i = 1;
							foreach($gA as $rows){
								$message .= $i.'. '.$rows->auditor0->nama.'<br>';
								$i++;
							}
						$message .= '</p>';
						$message .= '<p>Demikian pemberitahuan, terima kasih</p>';
						
						SendEmail::mailsend($to,$from,$subject,$message);
					}
				}
				
				$this->redirect(array('audit', 'id'=>$modelA->pengajuan0->parent));
			}
		}
		
		$modelAD=new AuditDokumen('laporan');
		$modelAD->unsetAttributes();  // clear any default values
		$modelAD->audit = $model->audits->id;
		if (isset($_GET['AuditDokumen'])) {
			$modelAD->attributes=$_GET['AuditDokumen'];
		}
		
		if(isset($_POST['Audit'])){
			$modelA->attributes = $_POST['Audit'];
			$modelA->save();
			
			$this->redirect(array('laporan', 'id'=>$id));
		}
		
		$this->render('laporan',array(
			'model'=>$model,
			'modelAD'=>$modelAD,
			'modelA'=>$modelA,
		));
	}
	
	public function actionCheckedDocument($id){
		$model = Bootcamp::model()->findByPk($id);
		$model->scenario = 'checkedDocument';
		$model->checked = 1;
		if($model->save()){
			//$email = User::model()->findAllByAttributes(array('level'=>4));
			//foreach($email as $row){
				
				$to = $model->pengajuan0->mitra0->email;
				$from = Yii::app()->params['adminEmail'];
				$subject = 'Checked Document Bootcamp';
				$message = '<h2>Checked Document Bootcamp</h2><p>';
					$message .= '<b>Mitra</b> : '.$model->pengajuan0->mitra0->nama.'<br>';
					$message .= '<b>Tgl Mulai</b> : '.$model->tgl_mulai.'<br>';
					$message .= '<b>Tgl Selesai</b> : '.$model->tgl_selesai.'<br>';
					$message .= '<b>Lokasi</b> : '.$model->lokasi.'<br>';
					$message .= '<br><br><b>Instruktur</b> : <br>';
					$gA = GroupInstruktur::model()->findAllByAttributes(array('bootcamp'=>$model->id));
					$i = 1;
					foreach($gA as $row){
						$message .= $i.'. '.$row->instruktur0->nama.'<br>';
						$i++;
					}
				$message .= '</p>';
				$message .= '<p>Demikian pemberitahuan, terima kasih</p>';
				
				SendEmail::mailsend($to,$from,$subject,$message);
			//}
		}
		$this->redirect(array('checkDocument','id'=>$id));
	}
	
	public function actionAjukanPengajuan(){
		
		$model = $this->loadModel($_GET['id']);
		$model->scenario = 'ajukanPengajuan';
		$model->ajukan = 1;
        $model->tgl_pengajuan = date('Y-m-d');
		if($model->save()){
			
			if(isset($_GET['type'])){
				if($_GET['type'] == 'bootcamp'){
					$level = 2;
				} else if($_GET['type'] == 'audit'){
					$level = 4;
				}
			}
			
			$email = User::model()->findAllByAttributes(array('level'=>$level));
			foreach($email as $row){
				
				$to = $row->email;
				$from = Yii::app()->params['adminEmail'];
				$subject = 'Create Pengajuan';
				$message = '<h2>Create Pengajuan</h2><p>';
					$message .= '<b>Mitra</b> : '.$model->mitra0->nama.'<br>';
					$message .= '<b>Type</b> : '.$model->type.'<br>';
                    $message .= '<b>Tgl Pengajuan</b> : '.$model->tgl_pengajuan.'<br>';
				$message .= '</p>';
				$message .= '<p>Demikin pemberitahuan, terima kasih</p>';
				
				SendEmail::mailsend($to,$from,$subject,$message);
			}
			
			//----- begin new code --------------------
			if (!empty($_GET['asDialog']))
			{
				//Close the dialog, reset the iframe and update the grid
				
				// Check IE browser
				$msie = strpos($_SERVER["HTTP_USER_AGENT"], 'MSIE') ? true : false;
				// IE
				if($msie){
					echo CHtml::script("window.parent.$('#cru-dialog').dialog('close');window.parent.$('#cru-frame').attr('src','');window.parent.$.fn.yiiGridView.update('".$_GET['gridId']."');");
				}else{
					echo CHtml::script("window.parent.$('#modal').modal('hide');window.parent.$('#new-cru-frame').attr('src','');window.parent.$.fn.yiiGridView.update('".$_GET['gridId']."');");
				}
				Yii::app()->end();
			}
		}
		
		$this->redirect(array('view','id'=>$model->id,'asDialog'=>$_GET['asDialog']));
	}
	
	public function actionAudit($id){
		
		$modelSidang = Sidang::model()->findByAttributes(array('pengajuan'=>$id));
		
		if($_GET['scenario']){
			if($_GET['scenario'] == 'penerbitan'){
				$modelSidang->penerbitan = 1;
				$modelSidang->status_sertifikat = 1;
				$modelSidang->updated = date('Y-m-d H:i:s');
				if ($modelSidang->save()) {
					
					$dbCriteria = new CDbCriteria;
					$dbCriteria->condition = 'level in (3)';
					
					$email = User::model()->findAll($dbCriteria);
					foreach($email as $row){
						$to = $row->email;
						$from = Yii::app()->params['adminEmail'];
						$subject = 'Penerbitan Sertifikat';
						$message = '<h2>Detail</h2><p>';
							$message .= '<b>Mitra</b> : '.$modelSidang->pengajuan0->mitra0->nama.'<br>';
							$message .= '<b>Tanggal Sidang</b> : '.$modelSidang->tgl_sidang.'<br>';
							$message .= '<b>Status</b> : ';
								if($modelSidang->status == 1){
									$message .= 'GAGAL';
								}else if($modelSidang->status == 2){
									$message .= 'LULUS';
								}
							$message .= '<br>';
						$message .= '</p>';
						$message .= '<p>Demikian pemberitahuan, terima kasih</p>';
	
						SendEmail::mailsend($to,$from,$subject,$message);
					}
					
					$this->redirect(array('audit','id'=>$id));
				}
			}
		}
		
		$model=new Pengajuan('audit');
		//$model->unsetAttributes();  // clear any default values
		$model->parent = $id;
		if (isset($_GET['Pengajuan'])) {
			//$model->attributes=$_GET['Pengajuan'];
		}
		
		$check = $model->findAllByAttributes(array('parent'=>$id));
		
		$criteria = new CDbCriteria;
		/*$criteria->select = 'a.mitra, b.lokasi, b.tgl_mulai, b.tgl_selesai';
		$criteria->join = 'JOIN bootcamp b ON b.id = a.parent';*/
		//$criteria->alias = 'a';
		//$criteria->compare('parent',$id);
		$criteria->compare('type','BOOTCAMP');
		$criteria->compare('id',$id);
		$modelB = Pengajuan::model()->find($criteria);
		
		$criteriaSidang = new CDbCriteria;
		$criteriaSidang->alias = 'a';
		$criteriaSidang->join = 'LEFT OUTER JOIN pengajuan pengajuanaudit ON (pengajuanaudit.parent = '.$id.')
LEFT OUTER JOIN audit audits ON (audits.pengajuan = pengajuanaudit.id)';
		$criteriaSidang->compare('audits.sidang',1);
		$sidang = Pengajuan::model()->findAll($criteriaSidang);
		
		if(empty($modelSidang)){
			$modelSidang = new Sidang;
		}
		if (isset($_POST['Sidang'])) {
			$modelSidang->attributes=$_POST['Sidang'];
			$modelSidang->pengajuan = $id;
			$modelSidang->updated = date('Y-m-d H:i:s');
			if ($modelSidang->save()) {
				if($modelSidang->status == 1 || $modelSidang->status == 2){
					
				}else{
					$dbCriteria = new CDbCriteria;
					$dbCriteria->condition = 'level in (2,3,4,6)';
					
					$email = User::model()->findAll($dbCriteria);
					foreach($email as $row){
						$to = $row->email;
						$from = Yii::app()->params['adminEmail'];
						$subject = 'Sidang';
						$message = '<h2>Detail Audit</h2><p>';
							$message .= '<b>Mitra</b> : '.$modelSidang->pengajuan0->mitra0->nama.'<br>';
							$message .= '<b>Tanggal Sidang</b> : '.$modelSidang->tgl_sidang.'<br>';
						$message .= '</p>';
						$message .= '<p>Demikian pemberitahuan, terima kasih</p>';
	
						SendEmail::mailsend($to,$from,$subject,$message);
					}
				}
				
				$this->redirect(array('audit','id'=>$id));
			}
		}

		$this->render('adminAudit',array(
			'model'=>$model,
			'check'=>$check,
			'sidang'=>$sidang,
			'modelB'=>$modelB,
			'modelSidang'=>$modelSidang,
		));
	}
	
	public function actionAddAudit(){
		
		$mitra = Mitra::model()->findByAttributes(array('username'=>Yii::app()->user->id));
		
		$model = new Pengajuan;
		$model->mitra = $mitra->id;
		$model->updated = date('Y-m-d H:i:s');
		$model->type = 'AUDIT';
		$model->status_bayar = 0;
		$model->parent = $_POST['id'];
		$model->ajukan = 0;
		if($model->save()){
			echo 'success';
		}else{
			echo 'fail';
		}
	}
	
	public function actionCheckDocument($id){
		$criteria = new CDbCriteria;
		$criteria->select = 'q.id,q.question,b.answer,b.q_dokumen';
		$criteria->join = 'JOIN q_dokumen q ON q.id = b.q_dokumen';
		$criteria->condition = 'b.bootcamp = '.$id;
		$criteria->alias = 'b';
		$model = BootcampDokumen::model()->findAll($criteria);
		$new = 0;
		
		if(empty($model)){
			$new = 1;
		}
		
		$modelQD = QDokumen::model()->findAll();
		
		if(isset($_POST['BootcampDokumen'])){
			if($new == 1){
				foreach($modelQD as $row){
					$modelBD = new BootcampDokumen;
					$modelBD->bootcamp = $id;
					$modelBD->q_dokumen = $row->id;
					$modelBD->answer = isset($_POST['BootcampDokumen'][$row->id]) ? 1 : 0;
					$modelBD->updated = date('Y-m-d H:i:s');
					$modelBD->save();
				}
			}else{
				$model = BootcampDokumen::model()->findAllByAttributes(array('bootcamp'=>$id));
				foreach($model as $row=>$value){
					$value->answer = $_POST['BootcampDokumen'][$row+1];
					$value->updated = date('Y-m-d H:i:s');
					$value->save();
				}
			}
			$this->redirect(array('checkDocument','id'=>$id));
		}
		
		$bootcamp = Bootcamp::model()->findByPk($id);
		
		$this->render('checkDocument',array(
			'model'=>$model,
			'bootcamp'=>$bootcamp,
			'modelQD'=>$modelQD,
		));
	}
	
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$type = $_GET['type'];
		//----- begin new code --------------------
		if (!empty($_GET['asDialog']))
			$this->layout='//layouts/iframe';
		//----- end new code --------------------
		
		$criteria = new CDbCriteria;
		$criteria->compare('pengajuan',$id);
		
		$this->render('view',array(
			'model'=>$this->loadModel($id),
			'type'=>$_GET['type'],
			'modelParticipant'=>new CActiveDataProvider('Participant',array('criteria'=>$criteria)),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Pengajuan;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		//if (isset($_POST['Pengajuan'])) {
		if (isset($_POST['save'])) {
			$mitra = Mitra::model()->findByAttributes(array('username'=>Yii::app()->user->id));
			
			//$model->attributes=$_POST['Pengajuan'];
			$model->mitra = $mitra->id;
			$model->type = 'BOOTCAMP';
			$model->status_bayar = 0;
			$model->ajukan = 0;
			$model->updated = date('Y-m-d H:i:s');
			if ($model->save()) {
				
				$pengajuan = $model->id;
				
				foreach($_POST['participants'] as $row=>$value){
					$modelParticipant = new Participant;
					$modelParticipant->nama = $value;
					$modelParticipant->email = $_POST['email'][$row];
					$modelParticipant->telp = $_POST['telp'][$row];
                    if($_POST['jabatan'][$row] == 'MR' || $_POST['jabatan'][$row] == 'site manager'){
                        $modelParticipant->jabatan = $_POST['jabatan'][$row];
                    }else{
                        $modelParticipant->jabatan = $_POST['jabatanOthers'][$row];
                    }
					$modelParticipant->pengajuan = $pengajuan;
					$modelParticipant->updated = date('Y-m-d H:i:s');
					$modelParticipant->save();
				}
				
				//----- begin new code --------------------
				if (!empty($_GET['asDialog']))
				{
					//Close the dialog, reset the iframe and update the grid
					
					// Check IE browser
					$msie = strpos($_SERVER["HTTP_USER_AGENT"], 'MSIE') ? true : false;
					// IE
					if($msie){
						echo CHtml::script("window.parent.$('#cru-dialog').dialog('close');window.parent.$('#cru-frame').attr('src','');window.parent.$.fn.yiiGridView.update('".$_GET['gridId']."');");
					}else{
						echo CHtml::script("window.parent.$('#modal').modal('hide');window.parent.$('#new-cru-frame').attr('src','');window.parent.$.fn.yiiGridView.update('".$_GET['gridId']."');");
					}
					Yii::app()->end();
				}
				else
				//----- end new code --------------------
				
				$this->redirect(array('view','id'=>$model->id,'asDialog'=>$_GET['asDialog']));
			}
		}
		
		//----- begin new code --------------------
		if (!empty($_GET['asDialog']))
			$this->layout='//layouts/iframe';
		//----- end new code --------------------

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{	
		$model=$this->loadModel($id);
		$modelParticipant = Participant::model()->findAllByAttributes(array('pengajuan'=>$model->id));
		
		if(isset($_GET['scenario'])){
			if($_GET['scenario'] == 'upload'){
				$model->scenario = 'upload';
			}else if($_GET['scenario'] == 'changeStatusBootcamp'){
				$model->scenario = 'changeStatusBootcamp';
				$model->status_bayar = 1;
				$model->updated = date('Y-m-d H:i:s');
				if($model->save()){
					$this->redirect(array('index'));
				}
			}
			else if($_GET['scenario'] == 'changeStatusAudit'){
				$model->scenario = 'changeStatusAudit';
				$model->status_bayar = 1;
				$model->updated = date('Y-m-d H:i:s');
				if($model->save()){
					$this->redirect(array('audit','id'=>$model->parent));
				}
			}
		}

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		//if (isset($_POST['Pengajuan'])) {
		if (isset($_POST['save'])) {
			if (isset($_POST['Pengajuan'])){
				$model->attributes=$_POST['Pengajuan'];
				$model->updated = date('Y-m-d H:i:s');
			}
			
			$mitra = Mitra::model()->findByAttributes(array('username'=>Yii::app()->user->id));
			
			//$model->attributes=$_POST['Pengajuan'];
			//$model->updated = date('Y-m-d H:i:s');
			if ($model->save()) {
				
                if($model->scenario == 'upload'){
                    $to = $mitra->email;
                    $from = Yii::app()->params['adminEmail'];
                    $subject = 'Bukti Bayar Pengajuan';
                    $message = '<h2>Create Pengajuan</h2><p>';
                        $message .= '<b>Mitra</b> : '.$model->mitra0->nama.'<br>';
                        $message .= '<b>Type</b> : '.$model->type.'<br>';
                        $message .= '<b>Tgl Pengajuan</b> : '.$model->tgl_pengajuan.'<br>';
                    $message .= '</p>';
                    $message .= '<p>Demikin pemberitahuan, terima kasih</p>';

                    SendEmail::mailsend($to,$from,$subject,$message);
                }else{
                    if(isset($_POST['participants'])){
                        foreach($_POST['participants'] as $row=>$value){
                            $modelParticipant = Participant::model()->findByPk($_POST['id'][$row]);
                            if(empty($modelParticipant)){
                                $modelParticipant = new Participant;
                            }
                            $modelParticipant->pengajuan = $model->id;
                            $modelParticipant->nama = $value;
                            $modelParticipant->email = $_POST['email'][$row];
                            $modelParticipant->telp = $_POST['telp'][$row];
                            if($_POST['jabatan'][$row] == 'MR' || $_POST['jabatan'][$row] == 'site manager'){
                                $modelParticipant->jabatan = $_POST['jabatan'][$row];
                            }else{
                                $modelParticipant->jabatan = $_POST['jabatanOthers'][$row];
                            }
                            $modelParticipant->updated = date('Y-m-d H:i:s');
                            $modelParticipant->save();
                        }
                    }
                }
				
				//----- begin new code --------------------
				if (!empty($_GET['asDialog']))
				{
					//Close the dialog, reset the iframe and update the grid
					
					// Check IE browser
					$msie = strpos($_SERVER["HTTP_USER_AGENT"], 'MSIE') ? true : false;
					// IE
					if($msie){
						echo CHtml::script("window.parent.$('#cru-dialog').dialog('close');window.parent.$('#cru-frame').attr('src','');window.parent.$.fn.yiiGridView.update('".$_GET['gridId']."');");
					}else{
						echo CHtml::script("window.parent.$('#modal').modal('hide');window.parent.$('#new-cru-frame').attr('src','');window.parent.$.fn.yiiGridView.update('".$_GET['gridId']."');");
					}
					Yii::app()->end();
				}
				else
				//----- end new code --------------------
				
				$this->redirect(array('view','id'=>$model->id,'asDialog'=>$_GET['asDialog']));
			}
		}
		
		//----- begin new code --------------------
		if (!empty($_GET['asDialog']))
			$this->layout='//layouts/iframe';
		//----- end new code --------------------

		$this->render('update',array(
			'model'=>$model,
			'modelParticipant'=>$modelParticipant,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if (Yii::app()->request->isPostRequest) {
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if (!isset($_GET['ajax'])) {
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
			}
		} else {
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
		}
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		/*$dataProvider=new CActiveDataProvider('Pengajuan');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));*/
		
		if(Yii::app()->user->checkAccess('MITRA') && !Yii::app()->user->checkAccess('ADMINISTRATOR')){
			$mitra = Mitra::model()->findByAttributes(array('username'=>Yii::app()->user->id));
			if($mitra->persetujuan == 0){
				$this->redirect(array('persetujuan'));
			}else if(
				$mitra->alamat == '' && $mitra->telepon == '' && $mitra->email == '' &&
				$mitra->npwp == '' && $mitra->fax == '' && $mitra->dirut == '' &&
				$mitra->mr == '' && $mitra->bidang_usaha == ''
				){
				$this->redirect(array('mitra/addBiodata'));
			}
		}
		
		$model=new Pengajuan('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['Pengajuan'])) {
			$model->attributes=$_GET['Pengajuan'];
		}

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	
	public function actionPersetujuan(){
		$mitra = Mitra::model()->findByAttributes(array('username'=>Yii::app()->user->id));
		if(isset($_POST['persetujuan'])){
			$mitra->scenario = 'persetujuan';
			$mitra->persetujuan = 1;
			
			if($mitra->save()){
				$this->redirect(array('mitra/addBiodata'));
			}
		}
		$this->render('persetujuan');
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Pengajuan('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['Pengajuan'])) {
			$model->attributes=$_GET['Pengajuan'];
		}

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	
	public function actionBuktiBayar($id)
	{
		$file= $this->loadModel($id);
		if (!empty($file)) {

			header('Pragma: public');
			header('Expires: 0');
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Content-Transfer-Encoding: binary');
			header('Content-Type: application/pdf');
			header('Content-Disposition: attachment; filename='.'"bukti_bayar-'.$file->mitra0->nama.'-'.$file->type.'.pdf"');

		echo $file->bukti_bayar;
		}else { throw new CHttpException(403,'access denied');}
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Pengajuan the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Pengajuan::model()->findByPk($id);
		if ($model===null) {
			throw new CHttpException(404,'The requested page does not exist.');
		}
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Pengajuan $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax']==='pengajuan-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}