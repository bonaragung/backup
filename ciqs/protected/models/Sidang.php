<?php

/**
 * This is the model class for table "sidang".
 *
 * The followings are the available columns in table 'sidang':
 * @property string $id
 * @property string $pengajuan
 * @property string $tgl_sidang
 * @property string $hasil
 * @property string $status
 * @property string $updated
 *
 * The followings are the available model relations:
 * @property Pengajuan $pengajuan0
 */
class Sidang extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Sidang the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'sidang';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pengajuan, tgl_sidang, updated', 'required'),
			array('pengajuan, status', 'length', 'max'=>10),
            array('upload_hasil', 'file', 'types'=>'pdf','maxSize'=>550000, 'allowEmpty'=>true, 'tooLarge'=>'Max size is 500kb'),
			array('hasil, penerbitan, status_sertifikat', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, pengajuan, tgl_sidang, hasil, status, updated', 'safe', 'on'=>'search'),
		);
	}
    
    public function beforeValidate()
    {
	    if($upload_hasil=CUploadedFile::getInstance($this,'upload_hasil'))
        {
            $this->upload_hasil=file_get_contents($upload_hasil->tempName);
        }
		
		return parent::beforeValidate();
    }

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'pengajuan0' => array(self::BELONGS_TO, 'Pengajuan', 'pengajuan'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'pengajuan' => 'Pengajuan',
			'tgl_sidang' => 'Tgl Sidang',
			'hasil' => 'Hasil',
			'status' => 'Status',
			'updated' => 'Updated',
			'penerbitan' => 'Penerbitan',
			'status_sertifikat' => 'Status Sertifikat',
            'upload_hasil' => 'Upload Hasil Sidang',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('pengajuan',$this->pengajuan,true);
		$criteria->compare('tgl_sidang',$this->tgl_sidang,true);
		$criteria->compare('hasil',$this->hasil,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('updated',$this->updated,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}