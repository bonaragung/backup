<?php

class MitraController extends Controller
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
				'actions'=>array('admin','delete','create','update','index','view'),
				'roles'=>array('ADMIN MARKETING'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('addBiodata'),
				'roles'=>array('MITRA'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
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
		
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Mitra;
		//$modelGroupBidangUsaha = new GroupBidangUsaha;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Mitra'])) {
			$model->attributes=$_POST['Mitra'];
            $password = $model->password;
			$model->persetujuan = 0;
			$model->updated = date('Y-m-d H:i:s');
			if ($model->save()) {
				
                $to = $model->email;
                $from = Yii::app()->params['adminEmail'];
                $subject = 'New User';
                $message = '<h2>Detail</h2><p>';
                    $message .= '<b>Mitra</b> : '.$model->nama.'<br>';
                    $message .= '<b>Username</b> : '.$model->username.'<br>';
                    $message .= '<b>Password</b> : '.$password.'<br>';
                $message .= '</p>';
                $message .= '<p>Demikian pemberitahuan, terima kasih</p>';

                SendEmail::mailsend($to,$from,$subject,$message);
                
				/*foreach($_POST['GroupBidangUsaha'] as $row=>$value){
					$modelGroupBidangUsaha = new GroupBidangUsaha;
					$modelGroupBidangUsaha->mitra = $model->id;
					$modelGroupBidangUsaha->bidang_usaha = $_POST['GroupBidangUsaha']['bidang_usaha'][$row];
					$modelGroupBidangUsaha->save();
				}*/
				
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
			//'modelGroupBidangUsaha'=>$modelGroupBidangUsaha,
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
        
        if($_GET['scenario'] == 'updatePassword') { 
            $model->scenario = 'updatePassword';
        }
        
		/*$modelGroupBidangUsaha = GroupBidangUsaha::model()->findAllByAttributes(array('mitra'=>$model->id));
		if(empty($modelGroupBidangUsaha)){
			$modelGroupBidangUsaha = new GroupBidangUsaha;
		}*/

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Mitra'])) {
			//$model->attributes=$_POST['Mitra'];
            if($model->scenario != 'updatePassword'){
                if(!Yii::app()->user->checkAccess('ADMINISTRATOR')){
                    $model->alamat=$_POST['Mitra']['alamat'];
                    $model->telepon=$_POST['Mitra']['telepon'];
                    $model->npwp=$_POST['Mitra']['npwp'];
                    $model->fax=$_POST['Mitra']['fax'];
                    $model->dirut=$_POST['Mitra']['dirut'];
                    $model->mr=$_POST['Mitra']['mr'];
                    $model->bidang_usaha=$_POST['Mitra']['bidang_usaha'];
                }
                $model->nama=$_POST['Mitra']['nama'];
                $model->email=$_POST['Mitra']['email'];
                $model->telp_mr=$_POST['Mitra']['telp_mr'];
            }else{
                $model->password=$_POST['Mitra']['password'];
                $model->password2=$_POST['Mitra']['password2'];
            }
			$model->updated = date('Y-m-d H:i:s');
			if ($model->save()) {
				
				/*foreach($_POST['GroupBidangUsaha'] as $row=>$value){
					$modelGroupBidangUsaha = GroupBidangUsaha::model()->findByAttributes(array('mitra'=>$model->id,'bidang_usaha'=>$_POST['GroupBidangUsaha']['bidang_usaha'][$row]));
					if(empty($modelGroupBidangUsaha)){
						$modelGroupBidangUsaha = new GroupBidangUsaha;
					}
					$modelGroupBidangUsaha->mitra = $model->id;
					$modelGroupBidangUsaha->bidang_usaha = $_POST['GroupBidangUsaha']['bidang_usaha'][$row];
					$modelGroupBidangUsaha->save();
				}*/
				
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
			//'modelGroupBidangUsaha'=>$modelGroupBidangUsaha,
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
	
	public function actionAddBiodata(){
		$model = Mitra::model()->findByAttributes(array('username'=>Yii::app()->user->id));
		if($model->persetujuan == 0){
			$this->redirect(array('pengajuan/index'));
		}else{
			// Uncomment the following line if AJAX validation is needed
			// $this->performAjaxValidation($model);
	
			if (isset($_POST['Mitra'])) {
				$model->attributes=$_POST['Mitra'];
				$model->updated = date('Y-m-d H:i:s');
				if ($model->save()) {
					$this->redirect(array('pengajuan/index'));
				}
			}
	
			$this->render('_form',array(
				'model'=>$model,
				'scenario'=>'addBiodata',
			));
		}
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		/*$dataProvider=new CActiveDataProvider('Mitra');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));*/
		
		$model=new Mitra('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['Mitra'])) {
			$model->attributes=$_GET['Mitra'];
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
		$model=new Mitra('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['Mitra'])) {
			$model->attributes=$_GET['Mitra'];
		}

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Mitra the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Mitra::model()->findByPk($id);
		if ($model===null) {
			throw new CHttpException(404,'The requested page does not exist.');
		}
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Mitra $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax']==='mitra-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}