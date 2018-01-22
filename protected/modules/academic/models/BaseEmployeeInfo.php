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
 * This is the model class for table "employee_info".
 *
 * The followings are the available columns in table 'teacher_info':
 * @property integer $id
 * @property integer $employee
 * @property string $hire_date
 * @property string $country_of_birth
 * @property string $university_or_school
 * @property integer $number_of_year_of_study
 * @property integer $field_study
 * @property integer $qualification
 * @property integer $job_status
 * @property string $permis_enseignant
 * @property string $leaving_date
 * @property string $comments
 * @property string $date_created
 * @property string $date_updated
 * @property string $create_by
 * @property string $update_by
 *
 * The followings are the available model relations:
 * @property Persons $employee0
 * @property Qualifications $qualification0
 * @property FieldStudy $fieldStudy
 * @property JobStatus $jobStatus
 */
class BaseEmployeeInfo extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BaseEmployeeInfo the static model class
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
		return 'employee_info';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('employee', 'required'),
			array('employee, number_of_year_of_study, field_study, qualification, job_status', 'numerical', 'integerOnly'=>true),
			array('country_of_birth, university_or_school, permis_enseignant, create_by, update_by', 'length', 'max'=>45),
			array('hire_date, leaving_date, comments, date_created, date_updated', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, employee, hire_date, country_of_birth, permis_enseignant, university_or_school, number_of_year_of_study, field_study, qualification, job_status, leaving_date, comments, date_created, date_updated, create_by, update_by', 'safe', 'on'=>'search'),
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
			'employee0' => array(self::BELONGS_TO, 'Persons', 'employee'),
			'qualification0' => array(self::BELONGS_TO, 'Qualifications', 'qualification'),
			'fieldStudy' => array(self::BELONGS_TO, 'FieldStudy', 'field_study'),
			'jobStatus' => array(self::BELONGS_TO, 'JobStatus', 'job_status'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' =>Yii::t('app','ID'),
			'employee' =>Yii::t('app', 'Employee'),
			'hire_date' =>Yii::t('app', 'Hire Date'),
			'country_of_birth' =>Yii::t('app', 'Country of birth'),
			'university_or_school' =>Yii::t('app', 'University Or School'),
			'number_of_year_of_study' =>Yii::t('app', 'Number Of Year Of Study'),
			'field_study' =>Yii::t('app', 'Field Study'),
			'qualification' =>Yii::t('app', 'Qualification'),
			'job_status' =>Yii::t('app', 'Job Status'),
			'permis_enseignant'=>Yii::t('app', 'Permis Enseignant'),
			'leaving_date' =>Yii::t('app', 'Leaving Date'),
			'comments' =>Yii::t('app', 'Comments'),
			'date_created' =>Yii::t('app', 'Date Created'),
			'date_updated' =>Yii::t('app', 'Date Updated'),
			'create_by' =>Yii::t('app', 'Create By'),
			'update_by' =>Yii::t('app', 'Update By'),
		);
	}

	
}