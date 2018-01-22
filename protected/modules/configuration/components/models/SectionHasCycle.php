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
class SectionHasCycle extends BaseSectionHasCycle
{
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	

public $cycle_description;
 


	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('app','ID'),
			'cycle' => Yii::t('app','Cycle'),
			'section' => Yii::t('app','Section'),
			'level' => Yii::t('app','Level'),
			'academic_year' => Yii::t('app','Academic Year'),
		);
	}




  public function getCycleBySectionIdLevelId($section,$level,$acad){
            
           
     $result=SectionHasCycle::model()->find(array('alias'=>'chs',
                        		     'select'=>'chs.cycle, c.cycle_description ',
                                     'join'=>'left join Cycles c on(c.id=chs.cycle)',
                                     'condition'=>'chs.section=:id AND chs.level=:idLvel AND chs.academic_year=:acad',
                                     'params'=>array(':id' => $section,':idLvel'=>$level,':acad'=>$acad),
                               ));
			
                
			
                    return $result;	
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