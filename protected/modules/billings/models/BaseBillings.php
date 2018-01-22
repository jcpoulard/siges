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
 * This is the model class for table "billings".
 *
 * The followings are the available columns in table 'billings':
 * @property string $id
 * @property integer $student
 * @property integer $fee_period
 * @property double $amount_to_pay
 * @property double $amount_pay
 * @property double $balance
 * @property string $date_pay
 * @property integer $payment_method
 * @property string $comments
 * @property string $date_created
 * @property string $date_updated
 * @property string $created_by
 * @property string $updated_by
 *
 * The followings are the available model relations:
 * @property Fees $feePeriod
 * @property Persons $student0
 * @property PaymentMethod $paymentMethod
 */

class BaseBillings extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BaseBillings the static model class
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
		return 'billings';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		// amount_to_pay, amount_pay,
		return array(
			array('student, fee_period, academic_year, amount_pay,', 'required'),
			array('student, fee_period, academic_year, payment_method', 'numerical', 'integerOnly'=>true),
			array('amount_to_pay, amount_pay, balance', 'numerical'),
			array('created_by, updated_by', 'length', 'max'=>64),
			array('comments, date_created, date_updated', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			//array('id, student, fee_period, amount_to_pay, amount_pay, balance, date_pay, payment_method, comments, date_created, date_updated, created_by, updated_by', 'safe', 'on'=>'search'),
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
			'feePeriod' => array(self::BELONGS_TO, 'Fees', 'fee_period'),
			'student0' => array(self::BELONGS_TO, 'Persons', 'student'),
			'academicperiods0'=>array(self::BELONGS_TO, 'AcademicPeriods', 'academic_year'),
			'paymentMethod' => array(self::BELONGS_TO, 'PaymentMethod', 'payment_method'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' =>Yii::t('app','Transaction ID'),
			'student' =>Yii::t('app','Student'),
			'fee_period' =>Yii::t('app', 'Fee Period'),
			'amount_to_pay' =>Yii::t('app', 'Amount To Pay'),
			'amount_pay' =>Yii::t('app', 'Amount Pay'),
			'balance' =>Yii::t('app', 'Balance'),
			'academic_year' =>Yii::t('app', 'Academic year'),
			'date_pay' =>Yii::t('app', 'Date Pay'),
			'payment_method' =>Yii::t('app', 'Payment Method'),
			'comments' =>Yii::t('app', 'Comments'),
			'date_created' =>Yii::t('app', 'Date Created'),
			'date_updated' =>Yii::t('app', 'Date Updated'),
			'created_by' =>Yii::t('app', 'Created By'),
			'updated_by' =>Yii::t('app', 'Updated By'),
			'student0.fullName'=>Yii::t('app','Student name'),
			'is_only_balance'=>Yii::t('app','Update balance only?'),
			'balance_to_pay'=>Yii::t('app','Balance to pay'),
                        'amountToPay'=>Yii::t('app','Amount To Pay'),
                        'amountPay'=>Yii::t('app','Amount Pay'),
                        'BalanceCurrency'=>YII::t('app','Balance'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
/*	public function search()
	{
		// Warning: Please modify the following id to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('student',$this->student);
		$criteria->compare('fee_period',$this->fee_period);
		$criteria->compare('amount_to_pay',$this->amount_to_pay);
		$criteria->compare('amount_pay',$this->amount_pay);
		$criteria->compare('balance',$this->balance);
		$criteria->compare('date_pay',$this->date_pay,true);
		$criteria->compare('payment_method',$this->payment_method);
		$criteria->compare('comments',$this->comments,true);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('created_by',$this->created_by,true);
		$criteria->compare('updated_by',$this->updated_by,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	*/
}