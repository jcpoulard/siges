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






class CustomFieldData extends BaseCustomFieldData
{


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	
	
	public function rules()
	{
		return array_merge(
		    	parent::rules(), array(
                           
			));
	}
        
        public function getCustomFieldValue($id_object,$id_field){
            $customFieldValue = null;
            $criteria = new CDbCriteria;
            $criteria->condition = "field_link = $id_field AND object_id = $id_object";
            $data = CustomFieldData::model()->findAll($criteria);
            foreach($data as $d){
                $customFieldValue = $d->field_data;
            }
            if($customFieldValue!=null){
                return $customFieldValue; 
            }else
                return '';
        }
        
        public function loadCustomFieldValue($id_object, $id_field){
            $fieldDataId = null;
            $criteria = new CDbCriteria;
            $criteria->condition = "field_link = $id_field AND object_id = $id_object";
            $data = CustomFieldData::model()->findAll($criteria);
            foreach($data as $d){
                $fieldDataId = $d->id;
            }
            
            
            $model=CustomFieldData::model()->findByPk($fieldDataId);
                if($model===null){
                    
                }
			//throw new CHttpException(404,'The requested page does not exist.');
		return $model;
            
        }
        
        public function loadCustomFieldDataByPersonId($id_object){
             $fieldDataId = null;
            $criteria = new CDbCriteria;
            $criteria->condition = "object_id = $id_object";
            $data = CustomFieldData::model()->findAll($criteria);
            
            
            
		if($data===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $data;
        }

	
	

	
	
} 
