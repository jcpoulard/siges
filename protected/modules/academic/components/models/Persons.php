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


class Persons extends BasePersons
{
	
    const MALE = 0;
    const FEMALE = 1;
    
    public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	    public $room_name;
        public $make_initials;
        public $teacher_last_name; 
        public $teacher_first_name;
        public $teacher_lname; 
        public $teacher_fname;
        
          public $cost;  // Admission
		  public $transcript_note_text;
		  public $transcript_footer_text;
		   public $transcript_signature;
		   public $administration_signature_text;
		  public $header_text_date;
		 public $transcriptItems;
		 public $transcriptAcadList;
         public $student;
          public $student_id;
         public $list_id;
         
         public $idPs;
         public $personId;
        
        public $sort_by_level;
        public $total_stud;
        public $total_gender;
        public $grade_value;
        public $decision_finale;
        
        public $apply_for_level;
        public $menfp; //classSetup
        public $level_name;
        public $short_level_name;
        public $person_liable_phone;
        
        //payroll
        public $amount;
        public $an_hour;
        public $number_of_hour;
        public $academic_year;
        public $net_salary;
        public $payment_date;
        public $taxe;
        
        public $general_average;
        public $mention;
        public $comments;
        public $is_move_to_next_year;
        public $current_level;
        public $next_level;
        public $city_name;
        
        
		public $image;
		
		
		
      
	
  public function rules()
	{
              
          return array_merge(
                parent::rules(), array(
                    array('gender', 'required'),
                  array('id_number,email','unique'),
				   array('transcript_note_text, transcript_footer_text, header_text_date', 'length', 'max'=>255),
                  array('email','email'), 
                  array('cost', 'numerical'),
                  array('id, list_id, teacher_last_name,transcript_signature,administration_signature_text,transcript_note_text, transcript_footer_text, header_text_date, teacher_first_name, teacher_lname, teacher_fname, last_name, first_name, gender, blood_group, birthday,citizenship, id_number, adresse, phone, email, cities, comment, nif_cin, identifiant,matricule,mother_first_name, date_created, date_updated, create_by, update_by', 'safe', 'on'=>'search'),
				  array('image', 'file', 'safe' => true, 'types' => 'jpg, jpeg, gif, png', 'allowEmpty' => true, 'on'=>'create, update'),
				 

                      
									
		));
	}
        
        
 public function attributeLabels()
	{
		
            return array_merge(
                    parent::attributeLabels(), 
                    array('person_fname'=>Yii::t('app','First Name'),
                    'person_lname'=>Yii::t('app','Last Name'),
                    'fullName'=>Yii::t('app','Full name'),    
					'image'=>yii::t('app','Image'),
					'status'=>Yii::t('app','Status'),
                    'active'=>Yii::t('app','Active'),
                    'blood_group'=>Yii::t('app','Blood Group'),
                    
                    'sexe'=>Yii::t('app','Sexe'),
                    
                    'sort_by_level'=>Yii::t('app','Sort By Level'),
                    
                    'city_name'=>Yii::t('app','Birth place'),
                    'cities0.city_name'=>Yii::t('app','Birth place'),
					'general_average'=>Yii::t('app','General Average'),
					'mention'=>Yii::t('app','Mention'),
					'comments'=>Yii::t('app','Comments'),
					
                    'current_level'=>Yii::t('app','Current Level'),
                    'next_level'=>Yii::t('app','Next Level'),
                    'menfp'=>Yii::t('app','MENFP list'),
                    'person_liable_phone'=>Yii::t('app','Person liable phone'),
                    'list_id'=>Yii::t('app','List ID'),
					'transcript_note_text'=>Yii::t('app','transcript note text'),
					'header_text_date'=>Yii::t('app','Header text date'),
					'transcript_footer_text'=>Yii::t('app','Footer text'),
					'transcript_signature'=>Yii::t('app','Signature'),
					'administration_signature_text'=>Yii::t('app','Administration Signature Text'),
					
										
					
                    
                    
                        )
                    );
           
	}

        
    
	public function searchById($id)
	{     
			$criteria = new CDbCriteria;
			
			$criteria->condition = 'id=:idPers ';
			$criteria->params = array(':idPers' => $id);
			
			$criteria->alias = 'p';
			$criteria->select = 'p.id, p.last_name , p.first_name, p.gender, p.id_number, p.nif_cin';
			
		    			
    return new CActiveDataProvider($this, array(
        'pagination'=>array(
        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    			),
		'criteria'=>$criteria,
    ));
          
			   
	
    }
	
	
	
public function searchStudents_($condition,$acad)
	{    
			$criteria = new CDbCriteria;
			 
			$criteria->alias='p';
        	$criteria->join = 'left join room_has_person rh on (p.id = rh.students)';
			$criteria->condition = $condition.' p.is_student=1 AND rh.academic_year='.$acad;
			

		$criteria->compare('id',$this->id);

		$criteria->compare('last_name',$this->last_name,true);

		$criteria->compare('first_name',$this->first_name,true);

		$criteria->compare('gender',$this->gender,true);
		
		$criteria->compare('blood_group',$this->blood_group,true);

		$criteria->compare('birthday',$this->birthday,true);
		
		$criteria->compare('citizenship',$this->citizenship,true);

		$criteria->compare('id_number',$this->id_number,true);

		$criteria->compare('adresse',$this->adresse,true);

		$criteria->compare('phone',$this->phone,true);

		$criteria->compare('email',$this->email,true);

		$criteria->compare('cities',$this->cities);

		$criteria->compare('date_created',$this->date_created,true);

		$criteria->compare('date_updated',$this->date_updated,true);
		
		$criteria->compare('comment',$this->comment,true);


			
        
        $criteria->order = 'last_name ASC';		
			
    return new CActiveDataProvider($this, array(
        'pagination'=>array(
        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    			),
		'criteria'=>$criteria,
    ));
    	
    }
    


public function searchStudentsForTeacher($condition,$id_teacher,$acad)
	{    
          
			$criteria = new CDbCriteria;
			 
			$criteria->alias='p';
			$criteria->distinct=true;
        	$criteria->join = 'left join room_has_person rh on (p.id = rh.students) left join courses c on(c.room=rh.room)';
			$criteria->condition = $condition.' p.is_student=1 AND c.teacher='.$id_teacher.' AND rh.academic_year='.$acad;
			

		$criteria->compare('id',$this->id);

		$criteria->compare('last_name',$this->last_name,true);

		$criteria->compare('first_name',$this->first_name,true);

		$criteria->compare('gender',$this->gender,true);
		
		$criteria->compare('blood_group',$this->blood_group,true);

		$criteria->compare('birthday',$this->birthday,true);
		
		$criteria->compare('citizenship',$this->citizenship,true);

		$criteria->compare('id_number',$this->id_number,true);

		$criteria->compare('adresse',$this->adresse,true);

		$criteria->compare('phone',$this->phone,true);

		$criteria->compare('email',$this->email,true);

		$criteria->compare('cities',$this->cities);

		$criteria->compare('date_created',$this->date_created,true);

		$criteria->compare('date_updated',$this->date_updated,true);
	
        
        $criteria->order = 'last_name ASC';		
			
    return new CActiveDataProvider($this, array(
        'pagination'=>array(
        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    			),
		'criteria'=>$criteria,
    ));
    	
    }
    




    public function searchStudentsReport($condition,$acad)
	{    
          
			$criteria = new CDbCriteria;
			 
			$criteria->alias='p';
        	$criteria->join = 'left join room_has_person on (p.id = room_has_person.students)';
			$criteria->condition = $condition.' p.is_student=1 AND room_has_person.academic_year='.$acad;
			

		$criteria->compare('id',$this->id);

		$criteria->compare('last_name',$this->last_name,true);

		$criteria->compare('first_name',$this->first_name,true);

		$criteria->compare('gender',$this->gender,true);
		
		$criteria->compare('blood_group',$this->blood_group,true);

		$criteria->compare('birthday',$this->birthday,true);
		
		$criteria->compare('citizenship',$this->citizenship,true);

		$criteria->compare('id_number',$this->id_number,true);

		$criteria->compare('adresse',$this->adresse,true);

		$criteria->compare('phone',$this->phone,true);

		$criteria->compare('email',$this->email,true);

		$criteria->compare('cities',$this->cities);

		$criteria->compare('date_created',$this->date_created,true);

		$criteria->compare('date_updated',$this->date_updated,true);

        
        $criteria->order = 'last_name ASC';		
			
    return new CActiveDataProvider($this, array(
        'pagination'=>array(
        			'pageSize'=>1000000,
    			),
		'criteria'=>$criteria,
    ));
       
        } 
	
	
	public function searchExStudents_()
	{    
          
			$criteria = new CDbCriteria;
			
			$criteria->alias='p';
        	$criteria->condition = 'p.is_student=1 AND p.active IN (0,3) ';
			
			
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
        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    			),
		'criteria'=>$criteria,
    ));
          
			   
	
    }


	public function searchTotalExStudents_()
	{    
          
			$criteria = new CDbCriteria;
			
			$criteria->alias='p';
        	$criteria->condition = 'p.is_student=1 AND p.active IN (0,3) ';
			
			
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
        			'pageSize'=>1000000,
    			),
		'criteria'=>$criteria,
    ));
          
			   
	
    }
    
    
    
    public function admissionSearch($to_search)
	{     
			$criteria = new CDbCriteria;
			
			$criteria->alias='p';
        	$criteria->condition = 'p.is_student=1 AND p.active=0 AND ( (p.first_name LIKE("'.$to_search.'")) OR (p.last_name LIKE("'.$to_search.'")) ) ';
			
			
		$criteria->compare('id',$this->id);


		$criteria->compare('gender',$this->gender,true);
		
		$criteria->compare('blood_group',$this->blood_group,true);
		
		$criteria->compare('citizenship',$this->citizenship,true);

		$criteria->compare('birthday',$this->birthday,true);

		$criteria->compare('id_number',$this->id_number,true);

		$criteria->compare('adresse',$this->adresse,true);

		$criteria->compare('phone',$this->phone,true);

		$criteria->compare('email',$this->email,true);

		$criteria->compare('cities',$this->cities);
		
		$criteria->compare('paid',$this->paid);

		
        
        $criteria->order = 'last_name ASC';		
			
    return new CActiveDataProvider($this, array(
        'pagination'=>array(
        			'pageSize'=>Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),//10000, 
    			),
		'criteria'=>$criteria,
    ));
          
			   
	
    }

	
    public function admissionSearch_fullname($to_search1,$to_search2)
	{     
			$criteria = new CDbCriteria;
			
			$criteria->alias='p';
        	$criteria->condition = 'p.is_student=1 AND p.active=0 AND p.first_name LIKE("'.$to_search1.'") AND p.last_name LIKE("'.$to_search2.'") ';
			
			
		$criteria->compare('id',$this->id);


		$criteria->compare('gender',$this->gender,true);
		
		$criteria->compare('blood_group',$this->blood_group,true);
		
		$criteria->compare('citizenship',$this->citizenship,true);

		$criteria->compare('birthday',$this->birthday,true);

		$criteria->compare('id_number',$this->id_number,true);

		$criteria->compare('adresse',$this->adresse,true);

		$criteria->compare('phone',$this->phone,true);

		$criteria->compare('email',$this->email,true);

		$criteria->compare('cities',$this->cities);
		
		$criteria->compare('paid',$this->paid);

		
        
        $criteria->order = 'last_name ASC';		
			
    return new CActiveDataProvider($this, array(
        'pagination'=>array(
        			'pageSize'=>Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),//10000, 
    			),
		'criteria'=>$criteria,
    ));
          
			   
	
    }


    public function transcriptNotesSearch_fullname($to_search1,$to_search2)
	{     
			$criteria = new CDbCriteria;
			
			$criteria->alias='p';
        	$criteria->condition = 'p.is_student=1 AND p.first_name LIKE("'.$to_search1.'") AND p.last_name LIKE("'.$to_search2.'") ';
			
			
		$criteria->compare('id',$this->id);


		$criteria->compare('gender',$this->gender,true);
		
		$criteria->compare('blood_group',$this->blood_group,true);
		
		$criteria->compare('citizenship',$this->citizenship,true);

		$criteria->compare('birthday',$this->birthday,true);

		$criteria->compare('id_number',$this->id_number,true);

		$criteria->compare('adresse',$this->adresse,true);

		$criteria->compare('phone',$this->phone,true);

		$criteria->compare('email',$this->email,true);

		$criteria->compare('cities',$this->cities);
		
		$criteria->compare('paid',$this->paid);

		
        
        $criteria->order = 'last_name ASC';		
			
    return new CActiveDataProvider($this, array(
        'pagination'=>array(
        			'pageSize'=>Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),//10000, 
    			),
		'criteria'=>$criteria,
    ));
          
			   
	
    }

	 public function transcriptNotesSearch($to_search)
	{     
			$criteria = new CDbCriteria;
			
			$criteria->alias='p';
        	$criteria->condition = 'p.is_student=1 AND ( (p.first_name LIKE("'.$to_search.'")) OR (p.last_name LIKE("'.$to_search.'")) ) ';
			
			
		$criteria->compare('id',$this->id);


		$criteria->compare('gender',$this->gender,true);
		
		$criteria->compare('blood_group',$this->blood_group,true);
		
		$criteria->compare('citizenship',$this->citizenship,true);

		$criteria->compare('birthday',$this->birthday,true);

		$criteria->compare('id_number',$this->id_number,true);

		$criteria->compare('adresse',$this->adresse,true);

		$criteria->compare('phone',$this->phone,true);

		$criteria->compare('email',$this->email,true);

		$criteria->compare('cities',$this->cities);
		
		$criteria->compare('paid',$this->paid);

		
        
        $criteria->order = 'last_name ASC';		
			
    return new CActiveDataProvider($this, array(
        'pagination'=>array(
        			'pageSize'=>Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),//10000, 
    			),
		'criteria'=>$criteria,
    ));
          
			   
	
    }

