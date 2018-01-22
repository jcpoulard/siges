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



class ContactInfo extends BaseContactInfo
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public $person_lname; 
	public $person_fname;
	public $person_full_name;
        public $relation_lname;
        
        public $use_contact;
         public $add;
         public $ch_name;
  
	
  public function rules()
	{
              
              return array_merge(
		    	parent::rules(), array(
		
                  array('contact_name, contact_relationship','required'),
                  array('email','email'),
                   array('person+contact_name', 'application.extensions.uniqueMultiColumnValidator'),       
                  array('id, person,person_lname, person_fname, relation_lname, contact_name, contact_relationship, profession, phone, address, email, date_created, date_updated, create_by, update_by', 'safe', 'on'=>'search'),
        
							
									));
	}
	
	
	
	
 public function attributeLabels()
	{
		
            return array_merge(
                    parent::attributeLabels(), 
                    array('add'=>Yii::t('app','Add'),
                    'use_contact'=>Yii::t('app','Use Contact'),
                    'ch_name'=>Yii::t('app','Update Name'),
                    'activeContact'=>Yii::t('app','Active Contact ?'),
                        )
                    );
           
	}

        
   public function search($condition,$acad)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                $criteria->with = array('person0','contactRelationship');
                $criteria->join = 'left join room_has_person rh on (rh.students=person)';
                $criteria->condition = $condition.' rh.academic_year=:acad';
		$criteria->params = array(':acad'=>$acad);

		$criteria->compare('id',$this->id);
		$criteria->compare('person',$this->person);
		$criteria->compare('contact_name',$this->contact_name,true);
		$criteria->compare('contact_relationship',$this->contact_relationship);
		$criteria->compare('profession',$this->profession,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('update_by',$this->update_by,true);
                $criteria->compare('person0.last_name',$this->person_lname, true);
                $criteria->compare('person0.first_name', $this->person_fname,true);
                $criteria->compare('contactRelationship.relation_name', $this->relation_lname,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			 'pagination'=>array(
        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    			),

		));
	} 
  
  
   public function searchforStudent($condition,$acad)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                $criteria->with = array('person0','contactRelationship');
                $criteria->join = 'left join room_has_person rh on (rh.students=person)';
                $criteria->condition = $condition.' rh.academic_year='.$acad.'  AND person0.is_student=1';
		

		$criteria->compare('id',$this->id);
		$criteria->compare('person',$this->person);
		$criteria->compare('contact_name',$this->contact_name,true);
		$criteria->compare('contact_relationship',$this->contact_relationship);
		$criteria->compare('profession',$this->profession,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('update_by',$this->update_by,true);
                $criteria->compare('person0.last_name',$this->person_lname, true);
                $criteria->compare('person0.first_name', $this->person_fname,true);
                $criteria->compare('contactRelationship.relation_name', $this->relation_lname,true);
                
           $criteria->order='person0.last_name ASC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			 'pagination'=>array(
        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    			),

		));
	} 
	
	 public function searchforTeacher($condition,$acad)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                $criteria->with = array('person0','contactRelationship');
                
                $criteria->condition = $condition.' person0.is_student=0 AND person0.id IN(SELECT teacher FROM courses c left join academicperiods a on(a.id=c.academic_period) WHERE (a.id='.$acad.' OR a.year='.$acad.') )';
		

		$criteria->compare('id',$this->id);
		$criteria->compare('person',$this->person);
		$criteria->compare('contact_name',$this->contact_name,true);
		$criteria->compare('contact_relationship',$this->contact_relationship);
		$criteria->compare('profession',$this->profession,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('update_by',$this->update_by,true);
                $criteria->compare('person0.last_name',$this->person_lname, true);
                $criteria->compare('person0.first_name', $this->person_fname,true);
                $criteria->compare('contactRelationship.relation_name', $this->relation_lname,true);
                
           $criteria->order='person0.last_name ASC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			 'pagination'=>array(
        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    			),

		));
	} 
	
	
