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




/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ReportcardObservation extends BaseReportcardObservation
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        

public $section_name;
public $all_sections;
 
   
        public function rules()
	{
              
              return array_merge(
		    	parent::rules(), array(
			));
	}
        
        public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'section'=>Yii::t('app','Section'),
			'start_range' =>Yii::t('app','Start range'),
			'end_range' =>Yii::t('app', 'End range'),
			'comment' =>Yii::t('app', 'Comment'),
			'academic_year' => Yii::t('app', 'Academic year'),
			'create_by' => Yii::t('app', 'Create by'),
			'update_by' => Yii::t('app', 'Update by'),
			'create_date' => Yii::t('app', 'Create date'),
			'update_date' => Yii::t('app', 'Update date'),
			'all_sections'=> Yii::t('app', 'All sections'),
		);
	}
	
	
	public function search($acad)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with=array('section0');
		
		//$criteria->alias='ro';
		$criteria->condition='academic_year='.$acad;
		

		$criteria->compare('id',$this->id);
		$criteria->compare('section',$this->section);
		$criteria->compare('section0.section_name',$this->section_name);
		$criteria->compare('start_range',$this->start_range);
		$criteria->compare('end_range',$this->end_range);
		$criteria->compare('comment',$this->comment,true);
		$criteria->compare('academic_year',$this->academic_year);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('update_by',$this->update_by,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('update_date',$this->update_date,true);

		return new CActiveDataProvider($this, array(
			'pagination'=>array(
        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    			),
			'criteria'=>$criteria,
		));
	}
	
	
	
	
	
	
	
}