public function searchTeacher($condition,$acad)
	{    
          
			$criteria = new CDbCriteria;
			
			$criteria->alias='p';
			$criteria->distinct='true';
			
			
			$criteria->condition = $condition.' p.is_student=0 AND p.id IN(SELECT teacher FROM courses c left join academicperiods a on(a.id=c.academic_period) WHERE c.old_new=1 AND (a.year='.$acad.' OR (a.id='.$acad.')) )  ';
			
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
		
		$criteria->compare('nif_cin',$this->nif_cin,true);

		$criteria->compare('cities',$this->cities);

		$criteria->compare('date_created',$this->date_created,true);

		$criteria->compare('date_updated',$this->date_updated,true);


       $criteria->order = 'last_name ASC';		
					
			
			
			
			
    return new CActiveDataProvider($this, array(
        'pagination'=>array(
        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    			),
		'criteria'=>$criteria,
    ));
          
			   
	
    }
    

	
public function searchTeacherSortBy($condition,$shift,$section,$level,$room,$acad)
	{    
		          
			$criteria = new CDbCriteria;
			
			if(($shift!=null)&&($section!=null)&&($level!=null)&&($room!=null))
			 { $criteria->condition = $condition.' p.is_student=0 AND p.id IN(SELECT teacher FROM courses c left join academicperiods a on(a.id=c.academic_period) INNER JOIN rooms r ON(r.id = c.room) INNER JOIN levels l ON(l.id=r.level) WHERE c.old_new=1 AND r.shift='.$shift.' AND l.section='.$section.' AND r.level='.$level.' AND c.room='.$room.' AND  (a.year='.$acad.' OR (a.id='.$acad.')) )  ';
	         }
			 elseif(($shift!=null)&&($section!=null)&&($level!=null)&&($room==null))
			 {  $criteria->condition = $condition.' p.is_student=0 AND p.id IN(SELECT teacher FROM courses c left join academicperiods a on(a.id=c.academic_period) INNER JOIN rooms r ON(r.id = c.room) INNER JOIN levels l ON(l.id=r.level) WHERE c.old_new=1 AND r.shift='.$shift.' AND l.section='.$section.' AND r.level='.$level.' AND  (a.year='.$acad.' OR (a.id='.$acad.')) )  ';
			 }
			 elseif(($shift!=null)&&($section!=null)&&($level==null)&&($room==null))
			 { $criteria->condition = $condition.' p.is_student=0 AND p.id IN(SELECT teacher FROM courses c left join academicperiods a on(a.id=c.academic_period) INNER JOIN rooms r ON(r.id = c.room) INNER JOIN levels l ON(l.id=r.level) WHERE c.old_new=1 AND r.shift='.$shift.' AND l.section='.$section.' AND  (a.year='.$acad.' OR (a.id='.$acad.')) )  ';
	         }
			 elseif(($shift!=null)&&($section==null)&&($level==null)&&($room==null))
			 { $criteria->condition = $condition.' p.is_student=0 AND p.id IN(SELECT teacher FROM courses c left join academicperiods a on(a.id=c.academic_period) INNER JOIN rooms r ON(r.id = c.room) INNER JOIN levels l ON(l.id=r.level) WHERE c.old_new=1 AND r.shift='.$shift.' AND  (a.year='.$acad.' OR (a.id='.$acad.')) )  ';
	         }
			 else
			  {
			   $criteria->condition = $condition.' p.is_student=-1 AND p.id IN(SELECT teacher FROM courses c left join academicperiods a on(a.id=c.academic_period) INNER JOIN rooms r ON(r.id = c.room) INNER JOIN levels l ON(l.id=r.level) WHERE c.old_new=1 AND r.shift= 0 AND  (a.year='.$acad.' OR (a.id='.$acad.')) )  ';
			   
			  }
			  
			 $criteria->alias = 'p';
			$criteria->distinct='true';
			
			
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
		
		$criteria->compare('nif_cin',$this->nif_cin,true);

		$criteria->compare('cities',$this->cities);

		$criteria->compare('date_created',$this->date_created,true);

		$criteria->compare('date_updated',$this->date_updated,true);

			

       $criteria->order = 'last_name ASC';		
			
			
			
			
    return new CActiveDataProvider($this, array(
        'pagination'=>array(
        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    			),
		'criteria'=>$criteria,
    ));
          
			   
	
    }
    
    public function searchTeacherReport($condition,$acad)
	{    
          
			$criteria = new CDbCriteria;
			
			$criteria->alias='p';
			
			$criteria->condition = $condition.' p.is_student=0 AND p.id IN(SELECT teacher FROM courses c left join academicperiods a on(a.id=c.academic_period) WHERE  c.old_new=1 AND (a.year='.$acad.' OR (a.id='.$acad.'))  ) ';
			
			
			
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
		
		$criteria->compare('nif_cin',$this->nif_cin,true);

		$criteria->compare('cities',$this->cities);

		$criteria->compare('date_created',$this->date_created,true);

		$criteria->compare('date_updated',$this->date_updated,true);

			

       $criteria->order = 'last_name ASC';		
			
			
			
			
    return new CActiveDataProvider($this, array(
        'pagination'=>array(
        			'pageSize'=>1000000,
    			),
		'criteria'=>$criteria,
    ));
          
			   
	
    }
	
	
	public function searchExTeachers()
	{    
          
			$criteria = new CDbCriteria;
			 
		    $criteria->alias='p';
		    $criteria->distinct='true';
			$criteria->join='left join courses c on(p.id=c.teacher) ';
			$criteria->condition = 'is_student=0 AND active=0 ';

		
 
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
		
		$criteria->compare('nif_cin',$this->nif_cin,true);

		$criteria->compare('cities',$this->cities);

		$criteria->compare('date_created',$this->date_created,true);

		$criteria->compare('date_updated',$this->date_updated,true);

					
		
		$criteria->order = 'last_name ASC';
			
			
			
			
    return new CActiveDataProvider($this, array(
        'pagination'=>array(
        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    			),
		'criteria'=>$criteria,
    ));
          
			   
	
    }
	
	public function searchTotalExTeachers()
	{    
			$criteria = new CDbCriteria;
			 
		    $criteria->alias='p';
		    $criteria->distinct='true';
			$criteria->join='left join courses c on(p.id=c.teacher) ';
			$criteria->condition = 'is_student=0 AND active=0 ';

		
 
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
		
		$criteria->compare('nif_cin',$this->nif_cin,true);

		$criteria->compare('cities',$this->cities);

		$criteria->compare('date_created',$this->date_created,true);

		$criteria->compare('date_updated',$this->date_updated,true);

					
		
		$criteria->order = 'last_name ASC';
			
			
			
			
    return new CActiveDataProvider($this, array(
        'pagination'=>array(
        			'pageSize'=>1000000,
    			),
		'criteria'=>$criteria,
    ));
          
			   
	
    }
	
		
	public function searchEmployee($condition,$acad)
	{   
        $siges_structure = infoGeneralConfig('siges_structure_session');
		
			$criteria = new CDbCriteria;
			
			 $criteria->alias='p';
			 
					
        if($siges_structure==1)
		     $criteria->condition = $condition.' p.is_student=0 AND p.id NOT IN(SELECT teacher FROM courses c inner join academicperiods a on(a.id=c.academic_period) WHERE c.old_new=1 AND a.id='.$acad.' ) ';
		elseif($siges_structure==0)
		    $criteria->condition = $condition.' p.is_student=0 AND p.id NOT IN(SELECT teacher FROM courses c inner join academicperiods a on(a.id=c.academic_period) WHERE c.old_new=1 AND a.year='.$acad.' ) ';

		   
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
		
		$criteria->compare('nif_cin',$this->nif_cin,true);

		$criteria->compare('cities',$this->cities);

		$criteria->compare('date_created',$this->date_created,true);

		$criteria->compare('date_updated',$this->date_updated,true);

		$criteria->compare('create_by',$this->create_by,true);

		$criteria->compare('update_by',$this->update_by,true);			
		
		$criteria->order = 'last_name ASC';
			
			
			
			
			
    return new CActiveDataProvider($this, array(
        'pagination'=>array(
        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    			),
		'criteria'=>$criteria,
    ));
          
			   
	
    }
    
    public function searchEmployeeReport($condition,$acad)
	{    
         $siges_structure = infoGeneralConfig('siges_structure_session');
		 
			$criteria = new CDbCriteria;
			
			$criteria->alias='p';
					
		if($siges_structure==1)
		   $criteria->condition = $condition.' p.is_student=0 AND p.id NOT IN(SELECT teacher FROM courses c left join academicperiods a on(a.id=c.academic_period) WHERE c.old_new=1 AND a.id='.$acad.' ) ';
		elseif($siges_structure==0)
		   $criteria->condition = $condition.' p.is_student=0 AND p.id NOT IN(SELECT teacher FROM courses c left join academicperiods a on(a.id=c.academic_period) WHERE c.old_new=1 AND a.year='.$acad.' ) ';

		   
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
		
		$criteria->compare('nif_cin',$this->nif_cin,true);

		$criteria->compare('cities',$this->cities);

		$criteria->compare('date_created',$this->date_created,true);

		$criteria->compare('date_updated',$this->date_updated,true);

		$criteria->compare('create_by',$this->create_by,true);

		$criteria->compare('update_by',$this->update_by,true);			
		
		$criteria->order = 'last_name ASC';
			
			
			
			
			
    return new CActiveDataProvider($this, array(
        'pagination'=>array(
        			'pageSize'=> 1000000,
    			),
		'criteria'=>$criteria,
    ));
          
			   
	
    }
	
	
	
	public function searchExEmployee()
	{    
          
			$criteria = new CDbCriteria;
			
			$criteria->distinct='true';
			$criteria->condition = 'is_student=0 AND active=0 AND id NOT IN (Select teacher from courses )';
			
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
		
		$criteria->compare('nif_cin',$this->nif_cin,true);

		$criteria->compare('cities',$this->cities);

		$criteria->compare('date_created',$this->date_created,true);

		$criteria->compare('date_updated',$this->date_updated,true);

		$criteria->compare('create_by',$this->create_by,true);

		$criteria->compare('update_by',$this->update_by,true);			
		
		$criteria->order = 'last_name ASC';
		
			
    return new CActiveDataProvider($this, array(
        'pagination'=>array(
        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    			),
		'criteria'=>$criteria,
    ));
          
   }
	

	public function searchTotalExEmployee()
	{    
          
			$criteria = new CDbCriteria;
			
			$criteria->distinct='true';
			$criteria->condition = 'is_student=0 AND active=0 AND id NOT IN (Select teacher from courses )';
			
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
		
		$criteria->compare('nif_cin',$this->nif_cin,true);

		$criteria->compare('cities',$this->cities);

		$criteria->compare('date_created',$this->date_created,true);

		$criteria->compare('date_updated',$this->date_updated,true);

		$criteria->compare('create_by',$this->create_by,true);

		$criteria->compare('update_by',$this->update_by,true);			
		
		$criteria->order = 'last_name ASC';
			
			
    return new CActiveDataProvider($this, array(
        'pagination'=>array(
        			'pageSize'=>1000000,
    			),
		'criteria'=>$criteria,
    ));
          
			   
	
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
		
		$criteria->compare('nif_cin',$this->nif_cin,true);

		$criteria->compare('cities',$this->cities);

		$criteria->compare('p.date_created',$this->date_created,true);

		$criteria->compare('p.date_updated',$this->date_updated,true);

		$criteria->compare('p.create_by',$this->create_by,true);

		$criteria->compare('p.update_by',$this->update_by,true);			
		
		$criteria->order = 'last_name ASC';
			
			
			
			
			
    return new CActiveDataProvider($this, array(
        'pagination'=>array(
        			'pageSize'=> 1000000,
    			),
		'criteria'=>$criteria,
    ));
          
			   
	
    }




