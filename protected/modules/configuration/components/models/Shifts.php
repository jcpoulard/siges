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



class Shifts extends BaseShifts
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
  public function rules()
	{
              
              return array_merge(
		    	parent::rules(), array(
                            //Make Shift Unique 
                            array('shift_name','unique'),
                            //Set the date_created and date_updated to unsafe 
                            array('date_created,date_updated','unsafe'),
                            array('time_start','timescompare'),
				                  
									
									));
	}
        
           // Compare two times 
        
        public function timescompare($attribute, $params){
            $message = Yii::t('yii','{attribute} must be greater than "{compareValue}".');
            if(strtotime($this->time_end) < strtotime($this->time_start))
            {
                $params = array(
                    '{attribute}'=>$this->time_end, '{compareValue}'=>$this->time_start
                );
                $this->addError('time_end', strtr($message, $params));
            }
        }
        
        public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('shift_name',$this->shift_name,true);
		$criteria->compare('time_start',$this->time_start,true);
		$criteria->compare('time_end',$this->time_end,true);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('update_by',$this->update_by,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>array(
                        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
                        ),
		));
	}
	
	
	public function searchTimesByRoomId($room_id)
    {
	   $criteria=new CDbCriteria;

		$criteria->condition='r.id=:room ';
		$criteria->params=array(':room'=>$room_id);

        $criteria->alias='s';
		$criteria->select='s.id, s.shift_name,s.time_start,s.time_end';
		
		$criteria->join='left join rooms r on(r.shift = s.id)';
				return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        
		));
	
	
	}

	
}
