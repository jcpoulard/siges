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



	
// auto-loading



class Cities extends BaseCities
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public $arroondissement_name;
  public function rules()
	{
              
              return array_merge(
		    	parent::rules(), array(
                            array('date_created, date_updated','unsafe'),
                            array('city_name','unique'),
                            array('id, city_name, arrondissement_name, date_created, date_updated, create_by, update_by', 'safe', 'on'=>'search'),
				                  
									
                                ));
	}
	
    
public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with=array('arrondissement0');

		$criteria->compare('id',$this->id);
		$criteria->compare('city_name',$this->city_name,true);
		$criteria->compare('arrondissement0.arrondissement_name',$this->arrondissement_name,true);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('update_by',$this->update_by,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
}