public function isEmployeeTeacher($person_id, $acad)  
  { 
  	$siges_structure = infoGeneralConfig('siges_structure_session');
	
  	$title=PersonsHasTitles::model()->findByAttributes(array('persons_id'=>$person_id,'academic_year'=>$acad));
		                      
		                     if($title!=null)
		                       { 
		                       	   $title_id= $title->titles_id;	
						
									 //tchecke sil fe kou
                                     $course=new Courses;
                  	                 
                               if($siges_structure==1)
							    {	$idCourse = $course->find(array('alias'=>'c',
                  	  				 'select'=>'c.id',
                                     'join'=>'inner join academicperiods a on(a.id=c.academic_period) ',
                                     'condition'=>'c.old_new=1 AND c.teacher=:empID AND (c.academic_period=:acad OR a.id=:acad)',
                                     'params'=>array(':empID'=>$person_id,':acad'=>$acad),
                                      ));
							
								}
								elseif($siges_structure==0)
								  { $idCourse = $course->find(array('alias'=>'c',
                  	  				 'select'=>'c.id',
                                     'join'=>'inner join academicperiods a on(a.id=c.academic_period) ',
                                     'condition'=>'c.old_new=1 AND c.teacher=:empID AND (c.academic_period=:acad OR a.year=:acad)',
                                     'params'=>array(':empID'=>$person_id,':acad'=>$acad),
                                      ));  

								  }								  
                                       if($idCourse!=null)
                                         {

                                         	 return true;
                                         	
                                         	}
			
		                        }

           return false;
  	
   }


//return 0 when employee, 1 when teacher; return 2 when employee-teacher; return -1 when either employee nor teacher
public function isEmployeeOrTeacher($person_id, $acad)  
  { 
  		$siges_structure = infoGeneralConfig('siges_structure_session');

		$return_value =-1;   
  	 
  	$title=PersonsHasTitles::model()->findByAttributes(array('persons_id'=>$person_id,'academic_year'=>$acad));
		                      
		                     if($title!=null)
		                       { 	
		                       	  $return_value = 0;	                       	 
		                       	    
		                       	    //tchecke sil fe kou
                                     $course=new Courses;
                  	                 
                                           
                               if($siges_structure==1)
							    {	$idCourse = $course->find(array('alias'=>'c',
                  	  				 'select'=>'c.id',
                                     'join'=>'inner join academicperiods a on(a.id=c.academic_period) ',
                                     'condition'=>'c.old_new=1 AND c.teacher=:empID AND (c.academic_period=:acad OR a.id=:acad)',
                                     'params'=>array(':empID'=>$person_id,':acad'=>$acad),
                                      ));
							
								}
								elseif($siges_structure==0)
								  { $idCourse = $course->find(array('alias'=>'c',
                  	  				 'select'=>'c.id',
                                     'join'=>'inner join academicperiods a on(a.id=c.academic_period) ',
                                     'condition'=>'c.old_new=1 AND c.teacher=:empID AND (c.academic_period=:acad OR a.year=:acad)',
                                     'params'=>array(':empID'=>$person_id,':acad'=>$acad),
                                      ));  

								  }		  
                                       if($idCourse!=null)
                                         {
                                         	 $return_value = 2;
                                         	
                                         	}
			
		                        }
		                      else
		                       { 
		                       	    //tchecke sil fe kou
                                     $course=new Courses;
                  	                
                                                   
                               if($siges_structure==1)
							    {	 $idCourse = $course->find(array('alias'=>'c',
                  	  				 'select'=>'c.id',
                                     'join'=>'inner join academicperiods a on(a.id=c.academic_period) ',
                                     'condition'=>'c.old_new=1 AND c.teacher=:empID AND (c.academic_period=:acad OR a.id=:acad)',
                                     'params'=>array(':empID'=>$person_id,':acad'=>$acad),
                                      ));
							
								}
								elseif($siges_structure==0)
								  {  $idCourse = $course->find(array('alias'=>'c',
                  	  				 'select'=>'c.id',
                                     'join'=>'inner join academicperiods a on(a.id=c.academic_period) ',
                                     'condition'=>'c.old_new=1 AND c.teacher=:empID AND (c.academic_period=:acad OR a.year=:acad)',
                                     'params'=>array(':empID'=>$person_id,':acad'=>$acad),
                                      ));  

								  } 
                                       if($idCourse!=null)
                                         {   
                                         	$return_value = 1;
                                         	
                                         	}
			
		                        }



           return $return_value;
  	
   }

	
	/**
     * Dataprovider of inactive people in the database include students, employees and teacher
     * @return \CActiveDataProvider
     */
    
  public function searchInactivePerson()
  {
        $criteria = new CDbCriteria;
			
        $criteria->condition = 'p.active = 0';
		
		$criteria->alias='p';
        $criteria->select = 'p.id, p.last_name, p.first_name, p.gender, p.id_number, p.blood_group, p.citizenship, p.birthday, p.adresse, p.phone, p.email, p.cities';
      
        	
      
        $criteria->order = 'last_name ASC';
			
        return new CActiveDataProvider($this, array(
        'pagination'=>array(
        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    			),
		'criteria'=>$criteria,
        ));
}

  public function searchTotalInactivePerson()
  {
        $criteria = new CDbCriteria;
			
        $criteria->condition = 'p.active = 0';
		
		$criteria->alias='p';
        $criteria->select = 'p.id, p.last_name, p.first_name, p.gender, p.id_number, p.blood_group, p.citizenship, p.birthday, p.adresse, p.phone, p.email, p.cities';
       
        	
      
        $criteria->order = 'last_name ASC';
			
        return new CActiveDataProvider($this, array(
        'pagination'=>array(
        			'pageSize'=>1000000,
    			),
		'criteria'=>$criteria,
        ));
}

	
    
public function searchStudentsByShift($condition,$shift,$acad)
	{    
			$criteria = new CDbCriteria;
			
			
			$criteria->condition = $condition.' p.is_student=1  AND h.room IN (Select id from rooms where shift=:idShift) AND h.academic_year=:acad';
			$criteria->params = array(':idShift' => $shift,':acad'=>$acad);
			
			$criteria->alias = 'p';
			$criteria->select = ' p.id, p.last_name, p.first_name, p.gender, p.blood_group, p.id_number';
			$criteria->join = 'left join room_has_person h on (p.id = h.students)';
			
			$criteria->order = 'last_name ASC';
          
		    
			
    return new CActiveDataProvider($this, array(
        'pagination'=>array(
        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    			),
				
		'criteria'=>$criteria,
    ));
          
    }
	

	
	
public function searchStudentsByLevel($condition,$idLevel,$acad)
	{    
			$criteria = new CDbCriteria;
			
			
			$criteria->condition = $condition.' p.is_student=1  AND lh.level=:idLevel AND lh.academic_year=:acad1 AND p.id NOT IN(SELECT students FROM room_has_person WHERE academic_year=:acad2)';
			$criteria->params = array(':idLevel' => $idLevel,':acad1'=>$acad,':acad2'=>$acad);
			
			$criteria->alias = 'p';
			$criteria->select = 'p.id, p.last_name, p.first_name, p.gender,  p.blood_group, p.id_number';
			$criteria->join = 'left join level_has_person lh on (p.id = lh.students)';
			
			$criteria->order = 'last_name ASC';
         
		    
			
    return new CActiveDataProvider($this, array(
        'pagination'=>array(
        			'pageSize'=> 100000,
    			),
				
		'criteria'=>$criteria,
    ));
          
    }
	

	
public function searchStudentsBySection($condition,$section,$acad)
	{    
			$criteria = new CDbCriteria;
			
			
			$criteria->condition = $condition.' p.is_student=1  AND h.room IN (Select r.id from rooms r left join levels l on(l.id=r.level) where l.section=:idSection) AND h.academic_year=:acad';
			$criteria->params = array(':idSection' => $section,':acad'=>$acad);
			
			$criteria->alias = 'p';
			$criteria->select = ' p.id, p.last_name, p.first_name, p.gender, p.blood_group, p.id_number';
			$criteria->join = 'left join room_has_person h on (p.id = h.students)';
			
			$criteria->order = 'last_name ASC';
           
		    
			
    return new CActiveDataProvider($this, array(
        'pagination'=>array(
        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    			),
				
		'criteria'=>$criteria,
    ));
          
    }	
	
	
	
	
public function searchStudentsByShiftSection($condition,$shift,$section,$acad)
	{    

			$criteria = new CDbCriteria;
			
			
			$criteria->condition = $condition.' p.is_student=1  AND h.room IN (Select r.id from rooms r left join levels l on(l.id=r.level) where r.shift=:idShift AND l.section=:idSection) AND h.academic_year=:acad';
			$criteria->params = array(':idShift' => $shift,':idSection'=>$section,':acad'=>$acad);
			
			$criteria->alias = 'p';
			$criteria->distinct='true';
			$criteria->select = ' p.id, p.last_name , p.first_name, p.gender, p.blood_group, p.id_number';
			$criteria->join = 'left join room_has_person h on (p.id = h.students)';
			
			$criteria->order = 'last_name ASC';
           
		    
		    
    return new CActiveDataProvider($this, array(
        'pagination'=>array(
        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    			),
				
		'criteria'=>$criteria,
    ));
          
			   
	
    }


	
