<?php

/**
 * This is the model class for table "products".
 *
 * The followings are the available columns in table 'products':
 * @property integer $id
 * @property string $product_name
 
 * @property string $description
 * @property integer $stock_alert
 * @property string $create_by
 * @property string $update_by
 * @property string $date_create
 * @property string $date_update
 *
 * The followings are the available model relations:
 * @property TypeProducts $type0
 * @property Sellings[] $sellings
 * @property StockHistory[] $stockHistories
 * @property Stocks[] $stocks
 */
class BaseProducts extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BaseProducts the static model class
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
		return 'products';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('product_name', 'required'),
			array('stock_alert', 'numerical', 'integerOnly'=>true),
			array('product_name', 'length', 'max'=>128),
			array('create_by, update_by', 'length', 'max'=>64),
			array('description, date_create, date_update', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, product_name,buying_price,selling_price, description, stock_alert, create_by, update_by, date_create, date_update', 'safe', 'on'=>'search'),
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
			
			'sellings' => array(self::HAS_MANY, 'Sellings', 'id_products'),
			'stockHistories' => array(self::HAS_MANY, 'StockHistory', 'id_product'),
			'stocks' => array(self::HAS_MANY, 'Stocks', 'id_product'),
                        
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'product_name' => 'Product Name',
			
			'description' => 'Description',
			'stock_alert' => 'Stock Alert',
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
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('product_name',$this->product_name,true);
		
		$criteria->compare('description',$this->description,true);
		$criteria->compare('stock_alert',$this->stock_alert);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('update_by',$this->update_by,true);
		$criteria->compare('date_create',$this->date_create,true);
		$criteria->compare('date_update',$this->date_update,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}