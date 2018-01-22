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


// auto-loading

//inherit from BaseUser 



class User extends BaseUser

{
    
        public $password_repeat;
        public $new_password;
        public $profil_name;
        public $group_name;
        public $sortOption;
        public $person_;
        public $room;
         
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public $arroondissement_name;
  public function rules()
	{
              
              return array_merge(
		    	parent::rules(), array(
                           
                            array('username','unique'),
                            
                            array('profil', 'required'), //array('password,profil', 'required'),
                            array('username', 'length', 'max'=>20),
                            array('full_name', 'length', 'max'=>255),
                           
                            array('password', 'length', 'max'=>128),
                            array('password_repeat', 'length', 'max'=>128),
                            array('new_password', 'length', 'max'=>128),
                            array('password', 'passwordCompare'),
                            array('password_repeat, active', 'safe'),
                            array('username, profil,active, full_name','safe','on'=>'search'),
                            
							
									
									));
	}
        
    public function attributeLabels() {
        return array_merge(
        parent::attributeLabels(),
                array('password_repeat'=>Yii::t('app','Repeat Password'),
                       'new_password'=>Yii::t('app','New Password'),
                        'profilUser'=>Yii::t('app','Profil User'),
                        'activeUser'=>Yii::t('app','Active User ?'),
                        'sortOption'=>Yii::t('app','Sorting option'),
                        'full_name'=>Yii::t('app','Full name'),
                        'person.fullName'=> Yii::t('app','Student name'),
                        'person'=>Yii::t('app','Person'),
                        'room'=>Yii::t('app','Room'),)
        );
        
    }
	
		// Compare two password 
		    public function passwordCompare($attribute, $params){
		            $message = Yii::t('app','Password must be identic !');
		            if(md5($this->new_password)<> md5($this->password_repeat))
		            {
		                $params = array(
		                    '{attribute}'=>$this->new_password, '{compareValue}'=>$this->password_repeat
		                );
		                
		                $this->password='';
		                $this->new_password='';
		                $this->password_repeat='';
		                
		                $this->addError('password_repeat', strtr($message, $params));
		            }
		        }
		        
		   
	
    
public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		
		

		$criteria->condition = "active=1 AND username NOT IN ('_developer_','super_user','super_manager')";
	    
	    $criteria->compare('id',$this->id,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('active',$this->active,true);
		$criteria->compare('password',$this->password,true);
		
		$criteria->compare('profil0.profil_name',$this->profil_name,true);
		$criteria->compare('full_name',$this->full_name,true);
                
                
                $sort = new CSort;
                $sort->attributes = array(
                    'full_name'=>array(
                        'asc'=>'full_name',
                        
                    ),
                    
                    '*',
                );

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort,
			'pagination'=>array(
        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    			),
                        
		));
	}

public function searchByCategorie($person,$room)
	{
		$acad_sess=acad_sess();    
$acad=Yii::app()->session['currentId_academic_year']; 

		$criteria=new CDbCriteria;
		
	 if($room=='')
		{
         if($person==0)  //students
            $criteria->condition = 'active=1 AND username NOT IN ("_developer_","super_user","super_manager") and profil=5 and group_id=3 and is_parent=0';
         elseif($person==1)  //parents
		    $criteria->condition = 'active=1 AND username NOT IN ("_developer_","super_user","super_manager") and profil=5 and group_id=4 and is_parent=1';
		    elseif($person=='')
		         $criteria->condition = 'active=1 AND username NOT IN ("_developer_","super_user","super_manager") ';
		    
		}
	  elseif($room!='')
		{
		    if($person==0)  //students
            $criteria->condition = 'active=1 AND username NOT IN ("_developer_","super_user","super_manager") and profil=5 and group_id=3 and is_parent=0 and person_id in( select p.id from persons p inner join room_has_person rhp on(rhp.students=p.id) where room='.$room.' and academic_year='.$acad_sess.') ';
         elseif($person==1)  //parents
		    $criteria->condition = 'active=1 AND username NOT IN ("_developer_","super_user","super_manager") and profil=5 and group_id=4 and is_parent=1 and person_id in( select c.person from contact_info c inner join room_has_person rhp on(rhp.students=c.person) where rhp.room='.$room.' and academic_year='.$acad_sess.') ';
		    
		 }
		 
	    
	    $criteria->compare('id',$this->id,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('active',$this->active,true);
		$criteria->compare('password',$this->password,true);
		
		$criteria->compare('profil0.profil_name',$this->profil_name,true);
		$criteria->compare('full_name',$this->full_name,true);
		        
                
                $sort = new CSort;
                $sort->attributes = array(
                    'full_name'=>array(
                        'asc'=>'full_name',
                        
                    ),
                    
                    '*',
                );

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort,
			'pagination'=>array(
        			'pageSize'=> 100000,
    			),
                        
		));
	}

	