public function searchStudentsByShiftSectionLevel($condition,$shift,$section,$level,$acad)
	{    
      
			$criteria = new CDbCriteria;
			
			
			$criteria->condition = $condition.' p.is_student=1  AND h.room IN (Select r.id from rooms r left join levels l on(l.id=r.level) where r.shift=:idShift AND l.section=:idSection AND r.level=:idLevel) AND h.academic_year=:acad';
			$criteria->params = array(':idShift' => $shift,':idSection'=>$section,':idLevel'=>$level,':acad'=>$acad);
			
			$criteria->alias = 'p';
			$criteria->select = 'p.id, p.last_name , p.first_name, p.gender, p.blood_group, p.id_number';
			$criteria->join = 'left join room_has_person h on (p.id = h.students)';
			
			$criteria->order = 'last_name ASC';
           
		    
		    
    return new CActiveDataProvider($this, array(
        'pagination'=>array(
        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    			),
				
		'criteria'=>$criteria,
    ));
          
			   
	
    }




public function searchStudentsByShiftSectionLevelRoom($condition,$shift,$section,$level,$room,$acad)
	{    
    
			$criteria = new CDbCriteria;
			
			
			$criteria->condition = $condition.' p.is_student=1  AND h.room IN (Select r.id from rooms r left join levels l on(l.id=r.level) where r.shift=:idShift AND l.section=:idSection AND r.level=:idLevel AND r.id=:roomId) AND h.academic_year=:acad';
			$criteria->params = array(':idShift' => $shift,':idSection'=>$section,':idLevel'=>$level,':roomId'=>$room,':acad'=>$acad);
			
			$criteria->alias = 'p';
			$criteria->select = 'p.id, p.last_name , p.first_name, p.gender, p.blood_group, p.id_number';
			$criteria->join = 'left join room_has_person h on (p.id = h.students)';
			
			$criteria->order = 'last_name ASC';
           
		    
    return new CActiveDataProvider($this, array(
        'pagination'=>array(
        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    			),
				
		'criteria'=>$criteria,
    ));
          
			   
	
    }

    
    
    
 public function searchStudentsToDisable($condition,$shift,$section,$level,$room,$acad)
	{    
        
			$criteria = new CDbCriteria;
			
			
			$criteria->condition = $condition.' p.is_student=1  AND h.room IN (Select r.id from rooms r left join levels l on(l.id=r.level) where r.shift=:idShift AND l.section=:idSection AND r.level=:idLevel AND r.id=:roomId) AND h.academic_year=:acad';
			$criteria->params = array(':idShift' => $shift,':idSection'=>$section,':idLevel'=>$level,':roomId'=>$room,':acad'=>$acad);
			
			$criteria->alias = 'p';
			$criteria->select = 'p.id, p.last_name , p.first_name, p.gender, p.blood_group, p.id_number';
			$criteria->join = 'left join room_has_person h on (p.id = h.students)';
			
			$criteria->order = 'last_name ASC';
           
		    
    return new CActiveDataProvider($this, array(
        'pagination'=>array(
        			'pageSize'=>10000,
    			),
				
		'criteria'=>$criteria,
    ));
          
			   
	
    }


	
public function searchStudents($condition,$shift,$section,$level,$room,$acad)
	{      
			$criteria = new CDbCriteria;
			
			
			if(($shift!=null)&&($section!=null)&&($level!=null)&&($room!=null))
			 { $criteria->condition = $condition.' p.is_student=1  AND h.room IN (Select r.id from rooms r left join levels l on(l.id=r.level) where r.shift=:idShift AND l.section=:idSection AND r.level=:idLevel AND r.id=:roomId) AND h.academic_year=:acad';
			   $criteria->params = array(':idShift' => $shift,':idSection'=>$section,':idLevel'=>$level,':roomId'=>$room,':acad'=>$acad);
	         }
			 elseif(($shift!=null)&&($section!=null)&&($level!=null)&&($room==null))
			 {  $criteria->condition = $condition.' p.is_student=1  AND h.room IN (Select r.id from rooms r left join levels l on(l.id=r.level) where r.shift=:idShift AND l.section=:idSection AND r.level=:idLevel) AND h.academic_year=:acad';
			    $criteria->params = array(':idShift' => $shift,':idSection'=>$section,':idLevel'=>$level,':acad'=>$acad);
			 }
			 elseif(($shift!=null)&&($section!=null)&&($level==null)&&($room==null))
			 { $criteria->condition = $condition.' p.is_student=1  AND h.room IN (Select r.id from rooms r left join levels l on(l.id=r.level) where r.shift=:idShift AND l.section=:idSection) AND h.academic_year=:acad';
			   $criteria->params = array(':idShift' => $shift,':idSection'=>$section,':acad'=>$acad);
	         }
			 elseif(($shift!=null)&&($section==null)&&($level==null)&&($room==null))
			 { $criteria->condition = $condition.' p.is_student=1  AND h.room IN (Select id from rooms where shift=:idShift) AND h.academic_year=:acad';
			   $criteria->params = array(':idShift' => $shift,':acad'=>$acad);
	         }
			 else
			  {
			   $criteria->condition = $condition.' p.is_student=-1  AND h.room IN (Select id from rooms where shift=:idShift) AND h.academic_year=:acad';
			   $criteria->params = array(':idShift' => 0,':acad'=>$acad);
			  }
			  
			 $criteria->alias = 'p';
			$criteria->distinct='true';
			$criteria->select = 'p.id, p.last_name , p.first_name, p.gender, p.blood_group, p.id_number';
			$criteria->join = 'left join room_has_person h on (p.id = h.students)';
			$criteria->order = 'last_name ASC';
			
		    
		    		
    return new CActiveDataProvider(get_class($this), array(
        'pagination'=>array(
        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    			),
				
		'criteria'=>$criteria,
    ));
          
			   
	
    }
    
 
 //movement
 public function searchStudentsToMove($condition,$shift,$section,$level,$room,$acad)
	{      
			$criteria = new CDbCriteria;
			
			
			if(($shift!=null)&&($section!=null)&&($level!=null)&&($room!=null))
			 { $criteria->condition = $condition.' p.is_student=1  AND h.room IN (Select r.id from rooms r left join levels l on(l.id=r.level) where r.shift=:idShift AND l.section=:idSection AND r.level=:idLevel AND r.id=:roomId) AND h.academic_year=:acad';
			   $criteria->params = array(':idShift' => $shift,':idSection'=>$section,':idLevel'=>$level,':roomId'=>$room,':acad'=>$acad);
	         }
			 elseif(($shift!=null)&&($section!=null)&&($level!=null)&&($room==null))
			 {  $criteria->condition = $condition.' p.is_student=1  AND h.room IN (Select r.id from rooms r left join levels l on(l.id=r.level) where r.shift=:idShift AND l.section=:idSection AND r.level=:idLevel) AND h.academic_year=:acad';
			    $criteria->params = array(':idShift' => $shift,':idSection'=>$section,':idLevel'=>$level,':acad'=>$acad);
			 }
			 elseif(($shift!=null)&&($section!=null)&&($level==null)&&($room==null))
			 { $criteria->condition = $condition.' p.is_student=1  AND h.room IN (Select r.id from rooms r left join levels l on(l.id=r.level) where r.shift=:idShift AND l.section=:idSection) AND h.academic_year=:acad';
			   $criteria->params = array(':idShift' => $shift,':idSection'=>$section,':acad'=>$acad);
	         }
			 elseif(($shift!=null)&&($section==null)&&($level==null)&&($room==null))
			 { $criteria->condition = $condition.' p.is_student=1  AND h.room IN (Select id from rooms where shift=:idShift) AND h.academic_year=:acad';
			   $criteria->params = array(':idShift' => $shift,':acad'=>$acad);
	         }
		
			 $criteria->alias = 'p';
			$criteria->distinct='true';
			$criteria->select = 'p.id, p.last_name , p.first_name, p.gender, p.blood_group, p.id_number';
			$criteria->join = 'left join room_has_person h on (p.id = h.students)';
			$criteria->order = 'last_name ASC';
			
		    
		    		
    return new CActiveDataProvider(get_class($this), array(
        'pagination'=>array(
        			'pageSize'=> 1000,
    			),
				
		'criteria'=>$criteria,
    ));
          
			   
	
    }
    
    
 
 //Admission
 public function searchStudentsAdmission($condition)
	{    
	$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 
			
			$criteria = new CDbCriteria;
			
			
			$criteria->condition = $condition.' p.is_student=1  AND ( p.id NOT IN(SELECT students FROM level_has_person WHERE academic_year='.$acad_sess.' ) AND ( p.paid is not null) ) AND p.id IN(SELECT student FROM student_other_info) ';
			 
			$criteria->alias = 'p';
			$criteria->join = 'inner join student_other_info soi on(soi.student=p.id)';
			$criteria->select = 'p.id, p.last_name, p.first_name, p.gender,  p.blood_group, p.id_number, p.comment, p.phone, p.email, p.paid, soi.apply_for_level';
			
			$criteria->order = 'last_name ASC';
           
		    
			
    return new CActiveDataProvider($this, array(
         'pagination'=>array(
        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    			),
	
		'criteria'=>$criteria,
    ));
          
    }
	
		
 //RoomAffectation
 public function searchStudentsToAffectRoom($condition,$acad)
	{    
			$criteria = new CDbCriteria;
			
			
			$criteria->condition = $condition.' p.is_student=1  AND ( ((p.id IN(SELECT students FROM level_has_person WHERE academic_year=:acad1) )AND p.id NOT IN(SELECT students FROM room_has_person WHERE academic_year=:acad1)))';
			$criteria->params = array(':acad1'=>$acad,);
			
			$criteria->alias = 'p';
			$criteria->select = 'p.id, p.last_name, p.first_name, p.gender,  p.blood_group, p.id_number,p.comment';
			
			$criteria->order = 'last_name ASC';
           
		    
			
    return new CActiveDataProvider($this, array(
        'pagination'=>array(
        			'pageSize'=> 10000,
    			),		
		'criteria'=>$criteria,
    ));
          
    }
		
		

public function searchTotalStudentsToAffectRoom($condition,$acad)
	{      
			$criteria = new CDbCriteria;
			
			$criteria->alias = 'p';
			$criteria->select = 'COUNT(p.id) as total_stud, p.gender';
			$criteria->group = 'p.gender';
			
			
			   $criteria->condition = $condition.' p.is_student=1  AND ( ((p.id IN(SELECT students FROM level_has_person WHERE academic_year=:acad1) )AND p.id NOT IN(SELECT students FROM room_has_person WHERE academic_year=:acad1)))';//p.id NOT IN(SELECT students FROM level_has_person WHERE academic_year=:acad1)';
			   $criteria->params = array(':acad1'=>$acad,);
	       
		    		
    	    		
    return new CActiveDataProvider(get_class($this), array(
        
				
		'criteria'=>$criteria,
    ));
	
	}
	
		                                      
	
	
	//for stud in level not yet affected to room	
