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
 * This is the model class for table "loan_of_money".
 *
* The followings are the available columns in table 'loan_of_money':
 * @property integer $id
 * @property string $loan_date
  * @property integer $person_id
 * @property double $amount
 * @property integer $payroll_month
 * @property integer $deduction_percentage
 * @property double $solde
 * @property integer $paid
 * @property integer $number_of_month_repayment
 * @property integer $remaining_month_number
  * @property integer $academic_year
 * @property string $date_created
 * @property string $date_updated
 * @property string $created_by
 *
 * The followings are the available model relations:
  * @property Academicperiods $academicYear
 * @property Persons $person
 */

class BaseLoanOfMoney extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BaseLoanOfMoney the static model class
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
		return 'loan_of_money';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('person_id,amount, deduction_percentage,payroll_month,number_of_month_repayment', 'required'),
			array('person_id,payroll_month, deduction_percentage, paid,number_of_month_repayment,remaining_month_number, academic_year', 'numerical', 'integerOnly'=>true),
			array('amount,solde', 'numerical'),
			array('created_by', 'length', 'max'=>65),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
						
			array('id, person_id, amount,solde, payroll_month, deduction_percentage, paid,number_of_month_repayment,remaining_month_number academic_year, loan_date, date_created, date_updated, created_by', 'safe', 'on'=>'search'),
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
			 'academicYear' => array(self::BELONGS_TO, 'AcademicPeriods', 'academic_year'),
			'person' => array(self::BELONGS_TO, 'Persons', 'person_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('app','ID'),
			'loan_date'=> Yii::t('app','Loan date'),
			'person_id' => Yii::t('app','Person'),
			'amount' => Yii::t('app','Initial Loan'),
			'payroll_month'=>Yii::t('app','Payroll Month'),
			'deduction_percentage' => Yii::t('app','Deduction Percentage'),
			'solde' => Yii::t('app','Solde'),
			'paid' => Yii::t('app','Paid'),
			'number_of_month_repayment' => Yii::t('app','Repayment deadline(numb. of month)'),
			'remaining_month_number' => Yii::t('app','Remaining month number'),
			'academic_year' => Yii::t('app','Academic Year'),
			'date_created' => Yii::t('app','Date Created'),
			'date_updated'=> Yii::t('app','Date Updated'),
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
		
		$criteria->with=array('academicYear');

		$criteria->compare('id',$this->id);
		$criteria->compare('person_id',$this->person_id);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('payroll_month',$this->payroll_month);
		$criteria->compare('deduction_percentage',$this->deduction_percentage);
		$criteria->compare('solde',$this->solde);
		$criteria->compare('paid',$this->paid);
		$criteria->compare('number_of_month_repayment',$this->number_of_month_repayment);
		$criteria->compare('remaining_month_number',$this->remaining_month_number);
		//$criteria->compare('academicYear.name_period',$this->academic_year);
		$criteria->compare('academic_year',$this->academic_year);
		$criteria->compare('loan_date',$this->date_created,true);
		$criteria->compare('date_created',$this->loan_date,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('created_by',$this->created_by,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}