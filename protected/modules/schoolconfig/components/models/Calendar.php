<?php

/*
 * © 2015 LOGIPAM services / www.logipam.com siges@logipam.com et contributeurs (voir www.logipam.com)
 * 
 * This file is part of SIGES.

    SIGES is a free software: you can redistribute it and/or modify
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



class Calendar extends BaseCalendar
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	
	public $name_period;
	
	
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		 
              return array_merge(
		    	parent::rules(), array(
		    				           // array('start_time','timescompare'),
		    				            array('start_date','datescompare'),
		    				            array('id, c_title, location,name_period, description, start_date, end_date, start_time, end_time, is_all_day_event, color, academic_year', 'safe', 'on'=>'search'),
		    	
		    		));

	}

	// Compare two times 
		    public function timescompare($attribute, $params){
		            $message = Yii::t('app','Time start must precede time end !');
		            if( strtotime($this->end_time)<  strtotime($this->start_time))
		            {
		                $params = array(
		                    '{attribute}'=>$this->end_time, '{compareValue}'=>$this->start_time
		                );
		                $this->addError('end_time', strtr($message, $params));
		            }
		        }
		        
		        
// Compare two dates 
		    public function datescompare($attribute, $params){
		            $message = Yii::t('app','Date start must precede date end !');
		            if(($this->end_date)<  ($this->start_date))
		            {
		                $params = array(
		                    '{attribute}'=>$this->end_date, '{compareValue}'=>$this->start_date
		                );
		                $this->addError('end_date', strtr($message, $params));
		            }
		        }


	
public function search($acad)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		
		$criteria->with=array('academicYear');
		$criteria->condition = 'academic_year='.$acad;
		

		$criteria->compare('id',$this->id);
		$criteria->compare('c_title',$this->c_title,true);
		$criteria->compare('location',$this->location,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('start_date',$this->start_date,true);
		$criteria->compare('end_date',$this->end_date,true);
		$criteria->compare('start_time',$this->start_time,true);
		$criteria->compare('end_time',$this->end_time,true);
		$criteria->compare('is_all_day_event',$this->is_all_day_event);
		$criteria->compare('color',$this->color,true);
		$criteria->compare('academic_year',$this->academic_year);
		$criteria->compare('academicYear.name_period',$this->name_period);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>array(
                        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
                        ),

		));
	}
	
	
	
public function getEvents($acad)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		
		$criteria->with=array('academicYear');
		$criteria->condition = 'academic_year='.$acad;
		

		$criteria->compare('id',$this->id);
		$criteria->compare('c_title',$this->c_title,true);
		$criteria->compare('location',$this->location,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('start_date',$this->start_date,true);
		$criteria->compare('end_date',$this->end_date,true);
		$criteria->compare('start_time',$this->start_time,true);
		$criteria->compare('end_time',$this->end_time,true);
		$criteria->compare('is_all_day_event',$this->is_all_day_event);
		$criteria->compare('color',$this->color,true);
		$criteria->compare('academic_year',$this->academic_year);
		

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                       
		));
	}
		
	 public function getStartDate(){
            $time = strtotime($this->start_date);
            
                         $month = date("m",$time);
                         $year = date("Y",$time);
                         $day = date("j",$time);
          	return $day.'/'.$month.'/'.$year;    
           
        }
        
        public function getEndDate(){
            $time = strtotime($this->end_date);
            
                         $month = date("m",$time);
                         $year = date("Y",$time);
                         $day = date("j",$time);
          	return $day.'/'.$month.'/'.$year;    
           
        }
	
	
	
}