public function searchTotalGenderToAffectRoom($condition,$acad)
	{      
			$criteria = new CDbCriteria;
			
			$criteria->alias = 'p';
			$criteria->select = 'COUNT(p.gender) as total_gender, p.gender';
			$criteria->group = 'p.gender';
			
			    $criteria->condition = $condition.' p.is_student=1  AND ( ((p.id IN(SELECT students FROM level_has_person WHERE academic_year=:acad1) ) AND p.id NOT IN(SELECT students FROM room_has_person WHERE academic_year=:acad1)))';//p.id NOT IN(SELECT students FROM level_has_person WHERE academic_year=:acad1)';
			    
			    $criteria->params = array(':acad1'=>$acad,);
			 
		    		
    return new CActiveDataProvider(get_class($this), array(
        
				
		'criteria'=>$criteria,
    ));
    
    }



 
  //developer	       
  public function searchStudentsToAffectLevelRoom($condition,$acad)
	{    
			$criteria = new CDbCriteria;
			
			$siges_structure = infoGeneralConfig('siges_structure_session');
	     
	   if($siges_structure==0)
	    {
			$criteria->condition = ' p.is_student=1  AND ( (p.id NOT IN(SELECT students FROM level_has_person WHERE academic_year=:acad1) AND ( p.paid=1 AND p.active=2) ) OR (p.id NOT IN(SELECT students FROM level_has_person WHERE academic_year=:acad1) AND p.active=1 AND p.paid is null)  OR (p.id NOT IN(SELECT students FROM level_has_person WHERE academic_year=:acad1) AND p.active IN(1,2)) )     ';
			$criteria->params = array(':acad1'=>$acad);
	    }
	   elseif($siges_structure==1)
	    {
	        $criteria->condition = ' p.is_student=1  AND ( (p.id NOT IN(SELECT students FROM level_has_person WHERE academic_year=:acad1) AND ( p.paid=1 AND p.active=2) ) OR (p.id NOT IN(SELECT students FROM level_has_person WHERE academic_year=:acad1) AND p.active=1 AND p.paid is null)  OR (p.id NOT IN(SELECT students FROM level_has_person ) AND p.active IN(1,2)) )     ';
			$criteria->params = array(':acad1'=>$acad);
	    }
	    
			$criteria->alias = 'p';
			$criteria->select = 'p.id, p.last_name, p.first_name, p.gender,  p.blood_group, p.id_number,p.comment';
			
			$criteria->order = 'last_name ASC';
            
		    
			
    return new CActiveDataProvider($this, array(
        'pagination'=>array(
        			'pageSize'=> 100000,
    			),		
		'criteria'=>$criteria,
    ));
          
    }
	
 
		
//developer	
	 public function searchTotalStudentsToAffectLevelRoom($condition,$acad)
	{      
			$criteria = new CDbCriteria;
			
			$criteria->alias = 'p';
			$criteria->select = 'COUNT(p.id) as total_stud, p.gender';
			$criteria->group = 'p.gender';
			
			$siges_structure = infoGeneralConfig('siges_structure_session');
			if($siges_structure==0)
	           {  $criteria->condition = $condition.' p.is_student=1 AND (p.id NOT IN(SELECT students FROM level_has_person WHERE academic_year=:acad1) )';//p.id NOT IN(SELECT students FROM level_has_person WHERE academic_year=:acad1)';
			   $criteria->params = array(':acad1'=>$acad,);
	           }
	         elseif($siges_structure==1)
	           {  $criteria->condition = $condition.' p.is_student=1 AND (p.id NOT IN(SELECT students FROM level_has_person WHERE academic_year=:acad1)  OR p.id NOT IN(SELECT students FROM level_has_person) )';//p.id NOT IN(SELECT students FROM level_has_person WHERE academic_year=:acad1)';
			   $criteria->params = array(':acad1'=>$acad,);
	           }
	       
		    		
    	    		
    return new CActiveDataProvider(get_class($this), array(
        
				
		'criteria'=>$criteria,
    ));
	
	}
	
		                                      
	
//developer	
	//for stud in level not yet affected to room	
	public function searchTotalGenderToAffectLevelRoom($condition,$acad)
	{      
			$criteria = new CDbCriteria;
			
			$criteria->alias = 'p';
			$criteria->select = 'COUNT(p.gender) as total_gender, p.gender';
			$criteria->group = 'p.gender';
			
			$siges_structure = infoGeneralConfig('siges_structure_session');
			 if($siges_structure==0)
	           {  $criteria->condition = $condition.' p.is_student=1 AND (p.id NOT IN(SELECT students FROM level_has_person WHERE academic_year=:acad1))';
			    
			    $criteria->params = array(':acad1'=>$acad,);
	           }
	         elseif($siges_structure==1)
	           {  $criteria->condition = $condition.' p.is_student=1 AND (p.id NOT IN(SELECT students FROM level_has_person WHERE academic_year=:acad1) OR p.id NOT IN(SELECT students FROM level_has_person) )';
			    
			    $criteria->params = array(':acad1'=>$acad,);
	           }
			 
		    		
    return new CActiveDataProvider(get_class($this), array(
        
				
		'criteria'=>$criteria,
    ));
          
    }
        
 
  
public function searchStudentsByRoomForTeacherUser($condition,$room,$acad)
	{      
			$criteria = new CDbCriteria;
			
			
			
			  $criteria->condition = $condition.' p.is_student=1  AND h.room='.$room;
			  	
			 $criteria->alias = 'p';
			$criteria->distinct='true';
			$criteria->select = 'p.id, p.last_name , p.first_name, p.gender, p.blood_group, p.id_number';
			$criteria->join = 'left join room_has_person h on (p.id = h.students)';
			$criteria->order = 'last_name ASC';
			//$criteria->limit = '100';
		    
		    		
    return new CActiveDataProvider(get_class($this), array(
        'pagination'=>array(
        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    			),
				
		'criteria'=>$criteria,
    ));
          
			   
	
    }



    
 public function searchStudentsForAddingGrades($condition,$shift,$section,$level,$room,$acad,$eval,$course)
	{      
			$criteria = new CDbCriteria;
			
			
			 $criteria->condition = $condition.' p.is_student=1 AND r.shift=:idShift AND l.section=:idSection AND r.level=:idLevel AND r.id=:roomId AND h.academic_year=:acad AND p.id NOT IN(select student from grades where evaluation=:eval AND course=:course )';
			   $criteria->params = array(':idShift'=>$shift,':idSection'=>$section,':idLevel'=>$level,':roomId'=>$room,':acad'=>$acad,':eval'=>$eval,':course'=>$course);
	       
            $criteria->alias = 'p';
			$criteria->select = ' p.id, p.last_name , p.first_name, p.id_number, p.birthday, p.cities, p.gender, p.blood_group';
                       
			$criteria->join = 'left join room_has_person h on (p.id = h.students) left join rooms r on (h.room=r.id) left join levels l on(l.id=r.level) ';
                        
			
						 $criteria->order = 'last_name ASC';
			
		    
		    		 
    return new CActiveDataProvider($this, array(
        'pagination'=>array(
        			'pageSize'=> 10000,
    			),
				
		'criteria'=>$criteria,
		
		
    ));
 	
    }


 public function searchStudentsForAddingGrades_externRequest($condition,$stud,$acad,$eval,$course)
	{      
			$criteria = new CDbCriteria;
			
			
			 $criteria->condition = $condition.' p.is_student=1 AND h.students=:stud AND h.academic_year=:acad AND p.id NOT IN(select student from grades where evaluation=:eval AND course=:course )';
			   $criteria->params = array(':stud'=>$stud,':acad'=>$acad,':eval'=>$eval,':course'=>$course);
	        

            $criteria->alias = 'p';
			$criteria->select = ' p.id, p.last_name , p.first_name, p.id_number, p.birthday, p.cities, p.gender, p.blood_group';
                      
			$criteria->join = 'left join room_has_person h on (p.id = h.students) left join rooms r on (h.room=r.id) ';
                        
			
						 $criteria->order = 'last_name ASC';
			
		    
		    		 
    return new CActiveDataProvider($this, array(
        'pagination'=>array(
        			'pageSize'=> 10000,
    			),
				
		'criteria'=>$criteria,
		
		
    ));
 	
    }


 
public function searchStudentsForShowingGrades($condition,$shift,$section,$level,$room,$acad,$eval,$course)
	{      
			$criteria = new CDbCriteria;
			
			
			 $criteria->condition = $condition.' p.is_student=1 AND r.shift=:idShift AND l.section=:idSection AND r.level=:idLevel AND r.id=:roomId AND h.academic_year=:acad AND g.evaluation=:eval AND g.course=:course ';
			   $criteria->params = array(':idShift'=>$shift,':idSection'=>$section,':idLevel'=>$level,':roomId'=>$room,':acad'=>$acad,':eval'=>$eval,':course'=>$course);
	       

            $criteria->alias = 'p';
			$criteria->select = ' p.id, p.last_name , p.first_name, p.id_number, p.birthday, p.cities, p.gender, p.blood_group, g.grade_value, g.comment';
                      
			$criteria->join = 'left join room_has_person h on (p.id = h.students) left join rooms r on (h.room=r.id) left join grades g on(g.student=p.id) left join levels l on(l.id=r.level)';
                        
			
						 $criteria->order = 'last_name ASC';
			
		    
		    		 
    return new CActiveDataProvider($this, array(
        'pagination'=>array(
        			'pageSize'=> 10000,
    			),
				
		'criteria'=>$criteria,
		
		
    ));
 	
    }
    
    
    
 public function searchStudentsForShowingGrades_teach($condition,$room,$acad,$eval,$course)
	{      
			$criteria = new CDbCriteria;
			
			
			 $criteria->condition = $condition.' p.is_student=1 AND r.id=:roomId AND h.academic_year=:acad AND g.evaluation=:eval AND g.course=:course ';
			   $criteria->params = array(':roomId'=>$room,':acad'=>$acad,':eval'=>$eval,':course'=>$course);
	        

            $criteria->alias = 'p';
			$criteria->select = ' p.id, p.last_name , p.first_name, p.id_number, p.birthday, p.cities, p.gender, p.blood_group, g.grade_value, g.comment';
                       
			$criteria->join = 'left join room_has_person h on (p.id = h.students) left join rooms r on (h.room=r.id) left join grades g on(g.student=p.id) ';
                        
			
						 $criteria->order = 'last_name ASC';
			
		    
		    		 
    return new CActiveDataProvider($this, array(
        'pagination'=>array(
        			'pageSize'=> 10000,
    			),
				
		'criteria'=>$criteria,
		
		
    ));
 	
    }
    


	
public function searchStudentsForGrades($condition,$shift,$section,$level,$room,$acad)
	{      
			$criteria = new CDbCriteria;
			
			
			 $criteria->condition = $condition.' p.is_student=1 AND r.shift=:idShift AND l.section=:idSection AND r.level=:idLevel AND r.id=:roomId AND h.academic_year=:acad';
			   $criteria->params = array(':idShift'=>$shift,':idSection'=>$section,':idLevel'=>$level,':roomId'=>$room,':acad'=>$acad);
	      

            $criteria->alias = 'p';
			$criteria->select = ' p.id, p.last_name , p.first_name, p.id_number, p.birthday, p.cities, p.gender, p.blood_group';
                      
			$criteria->join = 'left join room_has_person h on (p.id = h.students) left join rooms r on (h.room=r.id) left join levels l on(l.id=r.level)';
                        
			
						 $criteria->order = 'last_name ASC';
			
		    
		    		 
    return new CActiveDataProvider($this, array(
        'pagination'=>array(
        			'pageSize'=> 10000,
    			),
				
		'criteria'=>$criteria,
		
		
    ));
 	
    }



