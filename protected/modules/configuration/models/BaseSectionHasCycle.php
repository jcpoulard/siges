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
 * This is the model class for table "section_has_cycle".
 *
* The followings are the available columns in table 'section_has_cycle':
 * @property integer $id
 * @property integer $cycle
 * @property integer $level
 * @property integer $section
  * @property integer $academic_year
 *
 * The followings are the available model relations:
 * @property Sections $section0
 * @property Cycles $cycle0
 * @property Levels $level0
 * @property AcademicPeriods $academic0
 */
class BaseSectionHasCycle extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BaseSectionHasCycle the static model class
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
		return 'section_has_cycle';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cycle, section, level,academic_year', 'required'),
			array('cycle, section, level,academic_year', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, cycle, section, level,academic_year', 'safe', 'on'=>'search'),
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
			'section0' => array(self::BELONGS_TO, 'Sections', 'section'),
			'level0' => array(self::BELONGS_TO, 'Levels', 'level'),
			'cycle0' => array(self::BELONGS_TO, 'Cycles', 'cycle'),
			'academic0' => array(self::BELONGS_TO, 'AcademicPeriods', 'academic_year'),
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
		$criteria->compare('cycle',$this->cycle);
		$criteria->compare('section',$this->section);
		$criteria->compare('level',$this->level);
		$criteria->compare('academic_year',$this->academic_year);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			
			'pagination'=>array(
                        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
                        ),
		));
	}
}