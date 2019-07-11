<?php

/**
 * This is the model class for table "audit_dokumen".
 *
 * The followings are the available columns in table 'audit_dokumen':
 * @property string $id
 * @property string $audit
 * @property string $temuan
 * @property string $tindakan
 * @property string $updated
 * @property string $evidence
 * @property string $tgl_penyelesaian
 * @property string $status
 * @property string $status_temuan
 *
 * The followings are the available model relations:
 * @property Audit $audit0
 */
class AuditDokumen extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AuditDokumen the static model class
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
		return 'audit_dokumen';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('audit, temuan, tindakan, updated, evidence, status, status_temuan', 'required'),
			array('audit, status', 'length', 'max'=>10),
			array('status_temuan', 'length', 'max'=>45),
			array('tgl_penyelesaian', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, audit, temuan, tindakan, updated, evidence, tgl_penyelesaian, status, status_temuan', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'audit0' => array(self::BELONGS_TO, 'Audit', 'audit'),
			'auditor0' => array(self::BELONGS_TO, 'Auditor', 'auditor'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'audit' => 'Audit',
			'temuan' => 'Temuan',
			'tindakan' => 'Tindakan',
			'updated' => 'Updated',
			'evidence' => 'Komentar',
			'tgl_penyelesaian' => 'Tgl Penyelesaian',
			'status' => 'Status',
			'status_temuan' => 'Status Temuan',
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
		$criteria->compare('audit',$this->audit,true);
		$criteria->compare('temuan',$this->temuan,true);
		$criteria->compare('tindakan',$this->tindakan,true);
		$criteria->compare('updated',$this->updated,true);
		$criteria->compare('evidence',$this->evidence,true);
		$criteria->compare('tgl_penyelesaian',$this->tgl_penyelesaian,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('status_temuan',$this->status_temuan,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}