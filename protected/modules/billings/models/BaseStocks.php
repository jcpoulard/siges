<?php

/**
 * This is the model class for table "stocks".
 *
 * The followings are the available columns in table 'stocks':
 * @property integer $id
 * @property integer $id_product
 * @property integer $quantity
 * @property string $acquisition_date
 * @property double $buiying_price
 * @property double $selling_price
 * @property integer $is_donation
 * @property string $create_by
 * @property string $update_by
 * @property string $date_create
 * @property string $date_update
 *
 * The followings are the available model relations:
 * @property StockHistory[] $stockHistories
 * @property Products $idProduct
 */
class BaseStocks extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BaseStocks the static model class
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
		return 'stocks';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_product, quantity, acquisition_date', 'required'),
			array('id_product, quantity, is_donation', 'numerical', 'integerOnly'=>true),
			array('buiying_price, selling_price', 'numerical'),
			array('create_by, update_by', 'length', 'max'=>64),
			array('date_create, date_update', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_product, product_name, quantity, acquisition_date, buiying_price, selling_price, is_donation, create_by, update_by, date_create, date_update', 'safe', 'on'=>'search'),
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
			'stockHistories' => array(self::HAS_MANY, 'StockHistory', 'id_stock'),
			'idProduct' => array(self::BELONGS_TO, 'Products', 'id_product'),
                    
                        
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_product' => 'Id Product',
			'quantity' => 'Quantity',
			'acquisition_date' => 'Acquisition Date',
			'buiying_price' => 'Buiying Price',
			'selling_price' => 'Selling Price',
			'is_donation' => 'Is Donation',
			'create_by' => 'Create By',
			'update_by' => 'Update By',
			'date_create' => 'Date Create',
			'date_update' => 'Date Update',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
        /*
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('id_product',$this->id_product);
		$criteria->compare('quantity',$this->quantity);
		$criteria->compare('acquisition_date',$this->acquisition_date,true);
		$criteria->compare('buiying_price',$this->buiying_price);
		$criteria->compare('selling_price',$this->selling_price);
		$criteria->compare('is_donation',$this->is_donation);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('update_by',$this->update_by,true);
		$criteria->compare('date_create',$this->date_create,true);
		$criteria->compare('date_update',$this->date_update,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
         * 
         */
}