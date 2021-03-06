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



class GeneralConfig extends BaseGeneralConfig
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
        
      public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('item_name',$this->item_name,true);
                $criteria->compare('name',$this->name,true);
		$criteria->compare('item_value',$this->item_value,true);
                $criteria->compare('description',$this->description,true);
                $criteria->compare('english_comment',$this->english_comment,true);
                $criteria->compare('category',$this->category,true);
		$criteria->compare('date_create',$this->date_create,true);
		$criteria->compare('date_update',$this->date_update,true);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('update_by',$this->update_by,true);
                $criteria->order = 'category ASC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>array(
                        'pageSize'=>10000,
                        ),
		));
	} 
        
           
        public function getSessionTimeout(){
            $sessiontimeout = 600;
            $gc = GeneralConfig::model()->findAll();

            foreach($gc as $g){
            if($g['item_name']=='timeout'){
            $sessiontimeout = $g['item_value'];
            }
            else {
                $sessiontimeout;
            }
            }  
            return $sessiontimeout;
        }
        
        public function getCategoryName()
         {
     return array(
         'acad'=>Yii::t('app','Academic'),
         'disc'=>Yii::t('app','Discipline'),
         'econ'=>Yii::t('app','Billings'),
         'sys'=>Yii::t('app','System'),
         
     );
 } 
 
 public function getCategoryRname()
	{
                        switch($this->category)
                        {
                                case 'acad':
                                    return Yii::t('app','Academic');
                                    break;
                                case 'disc':
                                     return Yii::t('app','Discipline');
                                     break;
                                case 'econ':
                                    return Yii::t('app','Economat');
                                    break;
                                 case 'sys':
                                    return Yii::t('app','System');
                                    break;

                                }
        }
        
        


	
}
