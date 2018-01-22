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




/**
 * This is the model class for table "payroll_settings".
 *
 * The followings are the available columns in table 'payroll_settings':
 * @property integer $id
 * @property integer $person_id
 * @property double $amount
 * @property integer $an_hour
 * @property integer $number_of_hour
 * @property integer $academic_year
 * @property integer $as
 * @property integer $old_new
 * @property string $date_created
 * @property string $date_updated
 * @property string $created_by
 * @property string $updated_by
 *
 * The followings are the available model relations:
 * @property Payroll[] $payrolls
 * @property Academicperiods $academicYear
 * @property Persons $person
 */
class PayrollSettings extends BasePayrollSettings
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PayrollSettings the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


    public $full_name;
    public $employee_lname; 
	public $employee_fname;
	public $teacher_lname; 
	public $teacher_fname; 
	public $academic_year;
	public $group;
	public $group_payroll;
	public $date_payroll;
	public $first_name;
	public $last_name;
	public $payroll_month;
	public $number_of_hour;
	public $taxe;
	public $net_salary;
	public $payment_date;
	//public $as_;
	//public $as;
	
	public $taxes;



 public function rules()
	{
		 return array_merge(
                parent::rules(), array(
                   // array(),
                   array('full_name, employee_lname, employee_fname,academic_year,date_payroll', 'length', 'max'=>65),
                  // array('person_id+as+academic_year', 'application.extensions.uniqueMultiColumnValidator'),
                   
                  array('id, person_id, amount, an_hour, as, old_new, academic_year, full_name, employee_lname, employee_fname,teacher_lname,teacher_fname,date_payroll date_created, date_updated, created_by, updated_by', 'safe', 'on'=>'search'),
                   
									
		));
	}


public function attributeLabels()
	{
		
            return array_merge(
                    parent::attributeLabels(), 
                    array(
                        'full_name'=> Yii::t('app','Full name'),
                        'employee_fname'=> Yii::t('app','Employee First Name'),
                        'employee_lname'=> Yii::t('app','Employee Last Name'),
                        'teacher_fname'=> Yii::t('app','Teacher First Name'),
                        'teacher_lname'=> Yii::t('app','Teacher Last Name'),
                        'group'=> Yii::t('app','By Group'),
                        'AnHour'=>Yii::t('app','An Hour'),
                        'as'=> Yii::t('app','As'),
                        'old_new'=> Yii::t('app','New setting'),
                                   
                        )
                    );
           
	}



  public function getPayrollGroup(){
            return array(
                1=>Yii::t('app','Employees'), // Les personnes dans person qui ont un poste [done] 
                2=>Yii::t('app','Teachers'), // Les professeurs uniquement sans un poste [done]
                
            );            
        }
        
        
        
        public function getDatePayroll(){
           $time = strtotime($this->date_created);
                         $month=date("n",$time);
                         $year=date("Y",$time);
                         $day=date("j",$time);
                         $hour = date("h",$time);
                         $minutes = date("m",$time);
            return $day.'-'.  Schedules::model()->getMonth($month).'-'.$year.' '.$hour.':'.$minutes;             
        }
 
 

  public function getDateCreated(){
           if(($this->date_created!=null)&&($this->date_created!='0000-00-00'))
	        {    $time = strtotime($this->date_created);
	                         $month=date("m",$time);
	                         $year=date("Y",$time);
	                         $day=date("j",$time);
	                         
	            return $day.'/'.$month.'/'.$year;    
	         }
	       else
	           return '00-00-0000';
        }



 

  
  public function getAnHour(){
            switch($this->an_hour)
            {
                case 0:
                    return Yii::t('app','No');
                case 1:
                    return Yii::t('app','Yes');
               
            }
        }
        
   public function getAnHourValue(){
            return array(
                0=>Yii::t('app','No'),
                1=>Yii::t('app','Yes'),
                             
            );            
        } 		
  
 
   public function getAsValue(){
            switch($this->as)
               {          
                   case 0:
                    return Yii::t('app','Employee');
                   case 1:
                    return Yii::t('app','Teacher');
                
                }
                             
                      
        } 		
 
 
   public function getOldNewValue(){
            switch($this->old_new)
               {          
                   case 0:
                    return Yii::t('app','Old setting');
                   case 1:
                    return Yii::t('app','New setting');
                
                }
                             
                      
        } 	 



public function getTaxeToPay(){
           
           $taxes = '';
           $criteria = new CDbCriteria(array('order'=>'id_taxe ASC', 'condition'=>' id_payroll_set='.$this->id ));
			                 
			$modelTaxe = PayrollSettingTaxes::model()->findAll($criteria);
			$i =0;
			 if($modelTaxe!=null)
              { foreach($modelTaxe as $taxe)
                  {    $taxe_desc = Taxes::model()->findByPk($taxe->id_taxe);
                  	    
                  	    	
		                  	if($i==0)
		                  	  {
		                  	  	  $i =1;
		                  	  	  $taxes = $taxe_desc->taxe_description;
		                  	  	}
		                  	else
		                  	   $taxes = $taxes.', '.$taxe_desc->taxe_description;
		                  	   
		               
                   }
               }
               
			   	 
           
           
          	      return  $taxes;
         
           
        }	



 
