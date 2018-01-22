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



class EmployeeInfo extends BaseEmployeeInfo
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public $employee_lname; 
	public $employee_fname; 
	public $employee_qualification; 
	public $employee_field_study; 
  
	
  public function rules()
	{
              
              return array_merge(
		    	parent::rules(), array(
		
                      array('employee_fname, employee_lname', 'length', 'max'=>80),
		  			array('id, employee, employee_fname, employee_lname, employee_qualification, employee_field_study, hire_date, country_of_birth, university_or_school, permis_enseignant, number_of_year_of_study, field_study, qualification, job_status, leaving_date, comments, date_created, date_updated, create_by, update_by', 'safe', 'on'=>'search'),
		  		
							
									));
	}
	
    
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with= array('employee0','qualification0','fieldStudy');
		
		$criteria->compare('id',$this->id);
		$criteria->compare('employee',$this->employee);
		$criteria->compare('hire_date',$this->hire_date,true);
		$criteria->compare('country_of_birth',$this->country_of_birth,true);
		$criteria->compare('university_or_school',$this->university_or_school,true);
		$criteria->compare('number_of_year_of_study',$this->number_of_year_of_study);
		$criteria->compare('field_study',$this->field_study);
		$criteria->compare('qualification',$this->qualification);
		$criteria->compare('job_status',$this->job_status);
		$criteria->compare('permis_enseignant',$this->permis_enseignant,true);
		$criteria->compare('leaving_date',$this->leaving_date,true);
		$criteria->compare('comments',$this->comments,true);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('update_by',$this->update_by,true);
		$criteria->compare('employee0.last_name',$this->employee_lname, true);
		$criteria->compare('employee0.first_name',$this->employee_fname, true); 
		$criteria->compare('qualification0.qualification_name',$this->employee_qualification, true);
		$criteria->compare('fieldStudy.field_name',$this->employee_field_study, true);
		

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>array(
                        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
                        ),

		));
	}
	
	
	
	
		public function searchForOneEmployee($employeeID)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with= array('employee0','qualification0','fieldStudy');
		$criteria->condition='employee=:Id';
		$criteria->params=array(':Id'=>$employeeID);
		
		$criteria->compare('id',$this->id);
		$criteria->compare('employee',$this->employee);
		$criteria->compare('hire_date',$this->hire_date,true);
		$criteria->compare('country_of_birth',$this->country_of_birth,true);
		$criteria->compare('university_or_school',$this->university_or_school,true);
		$criteria->compare('number_of_year_of_study',$this->number_of_year_of_study);
		$criteria->compare('field_study',$this->field_study);
		$criteria->compare('qualification',$this->qualification);
		$criteria->compare('job_status',$this->job_status);
		$criteria->compare('permis_enseignant',$this->permis_enseignant,true);
		$criteria->compare('leaving_date',$this->leaving_date,true);
		$criteria->compare('comments',$this->comments,true);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('update_by',$this->update_by,true);
		$criteria->compare('employee0.last_name',$this->employee_lname, true);
		$criteria->compare('employee0.first_name',$this->employee_fname, true); 
		$criteria->compare('qualification0.qualification_name',$this->employee_qualification, true);
		$criteria->compare('fieldStudy.field_name',$this->employee_field_study, true);
		

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>array(
                        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
                        ),

		));
	}
	
	
	
	public function search_($condition,$acad)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with= array('employee0','qualification0','fieldStudy');
		
		$criteria->alias='ei';
		
		$criteria->condition=$condition.'  employee0.is_student=0';//for teachers
		
		
		$criteria->compare('id',$this->id);
		$criteria->compare('employee',$this->employee);
		$criteria->compare('hire_date',$this->hire_date,true);
		$criteria->compare('country_of_birth',$this->country_of_birth,true);
		$criteria->compare('university_or_school',$this->university_or_school,true);
		$criteria->compare('number_of_year_of_study',$this->number_of_year_of_study);
		$criteria->compare('field_study',$this->field_study);
		$criteria->compare('qualification',$this->qualification);
		$criteria->compare('job_status',$this->job_status);
		$criteria->compare('permis_enseignant',$this->permis_enseignant,true);
		$criteria->compare('leaving_date',$this->leaving_date,true);
		$criteria->compare('comments',$this->comments,true);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('update_by',$this->update_by,true);
		$criteria->compare('employee0.last_name',$this->employee_lname, true);
		$criteria->compare('employee0.first_name',$this->employee_fname, true); 
		$criteria->compare('qualification0.qualification_name',$this->employee_qualification, true);
		$criteria->compare('fieldStudy.field_name',$this->employee_field_study, true);
		

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>array(
                        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
                        ),

		));
	}
	

        
    public function getNiceLeavingDate(){
            if($this->leaving_date=='0000-00-00')
                return Yii::t('app','Active');
            else
                return $this->leaving_date;
        }    

	

	
}
