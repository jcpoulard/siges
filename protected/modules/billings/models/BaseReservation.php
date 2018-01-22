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

?>
<?php

/**
 * This is the model class for table "reservation".
 *
 * The followings are the available columns in table 'reservation':
 * @property integer $id
 * @property integer $postulant_student
 * @property integer $is_student
 * @property double $amount
 * @property integer $payment_method
 * @property string $payment_date
 * @property integer $already_checked
 * @property string $comments
 * @property integer $academic_year
 * @property string $date_created
 * @property string $date_updated
 * @property string $create_by
 * @property string $update_by
 */
class BaseReservation extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Reservation the static model class
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
		return 'reservation';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('postulant_student, is_student, amount, payment_method, payment_date, academic_year', 'required'),
			array('postulant_student, is_student, payment_method, already_checked, academic_year', 'numerical', 'integerOnly'=>true),
			array('amount', 'numerical'),
			array('comments', 'length', 'max'=>255),
			array('create_by, update_by', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			//array('id, postulant_student, is_student, amount, payment_method, payment_date, already_checked, comments, academic_year, date_created, date_updated, create_by, update_by', 'safe', 'on'=>'search'),
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
			'id' => Yii::t('app', 'ID'),
			'postulant_student' => Yii::t('app', 'Postulant Student'),
			'is_student' => Yii::t('app', 'Is Student'),
			'amount' => Yii::t('app', 'Amount'),
			'payment_method' => Yii::t('app', 'Payment Method'),
			'payment_date' => Yii::t('app', 'Payment Date'),
			'already_checked' => Yii::t('app', 'Already Checked'),
			'comments' => Yii::t('app', 'Comments'),
			'academic_year' => Yii::t('app', 'Academic Year'),
			'date_created' => Yii::t('app', 'Date Created'),
			'date_updated' => Yii::t('app', 'Date Updated'),
			'create_by' => Yii::t('app', 'Create By'),
			'update_by' => Yii::t('app', 'Update By'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('postulant_student',$this->postulant_student);
		$criteria->compare('is_student',$this->is_student);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('payment_method',$this->payment_method);
		$criteria->compare('payment_date',$this->payment_date,true);
		$criteria->compare('already_checked',$this->already_checked);
		$criteria->compare('comments',$this->comments,true);
		$criteria->compare('academic_year',$this->academic_year);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('update_by',$this->update_by,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}*/
}