public function searchStudentsByRoomForAddingGrades_teach($condition,$room_id,$evaluation_id,$course_id,$acad)
	{      
			$criteria = new CDbCriteria;
			
			
			 $criteria->condition = $condition.' p.is_student=1 AND r.id='.$room_id.' AND h.academic_year='.$acad.' AND p.id NOT IN(select student from grades where evaluation='.$evaluation_id.' AND course='.$course_id.' )';
			 
            $criteria->alias = 'p';
			$criteria->select = ' p.id, p.last_name , p.first_name, p.id_number, p.birthday, p.cities, p.gender, p.blood_group';
                      
			$criteria->join = 'left join room_has_person h on (p.id = h.students) left join rooms r on (h.room=r.id) ';
                        
			
						 $criteria->order = 'last_name ASC';
			
		    
		    		 
    return new CActiveDataProvider($this, array(
        'pagination'=>array(
        			'pageSize'=> 10000,
    			),
				
		'criteria'=>$criteria,
		
		
    ));
 	
    }
    
    
    
    
public function searchStudentsByRoomForGrades($room_id,$acad)
	{      
			$criteria = new CDbCriteria;
			
			
			 $criteria->condition = 'p.is_student=1 AND p.active IN(1, 2) AND r.id='.$room_id.' AND h.academic_year='.$acad;
			 
            $criteria->alias = 'p';
			$criteria->select = ' p.id, p.last_name , p.first_name, p.id_number, p.birthday, p.cities, p.gender, p.blood_group';
                       
			$criteria->join = 'left join room_has_person h on (p.id = h.students) left join rooms r on (h.room=r.id) ';
                        
			
						 $criteria->order = 'last_name ASC';
			
		    
		    		 
    return new CActiveDataProvider($this, array(
        'pagination'=>array(
        			'pageSize'=> 10000,
    			),
				
		'criteria'=>$criteria,
		
		
    ));
 	
    }
    
//pour les annees anterieures
public function searchStudentsByRoomForGrades_pastYear($room_id,$acad)
	{      
			$criteria = new CDbCriteria;
			
			
			 $criteria->condition = 'p.is_student=1 AND r.id='.$room_id.' AND h.academic_year='.$acad;
			 
            $criteria->alias = 'p';
			$criteria->select = ' p.id, p.last_name , p.first_name, p.id_number, p.birthday, p.cities, p.gender, p.blood_group';
                       
			$criteria->join = 'left join room_has_person h on (p.id = h.students) left join rooms r on (h.room=r.id) ';
                        
			
						 $criteria->order = 'last_name ASC';
			
		    
		    		 
    return new CActiveDataProvider($this, array(
        'pagination'=>array(
        			'pageSize'=> 10000,
    			),
				
		'criteria'=>$criteria,
		
		
    ));
 	
    }

    
     
public function searchStudentsByIDForShowingGrades($condition,$id,$acad,$evaluation_id,$course_id)  	
	{      
			$criteria = new CDbCriteria;
			
			$criteria->alias = 'p';
			
			$criteria->condition = $condition.' p.is_student=1 AND p.id=:id AND h.academic_year=:acad AND g.evaluation=:eval AND g.course=:course';
			$criteria->params = array(':id'=>$id,':acad'=>$acad,':eval'=>$evaluation_id,':course'=>$course_id);
			   
			   
			$criteria->select = ' p.id, p.last_name , p.first_name, p.id_number, p.birthday, p.cities, p.gender, p.blood_group, g.grade_value, g.comment ';
                       
			$criteria->join = 'left join room_has_person h on (p.id = h.students) left join rooms on (h.room=rooms.id)  left join grades g on(g.student=p.id) ';
           
			 
	       
			 $criteria->order = 'last_name ASC';
			
		    
		    		 
    return new CActiveDataProvider($this, array(
        'pagination'=>array(
        			'pageSize'=> 10000,
    			),
				
		'criteria'=>$criteria,
		
		
    ));
 	
    }
    

    
    
public function searchStudentsByIDForAddingGrades($condition,$id,$acad,$evaluation_id,$course_id)
	{      
			$criteria = new CDbCriteria;
			
			$criteria->alias = 'p';
			
			$criteria->condition = $condition.' p.is_student=1 AND p.id=:id AND h.academic_year=:acad AND p.id NOT IN(select student from grades where evaluation=:eval AND course=:course )';
			$criteria->params = array(':id'=>$id,':acad'=>$acad,':eval'=>$evaluation_id,':course'=>$course_id);
			   
			   
			$criteria->select = ' p.id, p.last_name , p.first_name, p.id_number, p.birthday, p.cities, p.gender, p.blood_group ';
                       
			$criteria->join = 'left join room_has_person h on (p.id = h.students) left join rooms on (h.room=rooms.id) ';
           
		
			 $criteria->order = 'last_name ASC';
			
		    
		    		 
    return new CActiveDataProvider($this, array(
        'pagination'=>array(
        			'pageSize'=> 10000,
    			),
				
		'criteria'=>$criteria,
		
		
    ));
 	
    }




public function searchStudentsByIDForGrades($condition,$id)
	{      
			$criteria = new CDbCriteria;
			
			$criteria->alias = 'p';
			
			$criteria->condition = $condition.' p.is_student=1 AND p.id=:id';
			$criteria->params = array(':id'=>$id);
			   
			   
			$criteria->select = ' p.id, p.last_name , p.first_name, p.id_number, p.birthday, p.cities, p.mother_first_name, p.identifiant, p.matricule, p.gender, p.blood_group ';
                      
			$criteria->join = 'left join room_has_person h on (p.id = h.students) left join rooms on (h.room=rooms.id) ';
           
			 
	      
			 $criteria->order = 'last_name ASC';
			
		    
		    		 
    return new CActiveDataProvider($this, array(
        'pagination'=>array(
        			'pageSize'=> 10000,
    			),
				
		'criteria'=>$criteria,
		
		
    ));
 	
    }
	
		
	
public function searchStudentsForCreateReportcard($condition,$eval,$shift,$section,$level,$room,$acad)
	{      
			$criteria = new CDbCriteria;
			
			
			$criteria->distinct='true';
			$criteria->alias = 'p';
			
			 $criteria->condition = $condition.' p.is_student=1 AND g.evaluation=:eval AND rooms.shift=:idShift AND l.section=:idSection AND rooms.level=:idLevel AND rooms.id=:roomId AND h.academic_year=:acad';
			   $criteria->params = array(':eval'=>$eval,':idShift'=>$shift,':idSection'=>$section,':idLevel'=>$level,':roomId'=>$room,':acad'=>$acad);
	        
	        
	        $criteria->select = ' p.id, p.last_name , p.first_name, p.id_number, p.birthday, p.cities, p.gender, p.blood_group';
                      
			$criteria->join = 'inner join room_has_person h on (p.id = h.students) inner join rooms on (h.room=rooms.id) inner join levels l on(l.id=rooms.level)';
            $criteria->join .= 'inner join grades g on (g.student = p.id)';// inner join courses c on (g.course = c.id) ';
                        
			
			
			 $criteria->order = 'last_name ASC';
			
		    
		    		 
    return new CActiveDataProvider($this, array(
        'pagination'=>array(
        			'pageSize'=> 10000,
    			),
				
		'criteria'=>$criteria,
		
		
    ));
 	
    }	
	
	
	
public function getStudentsByRoomForGrades($condition,$room, $acad)
	{      
			$criteria = new CDbCriteria;
			
			$criteria->condition = $condition.' p.is_student=1 AND h.room=:roomId AND h.academic_year=:acad';
			$criteria->params = array(':roomId'=>$room,':acad'=>$acad);
	        
	        $criteria->alias = 'p';
			$criteria->select = 'p.id, p.last_name , p.first_name, p.id_number, p.gender, p.blood_group';
            $criteria->join = 'left join room_has_person h on (p.id = h.students) ';
            $criteria->order = 'last_name ASC';
			
		    
		    		 
    return new CActiveDataProvider($this, array(
        'pagination'=>array(
        			'pageSize'=> 10000,
    			),
				
		'criteria'=>$criteria,
		
    ));
    
    }
    
    

	
public function getStudentsByRoomForReport($condition,$room, $acad)
	{      
			$criteria = new CDbCriteria;
			
			$criteria->condition = $condition.' p.is_student=1 AND h.room=:roomId AND h.academic_year=:acad ';
			$criteria->params = array(':roomId'=>$room,':acad'=>$acad);
	        
	        $criteria->alias = 'p';
			$criteria->select = 'p.id, p.last_name , p.first_name, p.id_number,p.gender, p.blood_group';
            $criteria->join = 'left join room_has_person h on (p.id = h.students)';
			$criteria->order = 'last_name ASC';
			
		    
		    		 
    return new CActiveDataProvider($this, array(
        'pagination'=>array(
        			'pageSize'=> 10000,
    			),
				
		'criteria'=>$criteria,
		
    ));
    
    }


public function getStudentsByLevelForReport($condition,$level, $acad)
	{      
			$criteria = new CDbCriteria;
			
			$criteria->condition = $condition.' p.is_student=1 AND h.level=:levelId AND h.academic_year=:acad ';
			$criteria->params = array(':levelId'=>$level,':acad'=>$acad);
	        
	        $criteria->alias = 'p';
			$criteria->select = 'p.id, p.last_name , p.first_name, p.id_number,p.gender, p.blood_group';
            $criteria->join = 'left join level_has_person h on (p.id = h.students)';
			$criteria->order = 'last_name ASC';
			
		    
		    		 
    return new CActiveDataProvider($this, array(
        'pagination'=>array(
        			'pageSize'=> 10000,
    			),
				
		'criteria'=>$criteria,
		
    ));
    
    }


	
