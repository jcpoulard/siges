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
 * This is the model class for table "pending_balance".
 *
 * The followings are the available columns in table 'pending_balance':
 * @property integer $id
 * @property integer $student
 * @property double $balance
 * @property integer $is_paid
 * @property integer $academic_year
 * @property string $date_created
 *
 * The followings are the available model relations:
 * @property Academicperiods $academicYear
 * @property Persons $student0
 */
class PendingBalance extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PendingBalance the static model class
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
		return 'pending_balance';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('student, balance, academic_year', 'required'),
			array('student, is_paid, academic_year', 'numerical', 'integerOnly'=>true),
			array('balance', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, student, balance, is_paid, academic_year, date_created', 'safe', 'on'=>'search'),
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
			'academicYear' => array(self::BELONGS_TO, 'Academicperiods', 'academic_year'),
			'student0' => array(self::BELONGS_TO, 'Persons', 'student'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('app','ID'),
			'student' => Yii::t('app','Student'),
			'balance' => Yii::t('app','Balance'),
			'is_paid' => Yii::t('app','Is Paid'),
			'academic_year' => Yii::t('app','Academic Year'),
			'date_created' => Yii::t('app','Date Created'),
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
		$criteria->compare('student',$this->student);
		$criteria->compare('balance',$this->balance);
		$criteria->compare('is_paid',$this->is_paid);
		$criteria->compare('academic_year',$this->academic_year);
		$criteria->compare('date_created',$this->date_created,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}