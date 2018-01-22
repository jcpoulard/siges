<?php 
/*
 * © 2015 LOGIPAM services / www.logipam.com siges@logipam.com et contributeurs (voir www.logipam.com)
 * 
 * This file is part of SIGES.

    SIGES is free a software: you can redistribute it and/or modify
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



class AcademicPeriods extends BaseAcademicPeriods
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public $academic_year;
         public $past_acad_years;
       
       
  public function attributeLabels()
	{            
		return array_merge(
           parent::attributeLabels(), 
             array('past_acad_years'=>Yii::t('app','Past periods'),
                                        
                        )
                    );
           
	}

      
 // extends function relations 
        
 public function relations()
    {
        return array_merge(
                parent::relations(),
                    array(
                        'year0' => array(self::BELONGS_TO, 'AcademicPeriods', 'year'),
						'academicPeriods' => array(self::HAS_MANY, 'AcademicPeriods', 'year'),
						'previousAcademicYear' => array(self::BELONGS_TO, 'AcademicPeriods', 'previous_academic_year'),
                    )
                );
    }


 public function rules()
	{
              
              return array_merge(
		    	parent::rules(), array(
                            // make date_created, date_updated unsafe
                             array('date_start','datescompare'), 
                            array('date_created,date_updated,year','unsafe'),
                            array('id, academic_year, name_period, weight, checked, date_start, date_end, is_year, date_created, date_updated, create_by, update_by', 'safe', 'on'=>'search'),

                           ));
	}
        
 
        
 		// Compare two dates 
		    public function datescompare($attribute, $params){
		            $message = Yii::t('app','Date start must precede date end !');
		            if($this->date_end<  $this->date_start)
		            {
		                $params = array(
		                    '{attribute}'=>$this->date_end, '{compareValue}'=>$this->date_start
		                );
		                $this->addError('date_end', strtr($message, $params));
		            }
		        }

		   // getMessage
		       public function getMessage($field, $message, $params){
            
		                $this->addError($field, strtr($message, $params));
            
		        }


 
  public function search_($acad)
	{
		$criteria=new CDbCriteria;
                
                
                $criteria->condition='id='.$acad.' OR year='.$acad;  
                
		$criteria->compare('id',$this->id);

		$criteria->compare('name_period',$this->name_period,true);

		$criteria->compare('weight',$this->weight,true);
		
		$criteria->compare('checked',$this->checked,true);
		
		$criteria->compare('date_start',$this->date_start,true);

		$criteria->compare('date_end',$this->date_end,true);

		$criteria->compare('is_year',$this->is_year);

		$criteria->compare('previous_academic_year',$this->previous_academic_year);

		$criteria->compare('year',$this->year);

		$criteria->compare('date_created',$this->date_created,true);

		$criteria->compare('date_updated',$this->date_updated,true);

		$criteria->compare('create_by',$this->create_by,true);

		$criteria->compare('update_by',$this->update_by,true);
                $criteria->order = 'year DESC, date_start DESC';
       
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>array(
                        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
                        ),

		));
	}
	


  public function searchPast($acad,$date_start)
	{
		$criteria=new CDbCriteria;
                
               
        $criteria->condition=' id not in('.$acad.') AND year not in('.$acad.')' ; 
                
		$criteria->compare('id',$this->id);

		$criteria->compare('name_period',$this->name_period,true);

		$criteria->compare('weight',$this->weight,true);
		
		$criteria->compare('checked',$this->checked,true);
		
		$criteria->compare('date_start',$this->date_start,true);

		$criteria->compare('date_end',$this->date_end,true);

		$criteria->compare('is_year',$this->is_year);

		$criteria->compare('previous_academic_year',$this->previous_academic_year);

		$criteria->compare('year',$this->year,true);

		$criteria->compare('date_created',$this->date_created,true);

		$criteria->compare('date_updated',$this->date_updated,true);

		$criteria->compare('create_by',$this->create_by,true);

		$criteria->compare('update_by',$this->update_by,true);
                $criteria->order = 'date_start DESC, year DESC';
       

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>array(
                        'pageSize'=> 1000000000,
                        ),

		));
	}
	

    
public function searchLastAcademicPeriod()
		{      	$acad = new AcademicPeriods;
	        $result=$acad->find(array('select'=>'id,name_period',
	                                     'condition'=>'is_year=1 AND date_start<=:current AND date_end>:current',
	                                     'params'=>array(':current'=> date('Y-m-d') ),
	                               ));
		
					return $result;
	    }
	


public function searchCurrentAcademicPeriod($currentDate)
		{      	$acad = new AcademicPeriods;
	        /* old solution
	           $result=$acad->find(array('select'=>'id,name_period,weight,checked',
	                                     'condition'=>'is_year=1 AND date_start<:current AND date_end>:current',
	                                    'params'=>array(':current'=>$currentDate),
	                               ));
	                               */
		    $result=$acad->find(array('select'=>'id,name_period,weight,checked,date_end',
	                                     'condition'=>'is_year=1 AND id NOT IN(select previous_academic_year from academicperiods where previous_academic_year<>0)',
	                                    
	                               ));
	                               
					return $result;
	    }



