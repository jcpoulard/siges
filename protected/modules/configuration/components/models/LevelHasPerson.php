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



class LevelHasPerson extends BaseLevelHasPerson
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public $gender;
	public $total_stud;
	public $total_gender;
	public $room_name;
	public $first_name;
	public $last_name;
	public $name_period;
	
  public function rules()
	{
              
              return array_merge(
		    	parent::rules(), array(
                            //make date_created, date_updated as unsafe 
                            array('date_created, date_updated','unsafe'),
                           // array('students+academic_year', 'application.extensions.uniqueMultiColumnValidator'),
                            array('id, room_name, last_name, name_period', 'safe', 'on'=>'search'),
				                    
									
									));
	}
	
    
public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
        $criteria->with=array('level0','students0','academicYear');
		
		$criteria->compare('id',$this->id);
		$criteria->compare('level0.room_name',$this->room_name,true);
		$criteria->compare('students0.last_name',$this->last_name,true);
		$criteria->compare('academicYear.name_period',$this->name_period,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
        // return the name of person in a specific the level 
        public function getPersonInLevel(){
            
            return $this->students0->fullName . ' ('.$this->level0->level_name.')' ; 
        }
		
		
public function searchTotalStudentsBy($condition,$level,$acad)
	{      
			$criteria = new CDbCriteria;
			
			$criteria->alias = 'lh';
			$criteria->select = 'COUNT(lh.students) as total_stud, p.gender';
			$criteria->join = 'left join persons p on (p.id = lh.students)';
			$criteria->join .= 'left join levels l on (l.id = lh.level)';
			$criteria->group = 'p.gender';
			
			
			   $criteria->condition = $condition.' lh.level=:idLevel AND lh.academic_year=:acad1 AND lh.students NOT IN(SELECT students FROM room_has_person WHERE academic_year=:acad2)';
			   $criteria->params = array(':idLevel'=>$level,':acad1'=>$acad,':acad2'=>$acad);
	       
		    
		    		
    return new CActiveDataProvider(get_class($this), array(
        
				
		'criteria'=>$criteria,
    ));
          
			   
	
    }
	
	
	//for stud in level not yet affected to room	
	public function searchTotalGenderBy($condition,$level,$acad)
	{      
			$criteria = new CDbCriteria;
			
			$criteria->alias = 'lh';
			$criteria->select = 'COUNT(p.gender) as total_gender, p.gender';
			$criteria->join = 'left join persons p on (p.id = lh.students)';
			$criteria->join .= 'left join levels l on (l.id = lh.level)';
			$criteria->group = 'p.gender';
			
			
			$criteria->condition = $condition.' lh.level=:idLevel AND lh.academic_year=:acad1 AND lh.students NOT IN(SELECT students FROM room_has_person WHERE academic_year=:acad2)';
			$criteria->params = array(':idLevel'=>$level,':acad1'=>$acad,':acad2'=>$acad);
			 
		    		
    return new CActiveDataProvider(get_class($this), array(
        
				
		'criteria'=>$criteria,
    ));
          
			   
	
    }
	
	
        
}
