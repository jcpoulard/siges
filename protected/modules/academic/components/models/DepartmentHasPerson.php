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






class DepartmentHasPerson extends BaseDepartmentHasPerson
{


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	
	
	public function rules()
	{
		return array_merge(
		    	parent::rules(), array(
			//make date_created, date_update unsafe 
			array('date_created, date_updated', 'unsafe'),
			
			
			array('id, department_id, employee, date_created, date_updated, created_by, updated_by', 'safe', 'on'=>'search'),
		));
	}

	
	
	
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('department_id',$this->department_id);
		$criteria->compare('employee',$this->employee);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('created_by',$this->created_by,true);
		$criteria->compare('updated_by',$this->updated_by,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	
} 
