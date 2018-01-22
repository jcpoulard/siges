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



class Devises extends BaseDevises
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	//public $arroondissement_name;
  public function rules()
	{
              
              return array_merge(
		    	parent::rules(), array(
			//array('devise_name, devise_symbol', 'required'),
			array('id', 'numerical', 'integerOnly'=>true),
			array('devise_name, devise_symbol, create_by, update_by', 'length', 'max'=>45),
			array('description, date_create, date_update', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, devise_name, devise_symbol, description, date_create, date_update, create_by, update_by', 'safe', 'on'=>'search'),
				                   // array('',''),
									
									));
	}
	
    
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('devise_name',$this->devise_name,true);
		$criteria->compare('devise_symbol',$this->devise_symbol,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('date_create',$this->date_create,true);
		$criteria->compare('date_update',$this->date_update,true);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('update_by',$this->update_by,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>array(
                        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
                        ),

		));
	}
	
}
