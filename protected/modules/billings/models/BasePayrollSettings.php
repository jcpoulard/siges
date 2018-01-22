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
 * This is the model class for table "payroll_settings".
 *
 * The followings are the available columns in table 'payroll_settings':
 * @property integer $id
 * @property integer $person_id
 * @property double $amount
 * @property integer $an_hour
 * @property integer $number_of_hour
 * @property integer $academic_year
 * @property integer $as
 * @property integer $old_new
 * @property string $date_created
 * @property string $date_updated
 * @property string $created_by
 * @property string $updated_by
 *
 * The followings are the available model relations:
 * @property Payroll[] $payrolls
 * @property Academicperiods $academicYear
 * @property Persons $person
 */
class BasePayrollSettings extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BasePayrollSettings the static model class
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
		return 'payroll_settings';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('person_id, amount, as, academic_year', 'required'),
			array('person_id, an_hour, as, old_new, academic_year', 'numerical', 'integerOnly'=>true),
			array('number_of_hour, amount', 'numerical'),
			array('created_by, updated_by', 'length', 'max'=>65),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, person_id, amount, an_hour,old_new, number_of_hour, as, academic_year, date_created, date_updated, created_by, updated_by', 'safe', 'on'=>'search'),
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
			'payrolls' => array(self::HAS_MANY, 'Payroll', 'id_payroll_set'),
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
			'person_id' => Yii::t('app','Person'),
			'amount' => Yii::t('app','Wage'),
			'an_hour' => Yii::t('app','An Hour'),
			'as' => Yii::t('app','As'),
			'old_new'=> Yii::t('app','New setting'),
			'number_of_hour'=> Yii::t('app','Number Of Hour'),
			'academic_year' => Yii::t('app','Academic Year'),
			'date_created' => Yii::t('app','Date Created'),
			'date_updated' => Yii::t('app','Date Updated'),
			'created_by' => Yii::t('app','Created By'),
			'updated_by' => Yii::t('app','Updated By'),
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
		$criteria->compare('person_id',$this->person_id);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('an_hour',$this->an_hour);
		$criteria->compare('number_of_hour',$this->number_of_hour);
		$criteria->compare('academic_year',$this->academic_year);
		$criteria->compare('as',$this->as);
		$criteria->compare('old_new',$this->old_new);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('created_by',$this->created_by,true);
		$criteria->compare('updated_by',$this->updated_by,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}