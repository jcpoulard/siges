<?php

/*
 * © 2015 LOGIPAM services / www.logipam.com siges@logipam.com et contributeurs (voir www.logipam.com)
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




class BaseEvaluationByYear extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'evaluation_by_year';
	}

	public function rules()
	{
		return array(
			array('evaluation, academic_year, evaluation_date', 'required'),
			array('evaluation, academic_year,last_evaluation', 'numerical', 'integerOnly'=>true),
			array('create_by, update_by', 'length', 'max'=>45),
			array('date_created, date_updated', 'safe'),
			array('id, evaluation, academic_year, last_evaluation, evaluation_date, date_created, date_updated, create_by, update_by', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'evaluation0' => array(self::BELONGS_TO, 'Evaluations', 'evaluation'),
			'academicYear' => array(self::BELONGS_TO, 'AcademicPeriods', 'academic_year'),
			'grades' => array(self::HAS_MANY, 'Grades', 'evaluation'),
			
		);
	}

	public function behaviors()
	{
		return array('CAdvancedArBehavior',
				array('class' => 'ext.CAdvancedArBehavior')
				);
	}

	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('app', 'ID'),
			'evaluation' => Yii::t('app', 'Evaluation'),
			'academic_year' => Yii::t('app', 'Academic Year'),
			'evaluation_date' => Yii::t('app', 'Evaluation Date'),
			'last_evaluation' => Yii::t('app', 'Last evaluation'),
			'date_created' => Yii::t('app', 'Date Created'),
			'date_updated' => Yii::t('app', 'Date Updated'),
			'create_by' => Yii::t('app', 'Create By'),
			'update_by' => Yii::t('app', 'Update By'),
			'evaluation0.examName'=>Yii::t('app','Exam Name'),
		);
	}


	


}
