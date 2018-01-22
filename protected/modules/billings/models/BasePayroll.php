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
 * This is the model class for table "payroll".
 *
 * The followings are the available columns in table 'payroll':
 * @property integer $id
 * @property integer $id_payroll_set
 * @property integer $id_payroll_set2
 * @property integer $payroll_month
 * @property string $payroll_date
 * @property integer $number_of_hour
 * @property integer $missing_hour
 * @property string $cash_check
 * @property string $taxe
 * @property double $net_salary
 * @property string $payment_date
 *
 * The followings are the available model relations:
 * @property BasePayrollSettings $idPayrollSet
 */
class BasePayroll extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BasePayroll the static model class
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
		return 'payroll';
	}


	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array(' payroll_month, net_salary, payroll_date, payment_date', 'required'),
			array('id_payroll_set, payroll_month', 'numerical', 'integerOnly'=>true),
			array('missing_hour, net_salary,taxe', 'numerical'),
			array('cash_check', 'length', 'max'=>45),
			//array('taxe', 'length', 'max'=>65),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_payroll_set, id_payroll_set2, payroll_month, payroll_date, cash_check, number_of_hour, missing_hour, taxe, net_salary, payment_date', 'safe', 'on'=>'search'),
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
			'idPayrollSet' => array(self::BELONGS_TO, 'PayrollSettings', 'id_payroll_set'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_payroll_set' =>  Yii::t('app','Id Payroll Set'),
			'payroll_month' =>  Yii::t('app','Payroll Month'),
			'payroll_date' =>  Yii::t('app','Payroll Date'),
			'missing_hour'=> Yii::t('app','Missing hour'),
			'taxe' => Yii::t('app','Taxe'),
			'net_salary' => Yii::t('app','Net Salary'),
			'payment_date' =>  Yii::t('app','Payment Date'),
			'cash_check'=>  Yii::t('app','Cash/Check'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 *
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		

		$criteria->compare('id',$this->id);
		$criteria->compare('id_payroll_set',$this->id_payroll_set);
		$criteria->compare('id_payroll_set2',$this->id_payroll_set2);
		$criteria->compare('payroll_month',$this->payroll_month);
		$criteria->compare('payroll_date',$this->payroll_date,true);
		$criteria->compare('taxe',$this->taxe,true);
		$criteria->compare('cash_check',$this->cash_check,true);
		$criteria->compare('net_salary',$this->net_salary);
		$criteria->compare('payment_date',$this->payment_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	*/
}