public function getNumberHour(){
           if(($this->number_of_hour!=0)&&($this->number_of_hour!=''))
            {
            	return $this->number_of_hour;
             }
            else 
             {  if($this->an_hour==0)
          	    return  Yii::t('app','N/A');
          	 elseif($this->an_hour==1)
          	      return  null;
             }
               
           
        }	


 public function getGrossSalary(){
        
        if(($this->number_of_hour!=0)&&($this->number_of_hour!=''))
           {
           	  return ($this->amount * $this->number_of_hour);
           	  
           }
        else
           {  return  $this->amount;
           
             }
                
        }
        
  public function getGrossSalaryInd(){
        
        $currency_name = Yii::app()->session['currencyName'];
	       $currency_symbol = Yii::app()->session['currencySymbol']; 
           
       if(($this->number_of_hour!=0)&&($this->number_of_hour!=''))
           {
           	  return $currency_symbol.' '.numberAccountingFormat( ($this->amount * $this->number_of_hour) );
           	  
           }
        else
           {  return  $currency_symbol.' '.numberAccountingFormat($this->amount);
           
             }
                
        }


	 public function getAmount(){
           
           $currency_name = Yii::app()->session['currencyName'];
	       $currency_symbol = Yii::app()->session['currencySymbol']; 
           
            return $currency_symbol.' '.numberAccountingFormat($this->amount);
        }


        
public function getNumberHourValue(){
            if(($this->number_of_hour!=0)&&($this->number_of_hour!=''))
            {
            	return $this->number_of_hour;
             }
            else 
                return '';
        }
        
          
	
  
public function getSimpleNumberHourValue($person){
	
	$acad=Yii::app()->session['currentId_academic_year']; 
	
	$nbr_time = 0;
	
     $sql = 'SELECT number_of_hour, an_hour FROM payroll_settings  WHERE old_new=1 AND person_id='.$person.' AND academic_year='.$acad.' order by id DESC';
		$command = Yii::app()->db->createCommand($sql);
        $info_setting_p = $command->queryAll(); 
									       	   
		  if($info_setting_p!=null) 
			{ 
			 
			 $employee_teacher=Persons::model()->isEmployeeTeacher($person, $acad);
	  
			 if($employee_teacher) 
			   {
			   	     $compt=0;
			   	     
			   	     foreach($info_setting_p as $info_)
					  {
					      $compt++;
					      
					      if($info_['an_hour']==1)
			                {     
						      $nbr_time = $info_['number_of_hour'];					  	   	    
			                }
					     
					     if($compt==2)
					        break;
					        
					   }
			   	     
			   	     
			     }
			  elseif(!$employee_teacher)
			    {

				 foreach($info_setting_p as $info_)
				  {
				      if($info_['an_hour']==1)
			           {
			              $nbr_time = $info_['number_of_hour'];
					      
			             }
			             					  	   	    
				     break;
				   }
				
			    }
			}
					
			if(($nbr_time!=0)&&($nbr_time !=''))
            {
            	return $nbr_time;
             }
            else 
                return '';
                
                
  }
        
          
  
public function getIdPayrollSettingByPersonId($person_id)  
	{
		$acad=Yii::app()->session['currentId_academic_year'];
		
		$sql = '';
		//check if is employee_teacher
		 $employee_teacher=Persons::model()->isEmployeeTeacher($person_id, $acad);
		 
		  if($employee_teacher) 
			   {
			   		$sql = 'SELECT ps.id FROM payroll_settings ps where ps.old_new = 1 AND ps.as=0 AND ps.person_id ='.$person_id;		   	     
			     }
			  elseif(!$employee_teacher)
			    {
			         $sql = 'SELECT id FROM payroll_settings where old_new = 1 AND person_id ='.$person_id;
			      }


		$command = Yii::app()->db->createCommand($sql);
        $info__p = $command->queryAll(); 
        
        if($info__p!=null)
          { 
          	  foreach($info__p as $info)
          	     {  return $info['id'];
          	         break;
          	     }
          
          }
        else
           return null;
           	

	 
	 }

      
public function getPersonIdByIdPayrollSetting($id_payroll_set)  
	{
		$acad=Yii::app()->session['currentId_academic_year'];
		
		 $sql = 'SELECT person_id FROM payroll_settings where id ='.$id_payroll_set;		   	     
			
		$command = Yii::app()->db->createCommand($sql);
        $info__p = $command->queryAll(); 
        
        if($info__p!=null)
          { 
          	  foreach($info__p as $info)
          	     {  return $info['person_id'];
          	         break;
          	     }
          
          }
        else
           return null;
           	 
	 }
      


