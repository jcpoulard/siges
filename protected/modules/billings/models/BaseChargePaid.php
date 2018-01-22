<?php 
/*
 * © 2015 LOGIPAM services / www.logipam.com siges@logipam.com et contributeurs (voir www.logipam.com)
 * 
 * This file is part of SIGES.

    SIGES is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License.

    SIGES is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with SIGES.  If not, see <http://www.gnu.org/licenses/>.
 * 
 */




/**
 * This is the model class for table "charge_paid".
 *
 * The followings are the available columns in table 'charge_paid':
 * @property integer $id
 * @property integer $id_charge_description
 * @property double $amount
 * @property string $payment_date
 * @property integer $comment
 * @property integer $academic_year
 * @property string $created_by
 *
 * The followings are the available model relations:
 * @property BaseChargeDescription $idChargeDescription
 * @property Academicperiods $academicYear
 */
class BaseChargePaid extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BaseChargePaid the static model class
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
		return 'charge_paid';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_charge_description, amount, payment_date', 'required'),
			array('id_charge_description, academic_year', 'numerical', 'integerOnly'=>true),
			array('amount', 'numerical'),
			array('created_by', 'length', 'max'=>65),
			array('comment', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_charge_description,comment, amount, payment_date, month, academic_year, created_by', 'safe', 'on'=>'search'),
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
			'idChargeDescription' => array(self::BELONGS_TO, 'ChargeDescription', 'id_charge_description'),
			'academicYear' => array(self::BELONGS_TO, 'AcademicPeriods', 'academic_year'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('app','ID'),
			'id_charge_description' => Yii::t('app','Id Charge Description'),
			'amount' => Yii::t('app','Amount'),
			'payment_date' => Yii::t('app','Expense date'),
			'comment' => Yii::t('app','Comment'),
			'academic_year' => Yii::t('app','Academic Year'),
			'created_by' => Yii::t('app','Created By'),
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
		$criteria->compare('id_charge_description',$this->id_charge_description);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('payment_date',$this->payment_date,true);
		$criteria->compare('comment',$this->comment);
		$criteria->compare('academic_year',$this->academic_year);
		$criteria->compare('created_by',$this->created_by,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}