<?php

/**
 * This is the model class for table "sale_transaction".
 *
 * The followings are the available columns in table 'sale_transaction':
 * @property integer $id
 * @property integer $id_transaction
 * @property double $amount_sale
 * @property double $discount
 * @property double $amount_receive
 * @property double $amount_balance
 * @property integer $academic_year
 * @property string $create_by
 * @property string $create_date
 * @property string $update_by
 * @property string $update_date
 */
class BaseSaleTransaction extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BaseSaleTransaction the static model class
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
		return 'sale_transaction';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_transaction, amount_sale, amount_receive, amount_balance', 'required'),
			array('id_transaction,academic_year', 'numerical', 'integerOnly'=>true),
			array('amount_sale, discount, amount_receive, amount_balance', 'numerical'),
			array('create_by, update_by', 'length', 'max'=>64),
			array('create_date, update_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_transaction, amount_sale,academic_year, discount, amount_receive, amount_balance, create_by, create_date, update_by, update_date', 'safe', 'on'=>'search'),
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
			'amount_sale' => 'Amount Sale',
			'discount' => 'Discount',
			'amount_receive' => 'Amount Receive',
			'amount_balance' => 'Amount Balance',
			'academic_year'=>'Academic Year',
			'create_by' => 'Create By',
			'create_date' => 'Create Date',
			'update_by' => 'Update By',
			'update_date' => 'Update Date',
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
		$criteria->compare('amount_sale',$this->amount_sale);
		$criteria->compare('discount',$this->discount);
		$criteria->compare('amount_receive',$this->amount_receive);
		$criteria->compare('amount_balance',$this->amount_balance);
		$criteria->compare('academic_year',$this->academic_year);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('update_by',$this->update_by,true);
		$criteria->compare('update_date',$this->update_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}