public function searchCurrentAcademicPeriod_new($currentDate)
		{      	$acad = new AcademicPeriods;
	        /* old solution
	           $result=$acad->find(array('select'=>'id,name_period,weight,checked',
	                                     'condition'=>'is_year= 1  AND date_start<:current AND date_end>:current',
	                                    'params'=>array(':current'=>$currentDate),
	                               ));
	                         */
	                         
	        $result=$acad->find(array('select'=>'id,name_period,weight,checked,date_end',
	                                     'condition'=>'is_year=1 AND id NOT IN(select previous_academic_year from academicperiods where previous_academic_year<>0)',
	                                     
	                            ));
		
					return $result;
	    }
	

	
public function currentAcademicPeriod($currentDate,$idRoom)
			{      	
				$acad = new AcademicPeriods;
		       /* old solution
	            $result=$acad->find(array( 'alias'=>'a',
				                           'select'=>'a.id, a.name_period,weight,checked',
				                           'join'=>'left join room_has_person rhp on (rhp.academic_year=a.id)',
		               'condition'=>'a.is_year= 1  AND rhp.room=:id_room AND a.date_start<=:current AND a.date_end>:current',
		                                    'params'=>array(':id_room'=>$idRoom, ':current'=>strtotime ($currentDate)),
		                               ));
		                            */
		                            
		        $result=$acad->find(array( 'alias'=>'a',
				                           'select'=>'a.id, a.name_period,weight,checked,date_end',
				                           'join'=>'left join room_has_person rhp on (rhp.academic_year=a.id)',
		               'condition'=>'a.is_year= 1  AND rhp.room=:id_room AND a.id NOT IN(select previous_academic_year from academicperiods where previous_academic_year<>0)',
		                                    'params'=>array(':id_room'=>$idRoom, ':current'=>strtotime ($currentDate)),
		                               ));
		                               
		                               
						return $result;
          
		    }
	
    
    public function getAcademicPeriodNameById($id){
            
			$acad = new AcademicPeriods;
		        $result=$acad->find(array( 'alias'=>'a',
				                           'select'=>'a.name_period, a.previous_academic_year, a.date_start, a.date_end,weight,checked',
				                           'condition'=>'a.id=:id_acad ',
		                                    'params'=>array(':id_acad'=>$id, ),
		                               ));
		
						return $result; 
        }
        
/**
 * 
 * @return type
 */
public function getNamePeriod()
    {
          if($this->year!='')
           {  
			  $acad = new AcademicPeriods;
		        $result=$acad->find(array( 'alias'=>'a',
				                           'select'=>'a.name_period',
				                           'condition'=>'id='.$this->year,
		                                   
		                               ));
		
						return $result->name_period; 
           }
          else 
            return null;
           
        }


	/**
         * 
         * @param type $current_acad
         * @return \CActiveDataProvider
         */
         
	 public function lastDateAcademicPeriod($current_acad){
            
			$criteria = new CDbCriteria;
			
			$criteria->select = 'date_end';
			$criteria->condition = 'is_year=0 AND year='.$current_acad;
			//$criteria->params = array(':current_acad' => $current_acad);
			
			
			
    return new CActiveDataProvider($this, array(
       	'criteria'=>$criteria,
    ));		
        }
		