public function getStudentsForBillings($condition,$level,$fee_period_id)
    {
       
       $criteria = new CDbCriteria;
			
	     $criteria->condition = $condition.' p.is_student=1 AND lh.level=:levelId AND p.id NOT IN (select student from billings where fee_period=:feeId )';
	$criteria->params = array(':levelId'=>$level,':feeId'=>$fee_period_id);
	        
	        $criteria->alias = 'p';
		$criteria->select = 'p.id, p.last_name , p.first_name, p.id_number,p.gender, p.blood_group';
        $criteria->join = 'left join level_has_person lh on (p.id = lh.students)';
		$criteria->order = 'last_name ASC';
			
		    
		    		 
		    return new CActiveDataProvider($this, array(
		        'pagination'=>array(
		        			'pageSize'=> 10000,
		    			),
						
				'criteria'=>$criteria,
				
		    ));

       	
    }
  
  
   public function searchPersonsForShowingPayrollSetting($condition,$acad)
	{      
			$criteria = new CDbCriteria;
			
			$criteria->condition = $condition.' AND ps.academic_year='.$acad ;
			   
            $criteria->alias = 'p';
			$criteria->select = ' ps.id, ps.person_id, p.last_name , p.first_name, p.id_number, p.birthday, p.nif_cin, p.cities, p.gender, p.blood_group, ps.amount, ps.number_of_hour, ps.an_hour, ps.academic_year';
                       
			$criteria->join = 'left join payroll_settings ps on(ps.person_id=p.id) ';
                        
			
						 $criteria->order = 'last_name ASC';
			
		    		 
    return new CActiveDataProvider($this, array(
        'pagination'=>array(
        			'pageSize'=> 10000,
    			),
				
		'criteria'=>$criteria,
		
		
    ));
 	
    }
    
    
     
   
   public function searchPersonsForShowingPayroll($condition,$acad)
	{      
			$criteria = new CDbCriteria;
			
			$criteria->condition = $condition.' AND ps.academic_year='.$acad ;
			   
                        $criteria->alias = 'p';
			$criteria->select = ' p.id, p.last_name , p.first_name, p.id_number, p.birthday, p.nif_cin, p.cities, p.gender, p.blood_group, ps.amount, ps.an_hour, ps.academic_year, pl.net_salary, pl.payment_date, pl.taxe';
                       
			$criteria->join = 'left join payroll_settings ps on(ps.person_id=p.id) left join payroll pl on (pl.id_payroll_set = ps.id)';
                        
			
						 $criteria->order = 'last_name ASC';
			
		    
		    		 
    return new CActiveDataProvider($this, array(
        'pagination'=>array(
        			'pageSize'=> 10000,
    			),
				
		'criteria'=>$criteria,
		
		
    ));
 	
    }
    
    
     

	             
 public function searchStudentsForPdfEYD($condition,$shift,$section,$level,$acad)
	{    

   
			$criteria = new CDbCriteria;
			
			
			$criteria->condition = 'p.is_student=1  AND p.active IN(1, 2) AND lhp.level IN (Select l.id from rooms r inner join levels l on(l.id=r.level) where r.shift=:idShift AND l.section=:idSection AND r.level=:idLevel ) AND lhp.academic_year=:acad AND df.academic_year=:acad';
			$criteria->params = array(':idShift' => $shift,':idSection'=>$section,':idLevel'=>$level,':acad'=>$acad);
			

			$criteria->alias = 'p';
			
			$criteria->select = 'p.id, p.last_name , p.first_name, p.mother_first_name, p.identifiant, p.matricule, p.gender, p.birthday, p.cities, c.city_name, p.id_number, df.general_average, df.mention, df.comments, df.is_move_to_next_year, df.current_level, df.next_level';
			$criteria->join = 'left join cities c on(c.id = p.cities) left join decision_finale df on(p.id = df.student) left join level_has_person lhp on (p.id = lhp.students)  '; //left join level_has_person l on (p.id = l.students) left join levels le on(le.id=l.level) ';
			
			$criteria->order = 'last_name ASC';
           
		    
    return new CActiveDataProvider($this, array(
        'pagination'=>array(
        			'pageSize'=> 1000000,
    			),
				
		'criteria'=>$criteria,
    ));
          
			   
	
    }



 public function searchStudentsForPAverage($condition,$shift,$section,$level,$acad)//
	{    

    
			$criteria = new CDbCriteria;
			
			
			$criteria->condition = 'p.is_student=1  AND p.active IN(1, 2) AND h.room IN (Select r.id from rooms r left join levels l on(l.id=r.level) where shift=:idShift AND l.section=:idSection AND level=:idLevel ) AND h.academic_year=:acad AND df.academic_year=:acad';
			$criteria->params = array(':idShift' => $shift,':idSection'=>$section,':idLevel'=>$level,':acad'=>$acad);
			
			
			$criteria->alias = 'p';
			
			$criteria->select = 'p.id, p.last_name , p.first_name, p.mother_first_name, p.identifiant, p.matricule, p.gender, p.birthday, p.cities, c.city_name, p.id_number, df.general_average, df.mention, df.comments, df.is_move_to_next_year, df.current_level, df.next_level';
			$criteria->join = 'left join cities c on(c.id = p.cities) left join decision_finale df on(p.id = df.student) left join room_has_person h on (p.id = h.students) left join rooms r on(r.id=h.room) '; //left join level_has_person l on (p.id = l.students) left join levels le on(le.id=l.level) ';
			
			$criteria->order = 'last_name ASC';
            
		    
    return new CActiveDataProvider($this, array(
        'pagination'=>array(
        			'pageSize'=> 1000000,
    			),
				
		'criteria'=>$criteria,
    ));
          
			   
	
    }




public function searchStudentsForPdfCSL($condition,$level,$acad)
	{    

       
			$criteria = new CDbCriteria;
			
			
			$criteria->condition = $condition.' p.is_student=1  AND lh.level=:idLevel AND lh.academic_year=:acad AND lh.academic_year=:acad';
			$criteria->params = array(':idLevel'=>$level,':acad'=>$acad);
			
			$criteria->alias = 'p';
			$criteria->select = 'p.id, p.last_name , p.first_name, p.mother_first_name, p.identifiant, p.adresse, p.matricule, p.gender, p.birthday, p.cities, c.city_name, p.id_number,soi.person_liable_phone,l.level_name,l.short_level_name';
			$criteria->join = 'left join cities c on(c.id = p.cities) left join level_has_person lh on (p.id = lh.students) left join levels l on (l.id = lh.level) left join student_other_info soi on(p.id = soi.student)';
			
			$criteria->order = 'last_name ASC';
           
		    
    return new CActiveDataProvider($this, array(
        'pagination'=>array(
        			'pageSize'=> 1000000,
    			),
				
		'criteria'=>$criteria,
    ));
          
			   
	
    }

 
  public function getIdPersonByUserID($userid)
	 {   
         
         $criteria = new CDbCriteria;
                      
			$criteria->alias = 'p';
			$criteria->select = 'p.id,p.email,p.first_name, p.last_name';
			$criteria->join = 'left join users u on (u.person_id = p.id)';
			$criteria->condition = 'u.id =:id';
			$criteria->params = array(':id' => $userid);
            
		    
    return new CActiveDataProvider($this, array(
       
		'criteria'=>$criteria,
		 
    ));
    
    
    
	} 
	
 
   public function getFullName(){
       
       return $this->first_name. ' '.$this->last_name;
   }
   
   public function getTeacherName(){
	   
      
	  
   }
   
   
            
      public function getNameInitial(){
          
          $nword = explode(" ",$this->fullName);
                foreach($nword as $letter){
                    $this->make_initials .= $letter{0}.'.';
                }
           return $this->make_initials;     
         
          
      }      
   
   // AJAX Return 
   
 
       
      // Ajax filter  
       public function suggest($keyword,$limit=20)
	{
		$models=$this->findAll(array(
			'condition'=>'is_student = 1  AND p.active IN(1, 2) AND last_name LIKE :keyword',
			'order'=>'last_name',
			'limit'=>$limit,
			'params'=>array(':keyword'=>"%$keyword%")
		));
		$suggest=array();
		foreach($models as $model) {
			$suggest[] = array(
				'label'=>$model->first_name.' '.$model->last_name.' ('.$model->id_number.')',  // label for dropdown list
				
                                'value'=>$model->id,
                               
                                'id'=>$model->id,
                              
			);
		}
		return $suggest;
	}
        
        // Take the gender
        public function getGenders(){
            return array(
                self::MALE=>Yii::t('app','Male'),
                self::FEMALE=>Yii::t('app','Female'),
                               
            );            
        }
        
        public function getSexe(){
            
            $sex = $this->gender;
            $sex_name = null;
            if($sex==0)
                {
                   $sex_name = Yii::t('app','Male'); 
                }
                elseif($sex==1)
                {
                    $sex_name = Yii::t('app','Female');
                }
                
                return $sex_name;
                
        }




        /* public function getOneGender(){
            $gender = $this->getGenders();
            return $gender[$this->gender];
        } */
			
			public function getGenders1()
			{
			
				switch($this->gender)
				{
					case 0:
						return Yii::t('app','Male');
				
					case 1:
						return Yii::t('app','Female');
					
					}
			}
			
		
	
	public function getUsername($id)
	{
		$modelUser=new User;
		
		 
		$user = $modelUser->find(array('select'=>'username',
                                     'condition'=>'person_id=:ID AND is_parent=0',
                                     'params'=>array(':ID'=>$id),
                               ));
		
			if(isset($user))			   
					return $user->username;
				else
				return null;	
				
		  
		
	}


		public function getPaid()
			{
			
				switch($this->paid)
				{
					case 0:
						return Yii::t('app','No');
				
					case 1:
						return Yii::t('app','Yes');
					
					}
			}
			

	
	public function getLevel($id_stud,$acad)
			{
			
				$modelLH=new LevelHasPerson;
		$idLevel = $modelLH->find(array('select'=>'level',
                                     'condition'=>'students=:studID AND academic_year=:acad',
                                     'params'=>array(':studID'=>$id_stud,':acad'=>$acad),
                               ));
		$level = new Levels;
                if($idLevel !=null){
                        $result=$level->find(array('select'=>'id,level_name',
                                     'condition'=>'id=:levelID',
                                     'params'=>array(':levelID'=>$idLevel->level),
                               ));
			
                
						   

						   
				if($result!=null)		   
				   return $result->level_name;
				else
				   return null;
				   
				   
                }
                else
               
                    return null;
                
			}
			

	public function getLevelIdByStudentId($id_stud,$acad)
			{
			
				$modelLH=new LevelHasPerson;
		$idLevel = $modelLH->find(array('select'=>'level',
                                     'condition'=>'students=:studID AND academic_year=:acad',
                                     'params'=>array(':studID'=>$id_stud,':acad'=>$acad),
                               ));
		$level = new Levels;
                if($idLevel !=null){
                        $result=$level->find(array('select'=>'id,level_name',
                                     'condition'=>'id=:levelID',
                                     'params'=>array(':levelID'=>$idLevel->level),
                               ));
			
                
						   

						   
				if($result!=null)		   
				   return $result->id;
				else
				   return null;
				   
				   
                }
                else
               
                    return null;
                
			}
			
	

public function getPreviousLevel($id_stud)
			{
			
				$modelSOI=new StudentOtherInfo;
		$idLevel = $modelSOI->find(array('select'=>'previous_level',
                                     'condition'=>'student=:studID',
                                     'params'=>array(':studID'=>$id_stud ),
                               ));
		$level = new Levels;
                if($idLevel !=null){
                        $result=$level->find(array('select'=>'id,level_name',
                                     'condition'=>'id=:levelID',
                                     'params'=>array(':levelID'=>$idLevel->previous_level),
                               ));
			
                
						   

						   
				if($result!=null)		   
				   return $result->level_name;
				else
				   return null;
                }
                else
               
                    return null;
                
			}
			
	
