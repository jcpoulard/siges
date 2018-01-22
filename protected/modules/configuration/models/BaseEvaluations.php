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



class BaseEvaluations extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'evaluations';
	}

	public function rules()
	{
		return array(
			array('evaluation_name', 'required'),
			array('evaluation_name', 'length', 'max'=>64),
			array('weight', 'numerical'),
			array('create_by, update_by', 'length', 'max'=>45),
			array('date_created, date_updated', 'safe'),
			array('id, weight, evaluation_name, academic_year, date_created, date_updated, create_by, update_by', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'evaluationByYears' => array(self::HAS_MANY, 'EvaluationByYear', 'evaluation'),
			'academicYear' => array(self::BELONGS_TO, 'AcademicPeriods', 'academic_year'),
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
			'evaluation_name' => Yii::t('app', 'Evaluation Name'),
			'weight'=> Yii::t('app', 'Weight '),
			'academic_year'=> Yii::t('app', 'Academic Year'),
			'date_created' => Yii::t('app', 'Date Created'),
			'date_updated' => Yii::t('app', 'Date Updated'),
			'create_by' => Yii::t('app', 'Create By'),
			'update_by' => Yii::t('app', 'Update By'),
			'evaluation0.examName'=>Yii::t('app','Exam Name'),
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->with=array('academicYear');

		$criteria->compare('id',$this->id);

		$criteria->compare('evaluation_name',$this->evaluation_name,true);
		
		$criteria->compare('weight',$this->weight,true);
		
		$criteria->compare('academic_year',$this->academic_year,true);

		$criteria->compare('date_created',$this->date_created,true);

		$criteria->compare('date_updated',$this->date_updated,true);

		$criteria->compare('create_by',$this->create_by,true);

		$criteria->compare('update_by',$this->update_by,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}