//return id,date_start,date_end
public function getAllPeriodInAcademicYear($current_acad){
            
			$criteria = new CDbCriteria;
			
			$criteria->select = 'id,date_start,date_end';
			$criteria->condition = 'is_year=0 AND year='.$current_acad;
			//$criteria->params = array(':current_acad' => $current_acad);
			
						
    return new CActiveDataProvider($this, array(
       	'criteria'=>$criteria,
    ));		
        }

		
	 public function lastAcademicYear(){
         //depi pa gen decision_finale ki pran pou ane a sa vle di ane a pa boukle   
		$criteria = new CDbCriteria;
			
			$criteria->alias='ap';
			$criteria->select='ap.id, ap.date_end';
			$criteria->condition='ap.is_year= 1 AND ap.id IN(SELECT DISTINCT academic_year FROM decision_finale)';
			
			
    return new CActiveDataProvider($this, array(
       	'criteria'=>$criteria,
    ));		
				
		
  }
  
  



function premyeAneAkademikNanSistemLan()
   {   //SELECT id, MIN(date_start) as date_start, name_period FROM academicperiods where date_start LIKE( SELECT MIN(date_start) FROM academicperiods )
   	    $infoAcad = array(); 
   	       $command1= Yii::app()->db->createCommand('SELECT id, MIN(date_start) as date_start, date_end, name_period,weight,checked FROM academicperiods where date_start LIKE( SELECT MIN(date_start) FROM academicperiods  where is_year=1)' ); 
	
	     $data = $command1->queryAll();
    
         foreach($data as $d){
    	         $infoAcad['id'] = $d['id'];
    	          $infoAcad['date_start'] = $d['date_start'];
    	         $infoAcad['name_period'] = $d['name_period'];
    	         $infoAcad['weight'] = $d['weight'];
    	         $infoAcad['checked'] = $d['checked'];
    	         $infoAcad['date_end'] = $d['date_end']; 
                    
                    
                    break;
                      
         }
   	    return $infoAcad;
   	    
   	 }

   	 

			 
function denyeAneAkademikNanSistemLan()
   {   //SELECT id, MAX(date_start) as date_start, date_end, name_period FROM academicperiods where date_start LIKE( SELECT MAX(date_start) FROM academicperiods )
   	    $infoAcad = array(); 
   	       $command= Yii::app()->db->createCommand('SELECT id, MAX(date_start) as date_start, date_end, name_period,weight,checked FROM academicperiods where date_start LIKE( SELECT MAX(date_start) FROM academicperiods where is_year=1 )' ); 
	
	     $data = $command->queryAll();
    
         foreach($data as $d){
    	         $infoAcad['id'] = $d['id'];
    	          $infoAcad['date_start'] = $d['date_start'];
    	         $infoAcad['name_period'] = $d['name_period'];
    	         $infoAcad['weight'] = $d['weight'];
    	         $infoAcad['checked'] = $d['checked'];
    	         $infoAcad['date_end'] = $d['date_end']; 
                                        
                    break;
                      
         }
   	    return $infoAcad;
   	    
   	 }
   	 
   	 
  
  
  
  
     // Return the fee type name 
        
        public function getAcademicPeriodName(){
            return $this->name_period; 
        }
	
      
        // Get All the level
        
        public function getAcademicPeriodOptions()
        {
            
            return CHtml::listData(AcademicPeriods::model()->findAll(), 'id','academicPeriodName');
        }
        
       public function getIsYear(){
           if($this->is_year==1)
               return Yii::t('app','Yes');
                   else
                       return Yii::t('app','No'); 
       }
       
       /**
        * 
        * @return type
        */
       
       public function getDateStart(){
            $time = strtotime($this->date_start);
                         $month=date("m",$time);
                         $year=date("Y",$time);
                         $day=date("j",$time);
                         
            return $day.'/'.$month.'/'.$year;    
        }
        
        public function getDateEnd(){
            $time = strtotime($this->date_end);
                         $month=date("m",$time);
                         $year=date("Y",$time);
                         $day=date("j",$time);
                         
            return $day.'/'.$month.'/'.$year;    
        }



