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
 * This is the model class for table "mutual_loan".
 *
 * The followings are the available columns in table 'mutual_loan':
 * @property integer $id
 * @property integer $person_id
 * @property string $loan_date
 * @property double $amount
 * @property double $interet
 * @property double $solde
 * @property integer $paid
 * @property string $date_updated
 *
 * The followings are the available model relations:
 * @property Persons $person
 */
class BaseMutualLoan extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MutualLoan the static model class
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
		return 'mutual_loan';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('person_id, loan_date, amount, interet, solde, date_updated', 'required'),
			array('person_id, paid', 'numerical', 'integerOnly'=>true),
			array('amount, interet, solde', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, person_id, loan_date, amount, interet, solde, paid, date_updated', 'safe', 'on'=>'search'),
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
			'person_id' => Yii::t('app','Person'),
			'loan_date' => Yii::t('app','Loan date'),
			'amount' => Yii::t('app','Amount'),
			'interet' => Yii::t('app','Interet'),
			'solde' => Yii::t('app','Solde'),
			'paid' => Yii::t('app','Paid'),
			'date_updated' => Yii::t('app','Date Updated'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
/*	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('person_id',$this->person_id);
		$criteria->compare('loan_date',$this->loan_date,true);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('interet',$this->interet);
		$criteria->compare('solde',$this->solde);
		$criteria->compare('paid',$this->paid);
		$criteria->compare('date_updated',$this->date_updated,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	*/
	
	
}