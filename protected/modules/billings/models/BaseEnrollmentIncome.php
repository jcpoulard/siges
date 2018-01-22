<?php 
/*
 * © 2010 LOGIPAM services / www.logipam.com siges@logipam.com et contributeurs (voir www.logipam.com)
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

?>
<?php

/**
 * This is the model class for table "enrollment_income".
 *
 * The followings are the available columns in table 'enrollment_income':
 * @property integer $id
 * @property integer $postulant
 * @property integer $apply_level
 * @property double $amount
 * @property integer $payment_method
 * @property string $comments
 * @property string $payment_date
 * @property string $academic_year
 * @property string $date_created
 * @property string $date_updated
 * @property string $create_by
 * @property string $update_by
 *
 * The followings are the available model relations:
 * @property Levels $applyLevel
 */
class BaseEnrollmentIncome extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return EnrollmentIncome the static model class
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
		return 'enrollment_income';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('postulant, apply_level, amount, payment_date', 'required'),
			array('postulant, apply_level,academic_year,payment_method', 'numerical', 'integerOnly'=>true),
			array('amount', 'numerical'),
			array('create_by, update_by', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, postulant, apply_level, amount, paymentMethod, comments, payment_date, academic_year, date_created, date_updated, create_by, update_by', 'safe', 'on'=>'search'),
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
			'academicPeriod' => array(self::BELONGS_TO, 'Academicperiods', 'academic_year'),
			'applyLevel' => array(self::BELONGS_TO, 'Levels', 'apply_level'),
			'paymentMethod' => array(self::BELONGS_TO, 'PaymentMethod', 'payment_method'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('app','ID'),
			'postulant' => Yii::t('app','Postulant'),
			'apply_level' => Yii::t('app','Apply for level'),
			'amount' => Yii::t('app','Amount'),
			'payment_method' =>Yii::t('app', 'Payment Method'),
			'comments' =>Yii::t('app', 'Comments'),
			'payment_date' => Yii::t('app','Payment Date'),
			'academic_year' => Yii::t('app','Academic Year'),
			'date_created' => Yii::t('app','Date Create'),
			'date_updated' => Yii::t('app','Date Update'),
			'create_by' => Yii::t('app','Create By'),
			'update_by' => Yii::t('app','Update By'),
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
		$criteria->compare('postulant',$this->postulant);
		$criteria->compare('apply_level',$this->apply_level);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('payment_method',$this->payment_method);
		$criteria->compare('comments',$this->comments,true);
		$criteria->compare('payment_date',$this->payment_date,true);
		$criteria->compare('academic_year',$this->academic_year,true);
		$criteria->compare('date_created',$this->date_create,true);
		$criteria->compare('date_updated',$this->date_update,true);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('update_by',$this->update_by,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	*/
}