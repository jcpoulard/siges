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
 * This is the model class for table "academicPeriods".
 *
 * The followings are the available columns in table 'academicPeriods':
 * @property integer $id
 * @property string $name_period
 * @property double $weight
 * @property integer $checked
 * @property string $date_start
 * @property string $date_end
 * @property integer $is_year
 * @property integer $previous_academic_year
 * @property integer $year
 * @property string $date_created
 * @property string $date_updated
 * @property string $create_by
 * @property string $update_by
 *
 * The followings are the available model relations:
 * @property BaseAcademicPeriods $year0
 * @property BaseAcademicPeriods $previousAcademicYear
 * @property BaseAcademicPeriods[] $academicPeriods
 * @property Courses[] $courses
 * @property EvaluationByYear[] $evaluationByYears
 * @property LevelHasPerson[] $levelHasPeople
 * @property RoomHasPerson[] $roomHasPeople
 */
class BaseAcademicPeriods extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BaseAcademicPeriods the static model class
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
		return 'academicperiods';
	}
        
        public $academic_year;
         public $previous_academic_year;

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name_period, date_start, date_end', 'required'),
			array('is_year,previous_academic_year,checked', 'numerical', 'integerOnly'=>true),
			array('weight', 'numerical', ),
			array('name_period, create_by, update_by', 'length', 'max'=>45),
			array('date_created, date_updated,year', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, academic_year, name_period, weight, checked, date_start, date_end, is_year,previous_academic_year, date_created, date_updated, create_by, update_by', 'safe', 'on'=>'search'),
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
			'year0' => array(self::BELONGS_TO, 'AcademicPeriods', 'year'),
			'previousAcademicYear' => array(self::BELONGS_TO, 'AcademicPeriods', 'previous_academic_year'),
			'academicPeriods' => array(self::HAS_MANY, 'AcademicPeriods', 'year'),
			'courses' => array(self::HAS_MANY, 'Courses', 'academic_period'),
			'evaluationByYears' => array(self::HAS_MANY, 'EvaluationByYear', 'academic_year'),
			'levelHasPeople' => array(self::HAS_MANY, 'LevelHasPerson', 'academic_year'),
			'roomHasPeople' => array(self::HAS_MANY, 'RoomHasPerson', 'academic_year'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' =>Yii::t('app','ID'),
			'name_period' =>Yii::t('app','Name Period'),
			'weight' => Yii::t('app', 'Weight'),
			'checked' => Yii::t('app', 'Checked'),
			'date_start' =>Yii::t('app','Date Start'),
			'date_end' =>Yii::t('app','Date End'),
			'is_year' =>Yii::t('app','Is Year'),
			'previous_academic_year'=>Yii::t('app','Previous Academic Year'),
			'year' =>Yii::t('app','Year'),
			'date_created' =>Yii::t('app','Date Created'),
			'date_updated' =>Yii::t('app','Date Updated'),
			'create_by' =>Yii::t('app','Create By'),
			'update_by' =>Yii::t('app','Update By'),
            'isYear'=>Yii::t('app','Is year?'),
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
		$criteria->compare('name_period',$this->name_period,true);
		$criteria->compare('weight',$this->weight,true);
		$criteria->compare('checked',$this->checked,true);
		$criteria->compare('date_start',$this->date_start,true);
		$criteria->compare('date_end',$this->date_end,true);
		$criteria->compare('is_year',$this->is_year);
		$criteria->compare('previous_academic_year',$this->previous_academic_year);
		$criteria->compare('year',$this->year);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('update_by',$this->update_by,true);
                $criteria->compare('year0.name_period', $this->academic_year, true);
		$criteria->with = array('year0');
		
		

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}