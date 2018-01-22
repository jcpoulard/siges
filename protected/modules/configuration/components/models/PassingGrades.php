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



class PassingGrades extends BasePassingGrades
{
	
	public $level_lname; 
	public $academic_lname;
	public $weight;
	
	
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
  public function rules()
	{
              
              return array_merge(
		    	parent::rules(), array(
					array('level_lname, academic_lname, minimum_passing','safe', 'on'=>'search'),
					array('level+academic_period', 'application.extensions.uniqueMultiColumnValidator'),
					array('course+academic_period', 'application.extensions.uniqueMultiColumnValidator'),
					
									
									));
	}
	

        // Compare two password 
		    public function gradeCompare(){
		            $message = Yii::t('app','Passing grade cannot be greatter than weight course.');
		         
		                $params1 = array(
		                    '{attribute}'=>'', '{compareValue}'=>''
		                );
		                
		                
		                
		                $this->addError('minimum_passing', strtr($message, $params1));
		            
		        }
		        
		   

	public function takePassGrades($id_level,$id_academic_period)	
	{
        $criteria = new CDbCriteria;
		
		$criteria->condition = 'level=:idLevel AND academic_period=:idAcademicPeriod ';
		$criteria->params = array(':idLevel' => $id_level,':idAcademicPeriod'=>$id_academic_period);
	   
	    $criteria->select = '*';
		
	    return new CActiveDataProvider($this, array(
    		'criteria'=>$criteria,
			));
		
	}


	public function search($acad)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with= array('level0','academicPeriod');
		
		$criteria->condition='academic_period=:acad';
		$criteria->params=array(':acad'=>$acad);
		
		$criteria->compare('id',$this->id);
		$criteria->compare('level',$this->level);
		$criteria->compare('academic_period',$this->academic_period);
		$criteria->compare('minimum_passing',$this->minimum_passing);
		$criteria->compare('level_or_course',$this->level_or_course);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('update_by',$this->update_by,true);
		$criteria->compare('level0.level_name',$this->level_lname, true);
		$criteria->compare('academicPeriod.name_period',$this->academic_lname, true);
		
		

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>array(
                        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
                        ),
		));
	}
	
	
	public function searchCourses($acad)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with= array('level0', 'course0','academicPeriod');
		
		$criteria->alias='pg';
		$criteria->condition='level_or_course=1 AND pg.academic_period=:acad';
		$criteria->params=array(':acad'=>$acad);
		
		$criteria->compare('id',$this->id);
		$criteria->compare('level',$this->level);
		$criteria->compare('academic_period',$this->academic_period);
		$criteria->compare('minimum_passing',$this->minimum_passing);
		$criteria->compare('level_or_course',$this->level_or_course);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('update_by',$this->update_by,true);
		$criteria->compare('level0.level_name',$this->level_lname, true);
		$criteria->compare('academicPeriod.name_period',$this->academic_lname, true);
		
		

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>array(
                        'pageSize'=>100, 
                        ),
		));
	}
	
	
public function searchLevels($acad)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with= array('level0', 'course0','academicPeriod');
		
		$criteria->alias='pg';
		$criteria->condition='level_or_course=0 AND pg.academic_period=:acad';
		$criteria->params=array(':acad'=>$acad);
		
		$criteria->compare('pg.id',$this->id);
		$criteria->compare('level',$this->level);
		$criteria->compare('academic_period',$this->academic_period);
		$criteria->compare('minimum_passing',$this->minimum_passing);
		$criteria->compare('level_or_course',$this->level_or_course);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('update_by',$this->update_by,true);
		$criteria->compare('level0.level_name',$this->level_lname, true);
		$criteria->compare('academicPeriod.name_period',$this->academic_lname, true);
		
		

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>array(
                        'pageSize'=> 100, 
                        ),
		));
	}
	
		
	
	
	
	public function rechercheGrades()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

        $criteria = new CDbCriteria;
		
		$criteria->condition = 'level=:idLevel AND academic_period=:idAcademicPeriod ';
		$criteria->params = array(':idLevel' => $id_level,':idAcademicPeriod'=>$id_academic_period);
	    
	    $criteria->select = '*';
		
	    return new CActiveDataProvider($this, array(
    		'criteria'=>$criteria,
			));
	}

	
	
  public function getCoursePassingGrade($id_course, $id_academic_period)
	{
		$criteria = new CDbCriteria;
		$criteria->condition='level_or_course=1 AND course=:idCourse AND academic_period=:idAcademicLevel';
		$criteria->params=array(':idCourse'=>$id_course,':idAcademicLevel'=>$id_academic_period);
		$pass_grade = PassingGrades::model()->find($criteria);
	 
	  if(isset($pass_grade))
	  return $pass_grade->minimum_passing; 
	  else 
	    return null;
	}   

	
}
