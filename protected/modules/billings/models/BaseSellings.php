<?php

/**
 * This is the model class for table "sellings".
 *
 * The followings are the available columns in table 'sellings':
 * @property integer $id
 * @property integer $transaction_id
 * @property integer $id_products
 * @property integer $quantity
 * @property string $selling_date
 * @property string $client_name
 * @property string $sell_by
 * @property double $amount_receive
 * @property double $amount_selling
 * @property double $amount_balance
 * @property double $discount
 * @property string $update_by
 * @property string $update_date
 * @property double $unit_selling_price
 *
 * The followings are the available model relations:
 * @property Products $idProducts
 */
class BaseSellings extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BaseSellings the static model class
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
		return 'sellings';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('transaction_id, id_products, quantity, selling_date', 'required'),
			array('id, transaction_id, id_products, quantity', 'numerical', 'integerOnly'=>true),
			array('amount_receive, amount_selling, amount_balance, discount, unit_selling_price', 'numerical'),
			array('client_name', 'length', 'max'=>128),
			array('sell_by, update_by', 'length', 'max'=>64),
			array('update_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, transaction_id, id_products, quantity, selling_date, client_name, sell_by, amount_receive, amount_selling, amount_balance, discount, update_by, update_date, unit_selling_price', 'safe', 'on'=>'search'),
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
			'idProducts' => array(self::BELONGS_TO, 'Products', 'id_products'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'transaction_id' => 'Transaction',
			'id_products' => 'Id Products',
			'quantity' => 'Quantity',
			'selling_date' => 'Selling Date',
			'client_name' => 'Client Name',
			'sell_by' => 'Sell By',
			'amount_receive' => 'Amount Receive',
			'amount_selling' => 'Amount Selling',
			'amount_balance' => 'Amount Balance',
			'discount' => 'Discount',
			'update_by' => 'Update By',
			'update_date' => 'Update Date',
			'unit_selling_price' => 'Unit Selling Price',
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
		$criteria->compare('transaction_id',$this->transaction_id);
		$criteria->compare('id_products',$this->id_products);
		$criteria->compare('quantity',$this->quantity);
		$criteria->compare('selling_date',$this->selling_date,true);
		$criteria->compare('client_name',$this->client_name,true);
		$criteria->compare('sell_by',$this->sell_by,true);
		$criteria->compare('amount_receive',$this->amount_receive);
		$criteria->compare('amount_selling',$this->amount_selling);
		$criteria->compare('amount_balance',$this->amount_balance);
		$criteria->compare('discount',$this->discount);
		$criteria->compare('update_by',$this->update_by,true);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('unit_selling_price',$this->unit_selling_price);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}