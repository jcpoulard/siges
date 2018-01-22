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



class Rooms extends BaseRooms
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	//declaration pr les relations
	public $level_name;
	public $shift_name;
	public $section_name;
	
	public $level_lname;
	public $shift_sname;
	public $section_sname;
	
	public $level;
	public $shift;
	public $section;
	
	public $total_stud=0;
	public $student_id;
	public $gender;
	
	
        
		
		
  public function rules()
	{
              
              return array_merge(
		    	parent::rules(), array(
                            // add validation rules for room creation
                            array('shift', 'required'),
                            //make date_created, date_update unsafe 
                            array('date_created, date_updated','unsafe'),
                            array('id, room_name, short_room_name, level_name, level_lname, shift_sname, section_sname, shift, section, date_created, date_updated, create_by, update_by', 'safe', 'on'=>'search'),
				                  
									
									));
	}
	
	
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		
		$criteria->alias='r';
		$criteria->join='left join levels l on(l.id=r.level) left join sections s on(s.id=l.section) left join shifts sh on(sh.id=r.shift) ';

		$criteria->compare('r.id',$this->id);
		$criteria->compare('r.room_name',$this->room_name,true);
		$criteria->compare('r.short_room_name',$this->short_room_name,true);
		$criteria->compare('l.level_name',$this->level_lname,true);
		$criteria->compare('sh.shift_name',$this->shift_sname,true);
		$criteria->compare('r.date_created',$this->date_created,true);
		$criteria->compare('r.date_updated',$this->date_updated,true);
		$criteria->compare('r.create_by',$this->create_by,true);
		$criteria->compare('r.update_by',$this->update_by,true);
		
		
		$criteria->order = 'sh.shift_name ASC, s.section_name ASC, l.short_level_name ASC';

		return new CActiveDataProvider($this, array(
	        'pagination'=>array(
	        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
	    			),
			'criteria'=>$criteria,
		));
	}
        
        public function searchReport()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with=array('level0','shift0');

		$criteria->compare('id',$this->id);
		$criteria->compare('room_name',$this->room_name,true);
		$criteria->compare('r.short_room_name',$this->short_room_name,true);
		$criteria->compare('level0.level_name',$this->level_lname,true);
		$criteria->compare('shift0.shift_name',$this->shift_sname,true);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('update_by',$this->update_by,true);
		$criteria->order = 'shift0.shift_name ASC, level0.level_name ASC, room_name ASC';

		return new CActiveDataProvider($this, array(
	        'pagination'=>array(
	        			'pageSize'=>100000,
	    			),
			'criteria'=>$criteria,
		));
	}
	    

		   		 // return the name of level in a specific the person 
        public function getRoom($idPerson, $acad){
            
            $criteria = new CDbCriteria;
			
			$criteria->condition = 'rp.students=:idPers AND rp.academic_year=:acad';
			$criteria->params = array(':idPers' => $idPerson,':acad'=>$acad);
		    
			$criteria->alias = 'r';
			$criteria->select = ' r.id, r.room_name, r.short_room_name ';
			$criteria->join = 'left join room_has_person rp on (r.id = rp.room) ';
			$criteria->join .= 'left join persons p on (p.id = rp.students) ';
			
		    
			
    return new CActiveDataProvider($this, array(
       
        'criteria'=>$criteria,
    ));
	
	    }
		

	

    public function getInfoRoom($room_id){
            
            $criteria = new CDbCriteria;
			
			$criteria->join = 'left join levels l on(l.id=r.level)';
			$criteria->condition = 'r.id=:id';
			$criteria->params = array(':id' => $room_id);
		    
			$criteria->alias = 'r';
			$criteria->select = ' r.room_name, r.short_room_name, r.shift, r.level, l.section ';
			
		    
			
    return new CActiveDataProvider($this, array(
       
        'criteria'=>$criteria,
    ));
	
	    }

			
   public function getRoomByIdCourse($idCourse, $acad){
            
            $criteria = new CDbCriteria;
						
			$criteria->condition = 'c.id=:idCourse AND c.academic_period=:idAcad ';
			$criteria->params = array(':idCourse' => $idCourse,':idAcad'=>$acad);
		    
		    $criteria->alias = 'r';
			$criteria->select = 'r.id, r.room_name, short_room_name ';
			$criteria->join = 'left join courses c on (r.id = c.room) ';
			
		    
			
    return new CActiveDataProvider($this, array(
       
        'criteria'=>$criteria,
    ));
	
	    }
		

public function getSection($level)
			{
			
		        
        $result=Levels::model()->find(array('alias'=>'l',
                        		     'select'=>'sec.id, sec.section_name',
                                     'join'=>'left join sections sec on(l.section=sec.id)',
                                     'condition'=>'l.id=:levelID',
                                     'params'=>array(':levelID'=>$level),
                               ));
			
                
						   
           if(isset($result)&&($result!=null))
               {
						   
				return $result->section_name;
                }
                else
               
                    return null;
                
			}
			
			
		
	
	public function getStudentsEnrolled($condition,$room, $acad)
	{      
			$criteria = new CDbCriteria;
			
			$criteria->condition = $condition.' lh.room=:roomId AND lh.academic_year=:acad';
			$criteria->params = array(':roomId'=>$room,':acad'=>$acad);
	        
	        $criteria->alias = 'l';
			$criteria->select = 'COUNT(lh.students) as total_stud';
            $criteria->join = 'left join room_has_person lh on (l.id = lh.room) left join persons p on(p.id = lh.students)';
			$criteria->group = 'lh.room'; 
			
			
            
		  
		    		 
    return new CActiveDataProvider($this, array(
        'pagination'=>array(
        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    			),
				
		'criteria'=>$criteria,
		
    ));
    
    }
    

    
    
    	
public function getInfoStudentsEnrolled($condition,$room, $acad)
	{      
			$criteria = new CDbCriteria;
			
			$criteria->condition = $condition.' r.id=:roomId AND rh.academic_year=:acad';
			$criteria->params = array(':roomId'=>$room,':acad'=>$acad);
	        
	        $criteria->alias = 'r';
			$criteria->select = 'p.id as student_id, p.first_name, p.last_name, p.gender ';
            $criteria->join = 'left join room_has_person rh on (r.id = rh.room) left join persons p on(p.id = rh.students)';
			
            
		  
		    		 
    return new CActiveDataProvider($this, array(
       'pagination'=>array(
        			'pageSize'=> 1000,
    			),
		'criteria'=>$criteria,
		
    ));
    
    }
    
    
	
}
