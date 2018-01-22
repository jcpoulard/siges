<?php

/**
 * This is the model class for table "return_history".
 *
 * The followings are the available columns in table 'return_history':
 * @property integer $id
 * @property integer $id_transaction
 * @property integer $id_product
 * @property double $return_amount
 * @property integer $return_quantity
 * @property string $date_return
 * @property string $return_by
 */
class BaseReturnHistory extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BaseReturnHistory the static model class
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
		return 'return_history';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_transaction, id_product, return_amount, return_quantity, date_return, return_by', 'required'),
			array('id_transaction, id_product, return_quantity', 'numerical', 'integerOnly'=>true),
			array('return_amount', 'numerical'),
			array('return_by', 'length', 'max'=>32),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_transaction, id_product, return_amount, return_quantity, date_return, return_by', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_transaction' => 'Id Transaction',
			'id_product' => 'Id Product',
			'return_amount' => 'Return Amount',
			'return_quantity' => 'Return Quantity',
			'date_return' => 'Date Return',
			'return_by' => 'Return By',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('id_transaction',$this->id_transaction);
		$criteria->compare('id_product',$this->id_product);
		$criteria->compare('return_amount',$this->return_amount);
		$criteria->compare('return_quantity',$this->return_quantity);
		$criteria->compare('date_return',$this->date_return,true);
		$criteria->compare('return_by',$this->return_by,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}