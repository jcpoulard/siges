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



class RoomHasPerson extends BaseRoomHasPerson
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public $gender;
	public $full_name;
	public $name_period;
	public $total_stud;
	public $total_gender;
	
  public function rules()
	{
              
              return array_merge(
		    	parent::rules(), array(
				                    
				                    array('students+academic_year', 'application.extensions.uniqueMultiColumnValidator'),
									
									));
	}
	
public function getPersonInRoom(){
    
    return $this->students0->fullName.' ('.$this->room0->room_name.')'; 
}

public function searchStudents_($condition,$section_id){   
                    $criteria = new CDbCriteria;
        
		$criteria->condition=$condition.' p.is_student=1 AND l.section=:idSection';
	    $criteria->params=array(':idSection'=>$section_id);
		
		$criteria->alias = 'rh';
		$criteria->select = 'p.id, p.last_name , p.first_name, p.gender, p.id_number';
		$criteria->join = 'left join persons p on (p.id = rh.students) left join rooms r on (r.id = rh.room) left join levels l on(l.id=r.level)';
		;	
		
return new CActiveDataProvider($this, array(
    'pagination'=>array('pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
			),
	'criteria'=>$criteria,
));		
	
}


public function searchTotalStudentsByRoomId($condition,$room,$acad)
	{      
			$criteria = new CDbCriteria;
			
			
            $criteria->alias = 'rh';
			$criteria->select = 'COUNT(rh.students) as total_stud, p.gender, p.id_number';
			$criteria->join = 'left join persons p on (p.id = rh.students)';
			$criteria->condition = $condition.' rh.room='.$room.' AND rh.academic_year='.$acad;
			$criteria->group = 'rh.room';
			 
		    		
    return new CActiveDataProvider(get_class($this), array(
        				
		'criteria'=>$criteria,
    ));
 	
    }
	
	
public function searchTotalGenderByRoomId($condition,$room,$acad)
	{      
			$criteria = new CDbCriteria;
			  
		$criteria->condition = $condition.' rh.room='.$room.' AND rh.academic_year='.$acad;
			   
			
			
			$criteria->alias = 'rh';
			$criteria->select = 'COUNT(p.gender) as total_gender, p.gender';
			$criteria->join = 'left join persons p on (p.id = rh.students)';
			$criteria->join .= 'left join rooms r on (r.id = rh.room)';
			$criteria->group = 'p.gender';
		    
		    		
    return new CActiveDataProvider(get_class($this), array(
    			
		'criteria'=>$criteria,
    ));
 	
    }



public function searchTotalStudentsBy($condition,$shift,$section,$level,$room,$acad)
	{      
			$criteria = new CDbCriteria;
			
			
			if(($shift!=null)&&($section!=null)&&($level!=null)&&($room!=null))
			  {
			   
			    $criteria->condition = $condition.' r.shift=:idShift AND l.section=:idSection AND r.level=:idLevel And r.id=:idRoom AND rh.academic_year=:acad';
			   $criteria->params = array(':idShift' => $shift,':idSection'=>$section,':idLevel'=>$level,':idRoom'=>$room,':acad'=>$acad);
			  }
			elseif(($shift!=null)&&($section!=null)&&($level!=null)&&($room==null))
			 { 
			   $criteria->condition = $condition.' r.shift=:idShift AND l.section=:idSection AND r.level=:idLevel AND rh.academic_year=:acad';
			   $criteria->params = array(':idShift' => $shift,':idSection'=>$section,':idLevel'=>$level,':acad'=>$acad);
	         }
			 elseif(($shift!=null)&&($section!=null)&&($level==null)&&($room==null))
			 { 
			   $criteria->condition = $condition.' r.shift=:idShift AND l.section=:idSection AND rh.academic_year=:acad';
			   $criteria->params = array(':idShift' => $shift,':idSection'=>$section,':acad'=>$acad);
	         }
			 elseif(($shift!=null)&&($section==null)&&($level==null)&&($room==null))
			 {  
			    $criteria->condition = $condition.' r.shift=:idShift AND rh.academic_year=:acad';
			    $criteria->params = array(':idShift' => $shift,':acad'=>$acad);
			 }
			
			$criteria->alias = 'rh';
			$criteria->select = 'COUNT(rh.students) as total_stud, p.gender';
			$criteria->join = 'left join persons p on (p.id = rh.students)';
			$criteria->join .= 'left join rooms r on (r.id = rh.room) left join levels l on(l.id=r.level)';
			$criteria->group = 'p.gender';
			
			 
		    	    		
    return new CActiveDataProvider(get_class($this), array(
        
				
		'criteria'=>$criteria,
    ));
          			   
	
 }	
	
    	
	
public function searchTotalGenderBy($condition,$shift,$section,$level,$room,$acad)
	{      
			$criteria = new CDbCriteria;
			
			
			if(($shift!=null)&&($section!=null)&&($level!=null)&&($room!=null))
			  {
			   
			   $criteria->condition = $condition.' r.shift=:idShift AND l.section=:idSection AND r.level=:idLevel And r.id=:idRoom AND rh.academic_year=:acad';
			   $criteria->params = array(':idShift' => $shift,':idSection'=>$section,':idLevel'=>$level,':idRoom'=>$room,':acad'=>$acad);
			  }
			elseif(($shift!=null)&&($section!=null)&&($level!=null)&&($room==null))
			 { 
			   $criteria->condition = $condition.' r.shift=:idShift AND l.section=:idSection AND r.level=:idLevel AND rh.academic_year=:acad';
			   $criteria->params = array(':idShift' => $shift,':idSection'=>$section,':idLevel'=>$level,':acad'=>$acad);
	         }
			 elseif(($shift!=null)&&($section!=null)&&($level==null)&&($room==null))
			 { 
			   $criteria->condition = $condition.' r.shift=:idShift AND l.section=:idSection AND rh.academic_year=:acad';
			   $criteria->params = array(':idShift' => $shift,':idSection'=>$section,':acad'=>$acad);
	         }
			 elseif(($shift!=null)&&($section==null)&&($level==null)&&($room==null))
			 {  
			    $criteria->condition = $condition.' r.shift=:idShift AND rh.academic_year=:acad';
			    $criteria->params = array(':idShift' => $shift,':acad'=>$acad);
			 }
			
			$criteria->alias = 'rh';
			$criteria->select = 'COUNT(p.gender) as total_gender, p.gender';
			$criteria->join = 'left join persons p on (p.id = rh.students)';
			$criteria->join .= 'left join rooms r on (r.id = rh.room) left join levels l on(l.id=r.level)';
			$criteria->group = 'p.gender';
			
			 
			 
			 
		    
		    		
    return new CActiveDataProvider(get_class($this), array(
        
				
		'criteria'=>$criteria,
    ));
          	
 }
 

    
    public function checkData($room, $pers, $acad)
	 {
	 	                $criteria = new CDbCriteria;
        
		$criteria->condition='room=:room AND students=:stud AND academic_year=:acad';
	    $criteria->params=array(':room'=>$room,':stud'=>$pers,':acad'=>$acad);
		
		$criteria->alias = 'rh';
		$criteria->select = '*';
		
	   
				
		return new CActiveDataProvider($this, array(
		    
			'criteria'=>$criteria,
		));
			 	
	 	
	 }
	
	

public function getRoomName(){
    return $this->room0->room_name; 
}

	
}
