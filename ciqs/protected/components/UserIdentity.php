<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	/*public function authenticate()
	{
		$users=array(
			// username => password
			'demo'=>'demo',
			'admin'=>'admin',
		);
		if(!isset($users[$this->username]))
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		else if($users[$this->username]!==$this->password)
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else
			$this->errorCode=self::ERROR_NONE;
		return !$this->errorCode;
	}*/
	
    public function authenticate()
    {
        $record=User::model()->findByAttributes(array('username'=>$this->username));
		$user = 'telkom';
		
		if(empty($record)){
			$record=Mitra::model()->findByAttributes(array('username'=>$this->username));
			$user = 'mitra';
			
			if(empty($record)){
				$record=Auditor::model()->findByAttributes(array('username'=>$this->username));
				$user = 'auditor';
			}
		}
		
		if($record===null)
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		//else if($record->password!==$this->password)
		else if(md5(md5($this->password).Yii::app()->params["salt"])!==$record->password)
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else
		{
			if($user == 'telkom'){
				$this->setState('role', $record->level0->name);
			}else if($user == 'mitra'){
				$this->setState('role', 'MITRA');
			}
			else if($user == 'auditor'){
				$this->setState('role', 'AUDITOR');
			}
			$this->errorCode=self::ERROR_NONE;
		}
		return !$this->errorCode;
		
    }
}