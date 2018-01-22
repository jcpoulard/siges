<?php

/**
 * This is the model class for table "stock_history".
 *
 * The followings are the available columns in table 'stock_history':
 * @property integer $id_stock
 * @property integer $id_product
 * @property integer $quantity
 * @property string $buying_date
 * @property double $buying_price
 * @property double $selling_price
 * @property string $create_by
 * @property string $create_date
 *
 * The followings are the available model relations:
 * @property Stocks $idStock
 * @property Products $idProduct
 */
class BaseStockHistory extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BaseStockHistory the static model class
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
		return 'stock_history';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_stock, id_product, quantity, buying_date, buying_price, selling_price, create_by, create_date', 'required'),
			array('id_stock, id_product, quantity', 'numerical', 'integerOnly'=>true),
			array('buying_price, selling_price', 'numerical'),
			array('create_by', 'length', 'max'=>64),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_stock, id_product, quantity, buying_date, buying_price, selling_price, create_by, create_date', 'safe', 'on'=>'search'),
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
			'idStock' => array(self::BELONGS_TO, 'Stocks', 'id_stock'),
			'idProduct' => array(self::BELONGS_TO, 'Products', 'id_product'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_stock' => 'Id Stock',
			'id_product' => 'Id Product',
			'quantity' => 'Quantity',
			'buying_date' => 'Buying Date',
			'buying_price' => 'Buying Price',
			'selling_price' => 'Selling Price',
			'create_by' => 'Create By',
			'create_date' => 'Create Date',
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

		$criteria->compare('id_stock',$this->id_stock);
		$criteria->compare('id_product',$this->id_product);
		$criteria->compare('quantity',$this->quantity);
		$criteria->compare('buying_date',$this->buying_date,true);
		$criteria->compare('buying_price',$this->buying_price);
		$criteria->compare('selling_price',$this->selling_price);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('create_date',$this->create_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}