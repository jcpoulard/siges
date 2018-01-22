<?php 
/*
 * © 2016 LOGIPAM services / www.logipam.com siges@logipam.com et contributeurs (voir www.logipam.com)
 * 
 * This file is part of SIGES.

    SIGES is a free software: you can redistribute it and/or modify
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
 * This is the model class for table "year_migration_check".
 *
 * The followings are the available columns in table 'year_migration_check':
 * @property integer $id
 * @property integer $academic_year
 * @property integer $period
 * @property integer $postulant
 * @property integer $student
 * @property integer $course
 * @property integer $evaluation
 * @property integer $passing_grade
 * @property integer $reportcard_observation
 * @property integer $fees
 * @property integer $taxes
 * @property integer $pending_balance
 * @property string $date_created
 * @property string $date_updated
 * @property string $create_by
 * @property string $update_by
 *
 * The followings are the available model relations:
 * @property Academicperiods $academicYear
 */
class YearMigrationCheck extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return YearMigrationCheck the static model class
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
		return 'year_migration_check';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('academic_year, period, postulant, student, course, evaluation, passing_grade, reportcard_observation, fees, taxes, pending_balance, date_created,create_by', 'required'),
			array('academic_year, period, postulant, student, course, evaluation, passing_grade, reportcard_observation, fees, taxes, pending_balance', 'numerical', 'integerOnly'=>true),
			array('create_by, update_by', 'length', 'max'=>65),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, academic_year, period, postulant, student, course, evaluation, passing_grade, reportcard_observation, fees, taxes, pending_balance, date_created, date_updated, create_by, update_by', 'safe', 'on'=>'search'),
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
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('academic_year',$this->academic_year);
		$criteria->compare('period',$this->period);
		$criteria->compare('postulant',$this->postulant);
		$criteria->compare('student',$this->student);
		$criteria->compare('course',$this->course);
		$criteria->compare('evaluation',$this->evaluation);
		$criteria->compare('passing_grade',$this->passing_grade);
		$criteria->compare('reportcard_observation',$this->reportcard_observation);
		$criteria->compare('fees',$this->fees);
		$criteria->compare('taxes',$this->taxes);
		$criteria->compare('pending_balance',$this->pending_balance);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('update_by',$this->update_by,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	
public function getValueYearMigrationCheck($acad)
{
   $command= Yii::app()->db->createCommand('SELECT period,postulant,student,course,evaluation,passing_grade,reportcard_observation,fees,taxes,pending_balance,date_created FROM year_migration_check WHERE academic_year='.$acad); 
	
	     $data_ = $command->queryAll();
    
	return $data_;
       
  }
  	
	
	
	
	
	
}