public function searchforEmployee($condition,$acad)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                $criteria->with = array('person0','contactRelationship');
                
                $criteria->condition = $condition.' person0.is_student=0 AND person0.id NOT IN(SELECT teacher FROM courses c left join academicperiods a on(a.id=c.academic_period) WHERE (a.id='.$acad.' OR a.year='.$acad.') )';
		

		$criteria->compare('id',$this->id);
		$criteria->compare('person',$this->person);
		$criteria->compare('contact_name',$this->contact_name,true);
		$criteria->compare('contact_relationship',$this->contact_relationship);
		$criteria->compare('profession',$this->profession,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('update_by',$this->update_by,true);
                $criteria->compare('person0.last_name',$this->person_lname, true);
                $criteria->compare('person0.first_name', $this->person_fname,true);
                $criteria->compare('contactRelationship.relation_name', $this->relation_lname,true);
                
            $criteria->order='person0.last_name ASC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			 'pagination'=>array(
        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    			),

		));
	} 
	
	      
        public function searchByPersonId($person_id)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                $criteria->with = array('person0','contactRelationship');
                $criteria->condition = "person like(:person)" ;
                $criteria->params = array(':person'=>$person_id);;

		$criteria->compare('id',$this->id);
		$criteria->compare('person',$this->person);
		$criteria->compare('contact_name',$this->contact_name,true);
		$criteria->compare('contact_relationship',$this->contact_relationship);
		$criteria->compare('profession',$this->profession,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('update_by',$this->update_by,true);
                $criteria->compare('person0.last_name',$this->person_lname, true);
                $criteria->compare('person0.first_name', $this->person_fname,true);
                $criteria->compare('contactRelationship.relation_name', $this->relation_lname,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			 'pagination'=>array(
        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    			),

		));
	} 
        
        
        
        public function getInfoByIdStud($id)
	{   
          
			$criteria = new CDbCriteria;
                     
			$criteria->select = '*';
			
			
                        return new CActiveDataProvider($this, array(
       
				
		'criteria'=>$criteria,
		 'pagination'=>array(
        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    			),

				
    ));
	} 
        
	
  public function checkPersonEtContact($person_id,$contact_name)
	{
		$criteria=new CDbCriteria;
                $criteria->with = array('person0','contactRelationship');
                $criteria->condition = 'person =:person AND contact_name like(:C_name)' ;
                $criteria->params = array(':person'=>$person_id,':C_name'=>$contact_name);

		$criteria->compare('id',$this->id);
		$criteria->compare('person',$this->person);
		$criteria->compare('contact_name',$this->contact_name,true);
		$criteria->compare('contact_relationship',$this->contact_relationship);
		
                $criteria->compare('person0.last_name',$this->person_lname, true);
                $criteria->compare('person0.first_name', $this->person_fname,true);
                $criteria->compare('contactRelationship.relation_name', $this->relation_lname,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			 
		));

		
	  }
	  
	
	public function getIdContactByUserID($userid)
	 {   
         
         $criteria = new CDbCriteria;
                      
			$criteria->alias = 'c';
			$criteria->select = 'c.id';
			$criteria->join = 'left join users u on (u.person_id = c.person)';
			$criteria->condition = 'u.id =:id';
			$criteria->params = array(':id' => $userid);
            //$criteria->limit = '100';
		    
    return new CActiveDataProvider($this, array(
       
		'criteria'=>$criteria,
		 
    ));
    
    
    
	} 
	
	
	  public function getActiveContact(){
             
           $user_name=ContactInfo::model()->getUsername($this->id);
           
           $user = User::model()->find(array('select'=>'active',
                                     'condition'=>'username=:username AND is_parent=1',
                                     'params'=>array(':username'=>$user_name),
                               ));
		
			if(isset($user))			   
			  {		//return $user->active;
                  if($user->active==1)
                      return Yii::t('app','Yes');
                   else
                       return Yii::t('app','No');
			    }
			 else
             return null;
      
        }
     
  

     
     public function getUsername($id)
	{
		$modelUser=new User;
		$modelContac=new ContactInfo;
		
		//condition si contac la gen email deja
		$contac=ContactInfo::model()->findByPk($id);
		 
	  if($contac!=null)
      {  
		   if($contac->one_more!=0)//si one_more!=0, cheche person kote id==one_more
		     {
	              $le_referencie= $modelContac->find(array('select'=>'person',
                                     'condition'=>'id=:contact',
                                     'params'=>array(':contact'=>$contac->one_more),
                               ));     
	              
	              	              
	             if($le_referencie!=null)
				    {  
		              $user = $modelUser->find(array('select'=>'username',
			                                     'condition'=>'person_id=:le_referencie AND is_parent=1',
			                                     'params'=>array(':le_referencie'=>$le_referencie->person),
			                               ));
					
						
							if($user!=null)			   
									return $user->username;
							else
								return null;	
				    }
				    
				    
		     }
		   else
		    {
		    	$le_referencie= $modelContac->find(array('select'=>'person',
                                     'condition'=>'id=:contact',
                                     'params'=>array(':contact'=>$contac->id),
                               ));     
	              
	              	              
	             if($le_referencie!=null)
				    {  
		              $user = $modelUser->find(array('select'=>'username',
			                                     'condition'=>'person_id=:le_referencie AND is_parent=1',
			                                     'params'=>array(':le_referencie'=>$le_referencie->person),
			                               ));
					
						
							if($user!=null)			   
									return $user->username;
							else
								return null;	
				    }

		      
		      }
		     
      }
      
      
		
	 }
	 

        

	
    

	
}
