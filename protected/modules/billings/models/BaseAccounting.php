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
 * This is the model class for table "accounting".
 *
 * The followings are the available columns in table 'accounting':
 * @property integer $id
 * @property double $old_balance
 * @property double $outgoings
 * @property double $incomings
 * @property double $new_balance
 * @property integer $month
 * @property integer $academic_year
 *
 * The followings are the available model relations:
 * @property Academicperiods $academicYear
 */
class BaseAccounting extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BaseAccounting the static model class
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
		return 'accounting';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('old_balance, outgoings, incomings, new_balance, month, academic_year', 'required'),
			array('month, academic_year', 'numerical', 'integerOnly'=>true),
			array('old_balance, outgoings, incomings, new_balance', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, old_balance, outgoings, incomings, new_balance, month, academic_year', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'old_balance' => Yii::t('app','Old Balance'),
			'outgoings' => Yii::t('app','Outgoings'),
			'incomings' => Yii::t('app','Incomings'),
			'new_balance' => Yii::t('app','New Balance'),
			'month' => Yii::t('app','Month'),
			'academic_year' => Yii::t('app','Academic Year'),
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
		$criteria->compare('old_balance',$this->old_balance);
		$criteria->compare('outgoings',$this->outgoings);
		$criteria->compare('incomings',$this->incomings);
		$criteria->compare('new_balance',$this->new_balance);
		$criteria->compare('month',$this->month);
		$criteria->compare('academic_year',$this->academic_year);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}