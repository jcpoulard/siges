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



class Levels extends BaseLevels
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	
	//declaration pr les relations
	
	public $section_name;
	public $total_stud=0;
	
	
	
  public function rules()
	{
              
              return array_merge(
		    	parent::rules(), array(
                            //Make each level unique 
                            array('level_name, short_level_name','unique'),
                            //Make date_created, date_update as unsafe 
                            array('date_created, date_updated','unsafe'),
                            
				                    
									
									));
	}
	
	
	
        
 // Return the cycle description 
        
        public function getCycleDescription(){
            

 $acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

 

            
            $modelCHS= new SectionHasCycle;
			$modelCHS=SectionHasCycle::model()->getCycleBySectionIdLevelId($this->section,$this->id,$acad_sess);
			if(isset($modelCHS)&&($modelCHS!=null))
			  { 
				return $modelCHS->cycle_description;
					  	 
			   }
            else
              return ''; 
        }

 // Return the level name 
        
        public function getLevelName(){
            return $this->level_name; 
        }

 // Return the short level name 
        
     public function getShortLevelName()
       {
            return $this->short_level_name; 
        }	
      
        // Get All the level
        
      public function getLevelOptions()
        {
            
            return CHtml::listData(Levels::model()->findAll(), 'id','levelName');
        }

		
		   		 // return the name of level in a specific the person 
        public function getLevel($idPerson,$acad){
            
            $criteria = new CDbCriteria;
			
			$criteria->condition = 'lp.students=:idPers AND lp.academic_year=:acad';
			$criteria->params = array(':idPers' => $idPerson, ':acad'=>$acad);
		    
			$criteria->alias = 'l';
			$criteria->select = 'l.id, l.level_name, l.short_level_name ';
			$criteria->join = 'left join level_has_person lp on (l.id = lp.level) ';
			$criteria->join .= 'left join persons p on (p.id = lp.students) ';
			
		    
    return new CActiveDataProvider($this, array(
        'criteria'=>$criteria,
    ));
	
	
        }
        
   
   
   public function getNextLevel($idLevel){
            
            $criteria = new CDbCriteria;
			
			$criteria->condition = 'l.previous_level=:idLevel';
			$criteria->params = array(':idLevel' => $idLevel);
		 
			$criteria->alias = 'l';
			$criteria->select = 'DISTINCT l.id, l.level_name, l.short_level_name  ';
			
			
			
			
    return new CActiveDataProvider($this, array(
        'criteria'=>$criteria,
    ));

    }	
	
	
	
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		
		$criteria->join='left join sections s on(s.id=l.section) ';

		$criteria->alias='l';
		$criteria->compare('l.id',$this->id);
		$criteria->compare('level_name',$this->level_name,true);
		$criteria->compare('short_level_name',$this->short_level_name,true);
		$criteria->compare('previous_level',$this->previous_level);
		$criteria->compare('l.section',$this->section);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('update_by',$this->update_by,true);
		
		$criteria->order = 's.section_name ASC, short_level_name ASC';
		

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>array(
                        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
                        ),
                        
		));
	} 
	
	
	public function getStudentsEnrolledLevel($condition,$level, $acad)
	{      
			$criteria = new CDbCriteria;
			
			$criteria->condition = $condition.' lh.level=:levelId AND lh.academic_year=:acad';
			$criteria->params = array(':levelId'=>$level,':acad'=>$acad);
	        
	        $criteria->alias = 'l';
			$criteria->select = 'COUNT(lh.students) as total_stud';
            $criteria->join = 'left join level_has_person lh on (l.id = lh.level) left join persons p on(p.id = lh.students)';
			$criteria->group = 'lh.level'; 
			
			
            
		 
		    		 
    return new CActiveDataProvider($this, array(
        'pagination'=>array(
        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    			),
				
		'criteria'=>$criteria,
		
    ));
    
    }
    
		
	
}
