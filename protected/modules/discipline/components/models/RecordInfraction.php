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



class RecordInfraction extends BaseRecordInfraction
{
    
    public $student_last_name; 
    
    public $deduct_note;
    
    public $compter_infraction; // Pour le dashboard 
    public $nom_frequent; 
            
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	//public $arroondissement_name;
  public function rules()
	{
              
              return array_merge(
		    	parent::rules(), array(
                            array('student_last_name', 'length', 'max'=>125),
                            array('general_comment', 'length', 'max'=>255),
                            array('id, student, student_last_name, infraction_type, record_by, incident_date, incident_description, decision_description, value_deduction, general_comment', 'safe', 'on'=>'search'),
                            
									));
	}
    
 
  public function attributeLabels()
	{      
              return array_merge(
		    	parent::attributeLabels(), array(
                            'deduct_note' =>Yii::t('app','Deduct note'),
                  ));
	}
    
    
  
        /**
         * 
         * @return \CActiveDataProvider
         */
        public function search($acad)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                $criteria->with = array('student0');
                $criteria->condition=('academic_period ='.$acad.'');
                
		$criteria->compare('id',$this->id,true);
		$criteria->compare('student',$this->student);
                $criteria->compare('student0.last_name',$this->student_last_name,true);
		$criteria->compare('infraction_type',$this->infraction_type);
		$criteria->compare('record_by',$this->record_by,true);
		$criteria->compare('incident_date',$this->incident_date,true);
		$criteria->compare('incident_description',$this->incident_description,true);
		$criteria->compare('decision_description',$this->decision_description,true);
		$criteria->compare('value_deduction',$this->value_deduction);
		$criteria->compare('general_comment',$this->general_comment);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('update_by',$this->update_by,true);

