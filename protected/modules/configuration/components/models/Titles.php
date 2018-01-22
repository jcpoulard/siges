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



class Titles extends BaseTitles
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
  public function rules()
	{
              
              return array_merge(
		    	parent::rules(), array(
                            
                             array('title_name','unique'),
                             array('date_created,date_updated','unsafe'),
                           
									
									));
	}
	
      		 // return the name of title in a specific the person 
        public function getTitles($idPerson){
            
            $criteria = new CDbCriteria;
			
			$criteria->condition = 'pt.persons_id=:idPers ';
			$criteria->params = array(':idPers' => $idPerson);
		    
			$criteria->alias = 't';
			$criteria->select = 't.id, t.title_name ';
			$criteria->join = 'left join persons_has_titles pt on (t.id = pt.titles_id) ';
			
		    
			
			
			
    return new CActiveDataProvider($this, array(
        'criteria'=>$criteria,
        'pagination'=>array(
        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    			),
    ));
	
	    }
	    
	    

public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);

		$criteria->compare('title_name',$this->title_name,true);

		$criteria->compare('date_created',$this->date_created,true);

		$criteria->compare('date_updated',$this->date_updated,true);

		$criteria->compare('create_by',$this->create_by,true);

		$criteria->compare('update_by',$this->update_by,true);

		return new CActiveDataProvider(get_class($this), array(
			'pagination'=>array(
	        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
	    			),
	        
	        'criteria'=>$criteria,
		));
	}
	
	
	

	
}