//Session structure


public function searchCurrentAcademicSession($acad, $currentDate)
		{      	$modelAcad = new AcademicPeriods;
	            $result=$modelAcad->find(array('select'=>'id,name_period,weight,checked',
	                                     'condition'=>'is_year=0 AND year=:acad AND date_start<=:current AND date_end>:current',
	                                    'params'=>array(':acad'=>$acad, ':current'=>$currentDate),
	                               ));       
	                    
		
					return $result;
	    }	

			


		
	 public function lastAcademicSession($acad){
         //depi pa gen decision_finale ki pran pou sesyon an sa vle di sesyon an pa boukle   
		$criteria = new CDbCriteria;
			
			$criteria->alias='ap';
			$criteria->select='ap.id, ap.name_period,ap.date_end,weight,checked';
			$criteria->condition='ap.is_year= 0 AND year='.$acad.' AND date_start LIKE( SELECT MAX(date_start) FROM academicperiods where is_year=0 AND year='.$acad.' )';
			
			
    return new CActiveDataProvider($this, array(
       	'criteria'=>$criteria,
    ));		
				
		
  }
  
  



function premyeSesyonAkademikNanSistemLan($acad)
   {   //
   	    $infoAcad = array(); 
   	       $command1= Yii::app()->db->createCommand('SELECT id, MIN(date_start) as date_start, date_end, name_period,weight,checked FROM academicperiods where date_start LIKE( SELECT MIN(date_start) FROM academicperiods  where is_year=0 AND year='.$acad.')' ); 
	
	     $data = $command1->queryAll();
    
         foreach($data as $d){
    	         $infoAcad['id'] = $d['id'];
    	          $infoAcad['date_start'] = $d['date_start'];
    	         $infoAcad['name_period'] = $d['name_period'];
    	         $infoAcad['weight'] = $d['weight'];
    	         $infoAcad['checked'] = $d['checked'];
    	         $infoAcad['date_end'] = $d['date_end']; 
                    
                    
                    break;
                      
         }
   	    return $infoAcad;
   	    
   	 }

   	 

			 
function denyeSesyonAkademikNanSistemLan($acad)
   {   //
   	    $infoAcad = array(); 
   	       $command= Yii::app()->db->createCommand('SELECT id, MAX(date_start) as date_start, date_end, name_period,weight,checked FROM academicperiods where date_start LIKE( SELECT MAX(date_start) FROM academicperiods where is_year=0 AND year='.$acad.' )' ); 
	
	     $data = $command->queryAll();
    
         foreach($data as $d){
    	         $infoAcad['id'] = $d['id'];
    	          $infoAcad['date_start'] = $d['date_start'];
    	         $infoAcad['name_period'] = $d['name_period'];
    	         $infoAcad['weight'] = $d['weight'];
    	         $infoAcad['checked'] = $d['checked'];
    	         $infoAcad['date_end'] = $d['date_end']; 
                                        
                    break;
                      
         }
   	    return $infoAcad;
   	    
   	 }
   	 
 //return 0 or previous_academic_year  	 
function getPreviousAcademicYear($acad)
   {   //
   	    
   	       $command= Yii::app()->db->createCommand('SELECT previous_academic_year FROM academicperiods where id='.$acad ); 
	
	     $data = $command->queryAll();
    
       if($data!=NULL)
         {  
           foreach($data as $d)
            {
    	         if($d['previous_academic_year']!=0)
    	            return $d['previous_academic_year'];
    	         else
    	            return 0; 
                                        
                    break;
                      
            }
            
         }
       else
         return 0;
   	   
   	    
   	 }

 //return 0 or next_academic_year  	 
function getNextAcademicYear($acad)
   {   //
   	    
   	       $command= Yii::app()->db->createCommand('SELECT id FROM academicperiods where previous_academic_year='.$acad ); 
	
	     $data = $command->queryAll();
    
       if($data!=NULL)
         {  
           foreach($data as $d)
            {
    	         if($d['id']!=0)
    	            return $d['id'];
    	         else
    	            return 0; 
                                        
                    break;
                      
            }
            
         }
       else
         return 0;
   	   
   	    
   	 }







	
}