                $criteria->order = 'incident_date DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>array(
                            'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
                        ),
		));
	}
 
        public function search_($month,$acad)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                $criteria->with = array('student0');
                $criteria->condition='MONTH(incident_date)='.$month.' AND academic_period ='.$acad;
                
		$criteria->compare('id',$this->id,true);
		$criteria->compare('student',$this->student);
                $criteria->compare('student0.last_name',$this->student_last_name,true);
		$criteria->compare('infraction_type',$this->infraction_type);
		$criteria->compare('record_by',$this->record_by,true);
		$criteria->compare('incident_date',$this->incident_date,true);
		$criteria->compare('incident_description',$this->incident_description,true);
		$criteria->compare('decision_description',$this->decision_description,true);
		$criteria->compare('value_deduction',$this->value_deduction);
		$criteria->compare('general_comment',$this->general_comment);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('update_by',$this->update_by,true);

                $criteria->order = 'incident_date DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>array(
                            'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
                        ),
		));
	}
        
       
        /**
         * 
         * @return \CActiveDataProvider
         */
        public function searchStudent($acad, $stud)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                $criteria->with = array('student0');
                $criteria->condition=('academic_period ='.$acad.' and student = '.$stud.'');
                
		$criteria->compare('id',$this->id,true);
		$criteria->compare('student',$this->student);
                $criteria->compare('student0.last_name',$this->student_last_name,true);
		$criteria->compare('infraction_type',$this->infraction_type);
		$criteria->compare('record_by',$this->record_by,true);
		$criteria->compare('incident_date',$this->incident_date,true);
		$criteria->compare('incident_description',$this->incident_description,true);
		$criteria->compare('decision_description',$this->decision_description,true);
		$criteria->compare('value_deduction',$this->value_deduction);
		$criteria->compare('general_comment',$this->general_comment);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('update_by',$this->update_by,true);

               // $criteria->limit = '1,1';
                $criteria->order = 'incident_date DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>array(
                            'pageSize'=> 10000,
                        ),
		));
	}
        
        
        /**
         * 
         * @param int $student
         * @param int $exam_period
         * @param int $room
         * @return float
         */
      public function getDisciplineGradeByExamPeriod($student, $exam_period)
          {
            $note_discipline_finale = 0.00;
            $method = $this->getDiscGradeMethod();
            $note_discipline_initiale = $this->getDiscInitialGrade();
            
            if($method == 0){
            $note_discipline_finale = $note_discipline_initiale - $this->sommeDeduction($student,$exam_period);
            }
            elseif($method == 1){
            $note_discipline_finale =$note_discipline_initiale - ($note_discipline_initiale*$this->sommeDeduction($student, $exam_period))/100.00;
            }
			
			if($note_discipline_finale <= 0)
			{
				return 0.00;
			}
			else {
                return $note_discipline_finale;
			}
        }
        
        /**
         * 
         * @param int $student
         * @param int $exam_period
         * @return real
         */
        public function sommeDeduction($student,$exam_period){
            $total = 0.00;
            $criteria = new CDbCriteria;
            $criteria->condition='student=:student AND exam_period=:exam_period';
            $criteria->params=array(':student'=>$student,':exam_period'=>$exam_period);
            $infractions = RecordInfraction::model()->findAll($criteria);
            foreach($infractions as $in){
                $total = $total + $in->value_deduction;
                
            }
            return $total;
        }
        
        /**
         * 
         * @param int $student
         * @param int $exam_period
         * @return int
         */
        public function numberOfInfraction($student,$exam_period){
            $total = 0;
            $criteria = new CDbCriteria;
            $criteria->condition='student=:student AND exam_period=:exam_period';
            $criteria->params=array(':student'=>$student,':exam_period'=>$exam_period);
            $infractions = RecordInfraction::model()->findAll($criteria);
            foreach($infractions as $in){
                $total++;
            }
            return $total;
        }

        
        
        /**
         * Return the metho of calcul for the discipline grade 
         * @return int 
         * 
         */
        public function getDiscGradeMethod(){
            $method = 0;
            $criteria = new CDbCriteria;
            $criteria->condition='item_name=:item_name';
            $criteria->params=array(':item_name'=>'methode_deduction_note_discipline',);
            $method = GeneralConfig::model()->find($criteria)->item_value;
            return $method;
        }
        /**
         * 
         * @return real; 
         */
        public function getDiscInitialGrade(){
            $grade = 0.00;
            $criteria = new CDbCriteria;
            $criteria->condition='item_name=:item_name';
            $criteria->params=array(':item_name'=>'note_discipline_initiale',);
            $grade = GeneralConfig::model()->find($criteria)->item_value;
            return $grade;
        }
        
        /**
         * 
         * @param type $currentDate
         * @return type
         */             
        public function searchCurrentExamPeriod($currentDate)
		{      	$acad = new AcademicPeriods;
                        $result=$acad->find(array('select'=>'id,name_period',
	                                     'condition'=>'is_year=0 AND date_start<=:current AND date_end>=:current',
                                             'params'=>array(':current'=>$currentDate),
	                               ));
		
                      if($result!=null)
                        return $result;
                      else //pran peryod ki vin touswit anvan
                        {
                        	$results=$acad->find(array('select'=>'id,name_period',
	                                     'condition'=>'is_year=0 AND date_end<:current',
	                                     'order'=>'date_end DESC',
                                             'params'=>array(':current'=>$currentDate),
	                               ));
	                        
	                        $result= new AcademicPeriods;
	                        
	                          if($results!=null)
	                            {  
	                               foreach($results as $r)
	                                { 
	                                	 $result = $r;
	                                	   break;
	                                 }
	                                		
	                             }
	                             
	                          return $results;
	                               
                        	}
                }
                
      public function getDateFormate($date){
           $time = strtotime($date);
                         $month=date("m",$time);
                         $year=date("Y",$time);
                         $day=date("j",$time);
                         
            return $day.'/'. $month.'/'.$year;             
        } 
        
        public function getIncidentDate(){
            $time = strtotime($this->incident_date);
                         $month=date("m",$time);
                         $year=date("Y",$time);
                         $day=date("j",$time);
                         
            return $day.'/'.$month.'/'.$year;    
        }
        
        
}
