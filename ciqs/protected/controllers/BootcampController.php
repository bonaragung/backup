<?php

class BootcampController extends Controller
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
				'actions'=>array('view'),
				'roles'=>array('MITRA','MGR. Q&A','KORD. AUDITOR','AUDITOR'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','create','update','index','view','startBootcamp'),
				'roles'=>array('ADMIN MARKETING'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	public function actionStartBootcamp(){
		
		$model = $this->loadModel($_GET['id']);
		$model->scenario = 'startBootcamp';
		$model->start = 1;
		if($model->save()){
			
			$email = Pengajuan::model()->findByAttributes(array('id'=>$model->pengajuan0->id));	
			$to = $email->mitra0->email;
			$from = Yii::app()->params['adminEmail'];
			$subject = 'Bootcamp';
			$message = '<h2>Bootcamp</h2><p>';
				$message .= '<b>Mitra</b> : '.$email->mitra0->nama.'<br>';
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
			
			$email = User::model()->findAllByAttributes(array('level'=>3));
			foreach($email as $row){
				
				$to = $row->email;
				$from = Yii::app()->params['adminEmail'];
				$subject = 'Bootcamp';
				$message = '<h2>Bootcamp</h2><p>';
					$message .= '<b>Mitra</b> : '.$email->mitra0->nama.'<br>';
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

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		//----- begin new code --------------------
		if (!empty($_GET['asDialog']))
			$this->layout='//layouts/iframe';
		//----- end new code --------------------
		
		$criteria = new CDbCriteria;
		$criteria->compare('bootcamp',$id);
		
		$this->render('view',array(
			'model'=>$this->loadModel($id),
			'modelGroupInstruktur'=>new CActiveDataProvider('GroupInstruktur',array('criteria'=>$criteria)),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Bootcamp;
		if(isset($_GET['id'])){
			$model->pengajuan = $_GET['id'];
		}

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Bootcamp'])) {
			$model->attributes=$_POST['Bootcamp'];
			$model->start = 0;
			$model->checked = 0;
			$model->updated = date('Y-m-d H:i:s');
			if ($model->save()) {
				
				if(isset($_POST['instrukturs'])){
					foreach($_POST['instrukturs'] as $row){
						$modelGI = new GroupInstruktur;
						$modelGI->bootcamp = $model->id;
						$modelGI->instruktur = $row;
						$modelGI->updated = date('Y-m-d H:i:s');
						$modelGI->save();
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
		$modelGroupInstruktur = GroupInstruktur::model()->findAllByAttributes(array('bootcamp'=>$model->id));

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Bootcamp'])) {
			$model->attributes=$_POST['Bootcamp'];
			if ($model->save()) {
				
				if(isset($_POST['instrukturs'])){
					foreach($_POST['instrukturs'] as $row=>$value){
						$modelGroupInstruktur = GroupInstruktur::model()->findByPk($_POST['id'][$row]);
						if(empty($modelGroupInstruktur)){
							$modelGroupInstruktur = new GroupInstruktur;
						}
						$modelGroupInstruktur->instruktur = $value;
						$modelGroupInstruktur->bootcamp = $model->id;
						$modelGroupInstruktur->updated = date('Y-m-d H:i:s');
						$modelGroupInstruktur->save();
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
			'modelGroupInstruktur'=>$modelGroupInstruktur,
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
		/*$dataProvider=new CActiveDataProvider('Bootcamp');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));*/
		$model=new Bootcamp('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['Bootcamp'])) {
			$model->attributes=$_GET['Bootcamp'];
		}

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Bootcamp('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['Bootcamp'])) {
			$model->attributes=$_GET['Bootcamp'];
		}

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Bootcamp the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Bootcamp::model()->findByPk($id);
		if ($model===null) {
			throw new CHttpException(404,'The requested page does not exist.');
		}
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Bootcamp $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax']==='bootcamp-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}