public function getLevelApplyFor($id_stud)
			{
			
				$modelSOI=new StudentOtherInfo;
		$idLevel = $modelSOI->find(array('select'=>'apply_for_level',
                                     'condition'=>'student=:studID',
                                     'params'=>array(':studID'=>$id_stud ),
                               ));
		$level = new Levels;
                if($idLevel !=null){
                        $result=$level->find(array('select'=>'id,level_name',
                                     'condition'=>'id=:levelID',
                                     'params'=>array(':levelID'=>$idLevel->apply_for_level),
                               ));
			
                
						   

						   
				if($result!=null)		   
				   return $result->level_name;
				else
				   return null;
                }
                else
               
                    return null;
                
			}
			
	


	public function getLevelById($id)
			{				
		        $level = new Levels;
		        
               if($id!='')
                { $result=$level->find(array('select'=>'level_name',
                                     'condition'=>'id=:levelID',
                                     'params'=>array(':levelID'=>$id),
                               ));
				
				if($result!=null)		   
				   return $result->level_name;
				 else
				   return null;
				   
				   
                  }
                else
                   return null;
                
			}
			

	public function getShortLevelById($id)
			{				
		        $level = new Levels;
		        
               if($id!='')
                { $result=$level->find(array('select'=>'short_level_name',
                                     'condition'=>'id=:levelID',
                                     'params'=>array(':levelID'=>$id),
                               ));
				
				if($result!=null)		   
				   return $result->short_level_name;
				 else
				   return null;
				   
				   
                  }
                else
                   return null;
                
			}
			
			
			
	public function getRooms($id_stud,$acad)
			{
			
				$modelRH=new RoomHasPerson;
		$idRoom = $modelRH->find(array('select'=>'room',
                                     'condition'=>'students=:studID AND academic_year=:acad',
                                     'params'=>array(':studID'=>$id_stud,':acad'=>$acad),
                               ));
		$room = new Rooms;
                if($idRoom !=null){
                        $result=$room->find(array('select'=>'id,room_name,short_room_name',
                                     'condition'=>'id=:roomID',
                                     'params'=>array(':roomID'=>$idRoom->room),
                               ));
			
                
						   

						   
				if($result!=null)		   
				   return $result->room_name;
				else
				   return null;
				   
                }
                else
               
                    return null;
                
			}


	public function getShortRooms($id_stud,$acad)
			{
			
				$modelRH=new RoomHasPerson;
		$idRoom = $modelRH->find(array('select'=>'room',
                                     'condition'=>'students=:studID AND academic_year=:acad',
                                     'params'=>array(':studID'=>$id_stud,':acad'=>$acad),
                               ));
		$room = new Rooms;
                if($idRoom !=null){
                        $result=$room->find(array('select'=>'id,room_name,short_room_name',
                                     'condition'=>'id=:roomID',
                                     'params'=>array(':roomID'=>$idRoom->room),
                               ));
			
                
						   

						   
				if($result!=null)		   
				   return $result->short_room_name;
				else
				   return null;
				   
                }
                else
               
                    return null;
                
			}

			
	public function getSections($id_stud,$acad)
			{
			
				$modelRH=new RoomHasPerson;
		$idRoom = $modelRH->find(array('select'=>'room',
                                     'condition'=>'students=:studID AND academic_year=:acad',
                                     'params'=>array(':studID'=>$id_stud,':acad'=>$acad),
                               ));
		$room = new Rooms;
                if($idRoom !=null){
                        $result=$room->find(array('alias'=>'r',
                        		     'select'=>'sec.id, sec.section_name',
                                     'join'=>'left join levels l on(l.id=r.level) left join sections sec on(l.section=sec.id)',
                                     'condition'=>'r.id=:roomID',
                                     'params'=>array(':roomID'=>$idRoom->room),
                               ));
			
                
						   

						   
				if($result!=null)		   
				   return $result->section_name;
				else
				   return null;
				   
                }
                else
               
                    return null;
                
			}
			
			
	public function getShifts($id_stud,$acad)
			{
			
				$modelRH=new RoomHasPerson;
		$idRoom = $modelRH->find(array('select'=>'room',
                                     'condition'=>'students=:studID AND academic_year=:acad',
                                     'params'=>array(':studID'=>$id_stud,':acad'=>$acad),
                               ));
		$room = new Rooms;
                if($idRoom !=null){
                        $result=$room->find(array('alias'=>'r',
                        		     'select'=>'s.id, s.shift_name',
                                     'join'=>'left join shifts s on(r.shift=s.id)',
                                     'condition'=>'r.id=:roomID',
                                     'params'=>array(':roomID'=>$idRoom->room),
                               ));
			
                
						   

						   
				if($result!=null)		   
				   return $result->shift_name;
				else
				   return null;
                }
                else
               
                    return null;
                
			}



			
	public function getIsScholarshipHolder($stud,$acad) //
	  {
			  $model_scholarship = ScholarshipHolder::model()->findAll(array('condition'=>'student ='.$stud.' AND academic_year='.$acad));
														           	  
			  if($model_scholarship != null)
				 return 1;
			  else
				 return 0;
				   
			
                
			}
			
			
	public function getWorkingDepartment($emp,$acad)  //for active employee
			{
			
				$modelDH=new DepartmentHasPerson;
		$idDep = $modelDH->find(array('select'=>'department_id',
                                     'condition'=>'employee=:empID AND academic_year=:acad',
                                     'params'=>array(':empID'=>$emp,':acad'=>$acad),
                               ));
		$dep = new DepartmentInSchool;
                if($idDep !=null){
                        $result=$dep->find(array('select'=>'id,department_name',
                                     'condition'=>'id=:depID',
                                     'params'=>array(':depID'=>$idDep->department_id),
                               ));
			
                
						   

						   
				if($result!=null)		   
				   return $result->department_name;
				else
				   return null;
				   
				   
                }
                else
               
                    return null;
                
			}
			
	
	public function getWorkedDepartment($emp) //for inactive employee
			{
			
				$modelDH=new DepartmentHasPerson;
		$idDep = $modelDH->find(array('select'=>'department_id',
                                     'condition'=>'employee=:empID ',
                                     'params'=>array(':empID'=>$emp),
                               ));
		$dep = new DepartmentInSchool;
		      $dep_name="";
                if($idDep!=null){
                       $i=0;
                       foreach($idDep as $dep)
                         { $result=$dep->find(array('select'=>'id,department_name',
                                     'condition'=>'id=:depID',
                                     'params'=>array(':depID'=>$dep->department_id),
                               ));
			
                            if($i==0)
						      $dep_name=$result->department_name;
						    else
						       $dep_name=$dep_name.', '.$result->department_name;
						       
						       $i++;

                         }
				return $dep_name;
				
                }
                else
               
                    return null;
                
			}
			
			
/**
* Simple PHP age Calculator
*
* Calculate and returns age based on the date provided by the user.
* @param   date of birth('Format:yyyy-mm-dd').
* @return  age based on date of birth
*/
public function ageCalculator($dob)
 {
	if(!empty($dob)&&($dob!='0000-00-00'))
	 {
		$birthdate = new DateTime($dob);
		$today   = new DateTime('today');
		$age = $birthdate->diff($today)->y;
		return $age;
	  }
	else
	  {
	      return null;
	    }

	
 
  }						
	

public function getTitles($emp,$acad)
			{
			
				$modelPH=new PersonsHasTitles;
		$idTit = $modelPH->find(array('select'=>'titles_id',
                                     'condition'=>'persons_id=:empID AND academic_year=:acad',
                                     'params'=>array(':empID'=>$emp,':acad'=>$acad),
                               ));
		$tit = new Titles;
                if($idTit !=null){
                        $result=$tit->find(array('select'=>'id,title_name',
                                     'condition'=>'id=:titID',
                                     'params'=>array(':titID'=>$idTit->titles_id),
                               ));
			
                
						   

				if($result!=null)		   
				   return $result->title_name;
				 else 
				   return null;
				   
                }
                else //chek if teacher
                  {   
                  	  $course=new Courses;
                  	  $idCourse = $course->find(array('alias'=>'c',
                  	  				 'select'=>'*',
                                     'join'=>'inner join academicperiods a on(a.id=c.academic_period) ',
                                     'condition'=>'c.old_new=1 AND c.teacher=:empID AND (c.academic_period=:acad OR a.year=:acad)',
                                     'params'=>array(':empID'=>$emp,':acad'=>$acad),
                               ));
                        if($idCourse!=null)
                            return Yii::t('app','Teacher');
                        else
                           return null;
                  	  
                  	}
                    
                
			}
			
	public function getProfil($pers)
			{
			
				$modelPH=new PersonsHasTitles;
		$idTit = $modelPH->find(array('select'=>'titles_id',
                                     'condition'=>'persons_id=:empID ',
                                     'params'=>array(':empID'=>$pers,),
                               ));
		$tit = new Titles;
                if($idTit !=null){
                        $result=$tit->find(array('select'=>'id,title_name',
                                     'condition'=>'id=:titID',
                                     'params'=>array(':titID'=>$idTit->titles_id),
                               ));
			
                
						   
                      if($result->title_name!=null)
						 return $result->title_name;
				      else
				          return Yii::t('app','N/A');  
				
                }
                else //chek if teacher
                  {   
                  	  $course=new Courses;
                  	  $idCourse = $course->find(array('alias'=>'c',
                  	  				 'select'=>'*',
                                     'join'=>'inner join academicperiods a on(a.id=c.academic_period) ',
                                     'condition'=>'c.old_new=1 AND c.teacher=:empID ',
                                     'params'=>array(':empID'=>$pers,),
                               ));
                        if($idCourse!=null)
                            return Yii::t('app','Teacher');
                        else
                           {  
                           	  $person=Persons::model()->findByPk($pers);
                           	  
                           	  if($person->is_student==0)
                           	     return Yii::t('app','N/A');
                           	  else
                           	     return Yii::t('app','Student');
                  	  
                             }
                    
                
			      }
			}				
          			
	 
//return id_number, gender,is_student,nif_cin,email,phone,adresse
public function getFlashInfoById($student)
	{   	    
                  $sql='SELECT id_number, first_name, last_name, gender,is_student,nif_cin,email,phone,adresse FROM persons WHERE id ='.$student;
		  $result = Yii::app()->db->createCommand($sql)->queryAll();
           
                return $result;
            
 }
	 /**
         * 
         * @return type Status value 
         * 0 -> Disable 
         * 1 -> Enable
         */
        public function getStatus(){
            switch($this->active)
            {
                case 0:
                    return Yii::t('app','Disable');
                case 1:
                    return Yii::t('app','Enable');
                case 2:
                    return Yii::t('app','New');
                case 3:
                    return Yii::t('app','Exclude');
            }
        }
        
        /**
         * 
         * @return type
         * Return human readable value for status from the DB 
         * 0 -> Disable 
         * 1 -> Enable
         */
         public function getStatusValue(){
            return array(
                
                2=>Yii::t('app','New'),
                1=>Yii::t('app','Enable'),
                
                               
            );            
        } 		
	
	 /**
         * 
         * @return blood_group  value 
         * 1 -> O+ 
         * 2 -> O-
         * 3 -> A+
         * 4 -> A-
         * 5 -> B+
         * 6 -> B-
         * 7 -> AB+
         * 8 -> AB-
         */
        public function getBlood_group(){
            switch($this->blood_group)
            {
                case 1:
                    return Yii::t('app','O+');
                    
                case 2:
                    return Yii::t('app','O-');
                case 3:
                    return Yii::t('app','A+');
                case 4:
                    return Yii::t('app','A-');
                case 5:
                    return Yii::t('app','B+');
                case 6:
                    return Yii::t('app','B-');
                case 7:
                    return Yii::t('app','AB+');
                case 8:
                    return Yii::t('app','AB-');
                
            }
        }
        
        /**
         * 
         * @return type
         * Return human readable value for blood_group from the DB 
         * 1 -> O+ 
         * 2 -> O-
         * 3 -> A+
         * 4 -> A-
         * 5 -> B+
         * 6 -> B-
         * 7 -> AB+
         * 8 -> AB-
         */
         public function getBlood_groupValue(){
            return array(
                1=>Yii::t('app','O+'),
                2=>Yii::t('app','O-'),
                3=>Yii::t('app','A+'),
                4=>Yii::t('app','A-'),
                5=>Yii::t('app','B+'),
                6=>Yii::t('app','B-'),
                7=>Yii::t('app','AB+'),
                8=>Yii::t('app','AB-'),
                              
            );            
        } 	
        
        
        public function getAnHour_(){
            switch($this->an_hour)
            {
                case 0:
                    return Yii::t('app','No');
                case 1:
                    return Yii::t('app','Yes');
               
            }
        }	
        
        public function getAnHour_update(){
            switch($this->an_hour)
            {
                case 0:
                    return '';
                case 1:
                    return 'checked';
               
            }
        }
        
  
public function getNumberHour_(){
           if(($this->number_of_hour!=0)&&($this->number_of_hour!=''))
            {
            	return $this->number_of_hour;
             }
            else 
                return Yii::t('app','N/A');
               
           
        }	
        
public function getNumberHour_update(){
            if(($this->number_of_hour!=0)&&($this->number_of_hour!=''))
            {
            	return $this->number_of_hour;
             }
            else 
                return Null;
        }
        
        
public function getBirthday_(){
           if(($this->birthday!=null)&&($this->birthday!='0000-00-00'))
            { $time = strtotime($this->birthday);
                         $month=date("m",$time);
                         $year=date("Y",$time);
                         $day=date("j",$time);
                         
              return $day.'/'.$month.'/'.$year; 
            }
           else
              return '00/00/0000';  
        }
        
       
	
	
	
}