public function searchEmployeeForPayroll($condition)
	{     
			$criteria = new CDbCriteria;
			
			$criteria->alias = 'p';
			
			 $criteria->condition = $condition;
			
		$criteria->compare('id',$this->id);

		$criteria->compare('last_name',$this->last_name,true);
		
		$criteria->compare('first_name',$this->first_name,true);

		$criteria->compare('gender',$this->gender,true);
		
		$criteria->compare('blood_group',$this->blood_group,true);
		
		$criteria->compare('citizenship',$this->citizenship,true);

		$criteria->compare('birthday',$this->birthday,true);

		$criteria->compare('id_number',$this->id_number,true);

		$criteria->compare('adresse',$this->adresse,true);

		$criteria->compare('phone',$this->phone,true);

		$criteria->compare('email',$this->email,true);

		$criteria->compare('cities',$this->cities);

		$criteria->compare('date_created',$this->date_created,true);

		$criteria->compare('date_updated',$this->date_updated,true);

		$criteria->compare('create_by',$this->create_by,true);

		$criteria->compare('update_by',$this->update_by,true);			
		
		$criteria->order = 'last_name ASC';
			
			
			
    return new CActiveDataProvider($this, array(
        'pagination'=>array(
        			'pageSize'=> 100000,
    			),
		'criteria'=>$criteria,
    ));
	
    }

//return id PayrollSettings
public function ifAsAlreadySetAs($person_id, $as, $acad)
 {
 	  	
	
			$command= Yii::app()->db->createCommand('SELECT ps.id  FROM payroll_settings ps left join persons p on(p.id=ps.person_id) WHERE ps.old_new = 1 AND ps.person_id='.$person_id.' AND ps.as='.$as.' AND ps.academic_year='.$acad);
   	   
   	   $sql_result = $command->queryAll();
		//if($sql_result!=null)
		  return $sql_result;
 	}
 	
 	

public function searchPersonsMakePayroll($condition)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
 
		//$criteria->with=array('payrolls','person');
		$criteria->alias = 'ps';
		 $criteria->join = ' left join persons p on(p.id=ps.person_id)';
		 $criteria->condition = $condition.' AND ps.old_new = 1';
		
	
		$criteria->select = 'p.id, p.last_name, p.first_name, p.gender, ps.amount, ps.an_hour, ps.number_of_hour, ps.as, ps.old_new';
			
		$criteria->order = 'p.last_name ASC';


		return new CActiveDataProvider($this, array(
			'pagination'=>array(
        			'pageSize'=>1000,
    			),
			'criteria'=>$criteria,
		));
	}



        
public function search_($acad)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with= array('payrolls','academicYear','person');
		
		$criteria->condition = 'ps.old_new= 1 AND person.active IN(1,2) AND academic_year='.$acad;
		$criteria->order = 'concat(person.first_name," ",person.last_name) ASC, ps.as ASC';

		$criteria->alias='ps';


		$criteria->compare('ps.id',$this->id);
		$criteria->compare('ps.person_id',$this->person_id);
		$criteria->compare('concat(person.first_name," ",person.last_name)',$this->full_name,true);
		$criteria->compare('person.first_name',$this->employee_fname);
		$criteria->compare('person.last_name',$this->employee_lname);
		$criteria->compare('ps.amount',$this->amount);
		$criteria->compare('an_hour',$this->an_hour);
		$criteria->compare('number_of_hour',$this->number_of_hour);
		$criteria->compare('ps.academic_year',$this->academic_year);
		$criteria->compare('ps.as',$this->as);
		$criteria->compare('ps.old_new',$this->old_new);
		$criteria->compare('academicYear.name_periode',$this->academic_year);
		$criteria->compare('ps.date_created',$this->date_created);
		$criteria->compare('ps.date_created',$this->date_payroll);
		$criteria->compare('ps.date_updated',$this->date_updated,true);
		$criteria->compare('ps.created_by',$this->created_by,true);
		$criteria->compare('ps.updated_by',$this->updated_by,true);

		return new CActiveDataProvider($this, array(
			'pagination'=>array(
        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    			),
			'criteria'=>$criteria,
		));
	}


	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('person_id',$this->person_id);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('an_hour',$this->an_hour);
		$criteria->compare('number_of_hour',$this->number_of_hour);
		$criteria->compare('academic_year',$this->academic_year);
		$criteria->compare('ps.as',$this->as);
		$criteria->compare('old_new',$this->old_new);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('created_by',$this->created_by,true);
		$criteria->compare('updated_by',$this->updated_by,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}