public function getPersonByUserId($id)
	{    
			$criteria = new CDbCriteria;
			
			$criteria->alias = 'u';
			$criteria->select = 'p.id, u.person_id, p.last_name, p.first_name, p.email, p.gender,  p.blood_group, p.is_student ';
			$criteria->join = 'left join persons p on (p.id = u.person_id)';
			
			$criteria->condition = 'u.id='.$id;
						
    return new CActiveDataProvider($this, array(
       
		'criteria'=>$criteria,
    ));
          
    }
	
	
	public function searchDisableUsers()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->condition = 'active=0';
	    
	    $criteria->compare('id',$this->id,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('active',$this->active,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('profil',$this->profil,true);
		$criteria->compare('full_name',$this->full_name);
                
                
                $sort = new CSort;
                $sort->attributes = array(
                    'full_name'=>array(
                        'asc'=>'full_name',
                        
                    ),
                    
                    '*',
                );

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			
                        'sort'=>$sort,
                        'pagination'=>array(
        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    			),
		));
	}

        
        // hashing password 
        
        
        public function hash($value){
            
           // return crypt($value);
			return md5($value);
        }
        
        // hashing the password before save action
        protected function beforeSave()
        {
            if (parent::beforeSave()){
                $this->password = $this->hash($this->password);
            return true;
            }
            return true; // a retourner a false
        }
        
        // verify the value of the password are correct using the hash 
        
        public function check($value)
        {
           
            
            
           if(md5($value) == $this->password){
               return true;
              }
             
             return false;
            
            
        }
	
        /**
         * 
         * @return type
         */
        public function getProfilUser()
                {
                    switch($this->profil) 
                    {
                        case 1:
                        
                            return Yii::t('app','Administrator'); 
                            break; 
                        case 2:
                       
                            return Yii::t('app','Manager');
                            break; 
                        
                        case 3:
                        
                            return Yii::t('app','Accounter');
                        
                        case 4:
                       
                            return Yii::t('app','Teacher');
                        
                        case 5:
                       
                            return Yii::t('app','Guest');    
                        
                        case 6:
                        
                            return Yii::t('app','Reporter');
                            break; 
                                                                        
                            
                        default:
                            return Yii::t('app','N/A');
                            
                    }
                            
                }
		
		public function getNomPerson(){
			return $this->person->fullName;
		}
                
                /**
                 * Return if yes or not the user is active 
                 * 
                 */
        
        public function getActiveUser(){
             
           if($this->active==1)
               return Yii::t('app','Yes');
                   else
                       return Yii::t('app','No'); 
      
        }
        
        public static function getOnlineUsers()
    {
        $sql = "SELECT session.user_id, session.last_ip, users.id, users.username, users.full_name, users.group_id FROM session LEFT JOIN users ON users.id=session.user_id WHERE users.username not in('_developer_','super_user','super_manager')";
        $command = Yii::app()->db->createCommand($sql);
 
        return $command->queryAll();
    }

	
}
