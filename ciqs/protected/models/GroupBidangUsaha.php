<?php

/**
 * This is the model class for table "group_bidang_usaha".
 *
 * The followings are the available columns in table 'group_bidang_usaha':
 * @property string $id
 * @property string $mitra
 * @property string $bidang_usaha
 *
 * The followings are the available model relations:
 * @property BidangUsaha $bidangUsaha
 * @property Mitra $mitra0
 */
class GroupBidangUsaha extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return GroupBidangUsaha the static model class
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
		return 'group_bidang_usaha';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('mitra, bidang_usaha', 'required'),
			array('mitra, bidang_usaha', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, mitra, bidang_usaha', 'safe', 'on'=>'search'),
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
			'bidangUsaha' => array(self::BELONGS_TO, 'BidangUsaha', 'bidang_usaha'),
			'mitra0' => array(self::BELONGS_TO, 'Mitra', 'mitra'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'mitra' => 'Mitra',
			'bidang_usaha' => 'Bidang Usaha',
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
		$criteria->compare('mitra',$this->mitra,true);
		$criteria->compare('bidang_usaha',$this->bidang_usaha,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}