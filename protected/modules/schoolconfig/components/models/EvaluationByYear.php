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



class EvaluationByYear extends BaseEvaluationByYear
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public $evaluation_name;
	public $name_period;
	public $academic_year;
	public $id_eval_year;
	public $evaluation_date;
	
	
  public function rules()
	{
              
              return array_merge(
		    	parent::rules(), array(
                            //make date_created, date_updated unsafe 
                            array('date_created, date_updated','unsafe'),
								array('id, evaluation_name, academic_year,name_period, evaluation_date, last_evaluation, date_created, date_updated, create_by, update_by', 'safe', 'on'=>'search'),
				                  
									
									));
	}
	
	
			    	
		    
		       		        
		        
   public function search($acad)
	{
		$siges_structure = infoGeneralConfig('siges_structure_session');
	     
        $criteria=new CDbCriteria;
		$criteria->with=array('evaluation0','academicYear');

		if($siges_structure==1)
		    $criteria->condition='academicYear.id='.$acad;
		elseif($siges_structure==0)
		   $criteria->condition='academicYear.year='.$acad;
		
		
		$criteria->compare('id',$this->id);

		$criteria->compare('evaluation0.evaluation_name',$this->evaluation_name,true);

		
		$criteria->compare('academicYear.name_period',$this->academic_year, true);

		$criteria->compare('evaluation_date',$this->evaluation_date,true);
		
		$criteria->compare('last_evaluation',$this->last_evaluation,true);

		$criteria->compare('date_created',$this->date_created,true);

		$criteria->compare('date_updated',$this->date_updated,true);

		$criteria->compare('create_by',$this->create_by,true);

		$criteria->compare('update_by',$this->update_by,true);
		
		$criteria->order ='evaluation_date ASC';
		
		

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
                        'pagination'=>array(
                        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
                        ),

		));
	}

public function searchIdNameToCreate($acad)
	{      
			$criteria = new CDbCriteria;
	
	     $siges_structure = infoGeneralConfig('siges_structure_session');
	
			if($siges_structure==1)
			    $criteria->condition = 'ap.id=:acad ';
			elseif($siges_structure==0)
			   $criteria->condition = 'ap.year=:acad ';
		

             
            
            $criteria->params = array(':acad' => $acad);
			
			$criteria->alias = 'ey';
			$criteria->select = 'ey.id,ap.name_period, e.evaluation_name, ey.evaluation_date,ey.last_evaluation,ap.weight,ap.checked';
			$criteria->join = 'left join evaluations e on (e.id = ey.evaluation) left join academicperiods ap on (ap.id=ey.academic_year)';// left join grades g on(g.evaluation=ey.academic_year)';
			$criteria->order ='ey.evaluation_date';
			
	        
		    		
    return new CActiveDataProvider($this, array(
        'criteria'=>$criteria,
    ));
          
			   
	
    }




public function searchIdName($acad)
	{      
			$criteria = new CDbCriteria;
			
			
			$criteria->alias = 'ey';
			$criteria->distinct='true';
			$criteria->select = 'ey.id,ap.name_period, ey.evaluation_date,e.evaluation_name, ey.academic_year, ey.last_evaluation,ap.weight,ap.checked';//e.evaluation_name, 
			$criteria->join = ' left join evaluations e on (e.id = ey.evaluation) inner join grades g on(g.evaluation=ey.id) left join academicperiods ap on (ap.id=ey.academic_year)';
			
			$criteria->order ='ey.evaluation_date';
			
			 $siges_structure = infoGeneralConfig('siges_structure_session');
	
			if($siges_structure==1)
			    $criteria->condition = 'ap.id=:acad ';
			elseif($siges_structure==0)
			   $criteria->condition = 'ap.year=:acad ';
		


			
                        $criteria->params = array(':acad' => $acad);
			
			
		    		
    return new CActiveDataProvider($this, array(
        'criteria'=>$criteria,
    ));
          
			   
	
    }
 
    
    
public function searchLastEvaluationInGrade($acad)
	{      	
			$criteria = new CDbCriteria;
			
                        $criteria->distinct = 'true';
			$criteria->alias = 'ey';
			$criteria->select = 'ey.id,ap.name_period, ey.evaluation_date, ey.academic_year,ey.last_evaluation,ap.weight,ap.checked';//e.evaluation_name, 
			$criteria->join = ' inner join evaluations e on (e.id = ey.evaluation) inner join grades g on(g.evaluation=ey.id) inner join academicperiods ap on (ap.id=ey.academic_year)';
			
			$criteria->order ='ey.evaluation_date DESC';
			
			 $siges_structure = infoGeneralConfig('siges_structure_session');
	
			if($siges_structure==1)
			    $criteria->condition = 'ap.id=:acad ';
			elseif($siges_structure==0)
			   $criteria->condition = 'ap.year=:acad ';
		

                        $criteria->params = array(':acad' => $acad);
			
			
		    		
    return new CActiveDataProvider($this, array(
        'criteria'=>$criteria,
    ));
          
			   
	
    }
        
   
   public function searchIdNameReportcardDone($acad)
	{      
            $condition = 'ap.year='.$acad;
            
            $siges_structure = infoGeneralConfig('siges_structure_session');
	
			if($siges_structure==1)
			   $sql='select distinct  ey.id as id_eval_year,ap.name_period as name_period, e.evaluation_name, ey.evaluation_date as evaluation_date,ey.last_evaluation,ap.weight,ap.checked from average_by_period abp left join evaluation_by_year ey on(ey.id=abp.evaluation_by_year) left join evaluations e on (e.id = ey.evaluation) left join grades g on(g.evaluation=ey.id) left join academicperiods ap on (ap.id=ey.academic_year)  where ap.id='.$acad;
			elseif($siges_structure==0)
			   $sql='select distinct  ey.id as id_eval_year,ap.name_period as name_period, e.evaluation_name, ey.evaluation_date as evaluation_date,ey.last_evaluation,ap.weight,ap.checked from average_by_period abp left join evaluation_by_year ey on(ey.id=abp.evaluation_by_year) left join evaluations e on (e.id = ey.evaluation) left join grades g on(g.evaluation=ey.id) left join academicperiods ap on (ap.id=ey.academic_year)  where ap.year='.$acad;
		 
		 
		  $result = Yii::app()->db->createCommand($sql)->queryAll();
                    return $result;
  
        }

public function getLastEvaluationDate($acad)  
	{      
			    
		  $condition = 'ap.year='.$acad;
            
            $siges_structure = infoGeneralConfig('siges_structure_session');
	
			if($siges_structure==1)
			    $condition = 'ap.id='.$acad;
			elseif($siges_structure==0)
			   $condition = 'ap.year='.$acad;
			   
			   $sql='select MAX(ey.evaluation_date) as evaluation_date from evaluation_by_year ey inner join academicperiods ap on (ap.id=ey.academic_year) where '.$condition;
		  $result = Yii::app()->db->createCommand($sql)->queryAll();
                    return $result;
  
        }	 
        
        
        
public function getLastEvaluationSet($acad)  
	{      
			    
		  $condition = 'ap.year='.$acad;
            
            $siges_structure = infoGeneralConfig('siges_structure_session');
	
			if($siges_structure==1)
			    $condition = 'ap.id='.$acad;
			elseif($siges_structure==0)
			   $condition = 'ap.year='.$acad;
			   
			   $sql='select ey.id, ey.evaluation_date from evaluation_by_year ey inner join academicperiods ap on (ap.id=ey.academic_year) where '.$condition.' AND ey.last_evaluation=1'; 
		  $result = Yii::app()->db->createCommand($sql)->queryAll();
                    return $result;
  
        }	 



public function getLastEvaluationForAPeriod($id_period, $acad)
	{      
		  $condition = 'ap.year='.$acad;
            
            $siges_structure = infoGeneralConfig('siges_structure_session');
	
			if($siges_structure==1)
			    $condition = 'ap.id='.$acad;
			elseif($siges_structure==0)
			   $condition = 'ap.year='.$acad;
			   
			   
			   $sql='select ey.id,ey.evaluation_date, ap.name_period, ey.last_evaluation,ap.weight,ap.checked from evaluation_by_year ey inner join academicperiods ap on (ap.id=ey.academic_year) where ap.id='.$id_period.' AND '.$condition.' order by ey.evaluation_date DESC';
		  $result = Yii::app()->db->createCommand($sql)->queryAll();
                    return $result;
  
        }	

public function getEvaluationName($eval_id)
	{      
				  $sql='select evaluation_name from evaluations where id='.$eval_id;
		  $result = Yii::app()->db->createCommand($sql)->queryAll();
            
            foreach($result as $r)
              return $r['evaluation_name'];
  
	
    }

public function getPastEvaluationInAPeriod($id_period, $acad)
	{      
	       $condition = 'ap.year='.$acad;
            
            $siges_structure = infoGeneralConfig('siges_structure_session');
	
			if($siges_structure==1)
			    $condition = 'ap.id='.$acad;
			elseif($siges_structure==0)
			   $condition = 'ap.year='.$acad;
			   
			   
                  $sql='select ey.id,ey.evaluation,ey.evaluation_date, ap.name_period,ey.last_evaluation,ap.weight,ap.checked from evaluation_by_year ey inner join academicperiods ap on (ap.id=ey.academic_year) where ap.id='.$id_period.' AND '.$condition.' order by ey.evaluation_date ASC';
		  $result = Yii::app()->db->createCommand($sql)->queryAll();
                    return $result;
  
	
    }	


//return an integer
public function getNumberEvaluationInAPeriod($acad_period, $acad)
	{      
		  $condition = 'ap.year='.$acad;
            
            $siges_structure = infoGeneralConfig('siges_structure_session');
	
			if($siges_structure==1)
			    $condition = 'ap.id='.$acad;
			elseif($siges_structure==0)
			   $condition = 'ap.year='.$acad;
			   
			 $sql='SELECT count(ey.academic_year) as number FROM evaluation_by_year ey inner join academicperiods ap on (ap.id=ey.academic_year) WHERE ey.academic_year='.$acad_period.' AND '.$condition.' group by ey.academic_year';
		  $result = Yii::app()->db->createCommand($sql)->queryAll();
           
                  foreach($result as $r)
                        return $r["number"];
  
    }	



public function getLastEvaluationForEachPeriod($acad)
	{      
	         $condition = 'ap.year='.$acad;
            
            $siges_structure = infoGeneralConfig('siges_structure_session');
	
			if($siges_structure==1)
			    $condition = 'ap.id='.$acad;
			elseif($siges_structure==0)
			   $condition = 'ap.year='.$acad;
			   
                  $sql='select MAX(evaluation_date) as evaluation_date, academic_year, ap.name_period,ey.last_evaluation  from evaluation_by_year ey inner join academicperiods ap on(ap.id=ey.academic_year) where '.$condition.' group by academic_year order by evaluation_date ASC';
		  $result = Yii::app()->db->createCommand($sql)->queryAll();
                        return $result;
  
    }	

 	
public function getEvaluationDataInPeriodID($period_id)
	{      			
                  $sql='SELECT ey.evaluation, e.evaluation_name, ey.id as id_by_year,  ey.evaluation_date, ey.last_evaluation FROM evaluation_by_year ey INNER JOIN academicperiods ap ON (ey.academic_year=ap.id) INNER join evaluations e on(ey.evaluation=e.id) WHERE ey.academic_year='.$period_id.' order by ey.evaluation_date  ASC';
		  $result = Yii::app()->db->createCommand($sql)->queryAll();
            return $result;          
	
    }

                
public function getPeriodNameByPeriodID($period_id)
	{      			
                  $sql='SELECT name_period, ap.id as id, evaluation, evaluation_date,  ey.id as id_by_year, ey.academic_year as academic_year, ey.last_evaluation,ap.weight,ap.checked FROM evaluation_by_year ey INNER JOIN academicperiods ap ON (ey.academic_year=ap.id) WHERE ey.academic_year='.$period_id;
		  $result = Yii::app()->db->createCommand($sql)->queryAll();
            return $result;          
	
    }


public function getPeriodNameByEvaluationID($eval_id)
	{      			
                  $sql='SELECT name_period, ap.id as id, evaluation, evaluation_date, ey.id as id_by_year, ey.academic_year as academic_year, ey.last_evaluation,ap.weight,ap.checked FROM evaluation_by_year ey INNER JOIN academicperiods ap ON (ey.academic_year=ap.id) WHERE ey.id='.$eval_id;
		  $result = Yii::app()->db->createCommand($sql)->queryAll();
            return $result;          
	
    }


public function getPeriodNameByEvaluationDATE($date_)
	{      			
                  $sql='SELECT name_period, ap.id as id, evaluation, evaluation_date, ey.id as id_by_year,  ey.academic_year as academic_year, ey.last_evaluation,ap.weight,ap.checked FROM evaluation_by_year ey INNER JOIN academicperiods ap ON (ey.academic_year=ap.id) WHERE ey.evaluation_date=\''.$date_.'\'';
		  $result = Yii::app()->db->createCommand($sql)->queryAll();
            return $result;          
	
    }
	

	
			
	public function searchPeriodName($eval_id)
	{      
			$criteria = new CDbCriteria;
			
			$criteria->condition = 'ey.id=:idEvalByY';
			$criteria->params = array(':idEvalByY' => $eval_id,);
	        
			$criteria->alias = 'ey';
			$criteria->select = 'name_period, ap.id, evaluation_date, ey.academic_year, ey.last_evaluation,ap.weight,ap.checked';
			$criteria->join = 'left join academicperiods ap on (ey.academic_year=ap.id)';
         
			
			
                        return new CActiveDataProvider($this, array(
                            'criteria'=>$criteria,
                        ));
          
			   
	
    }


		public function getLastEvaluation()
			{
			
				switch($this->last_evaluation)
				{
					case 0:
						return Yii::t('app','No');
				
					case 1:
						return Yii::t('app','Yes');
					
					}
			}


public function isAlreadyDefined($acad)
	  {
	  	   $acad_year=Yii::app()->session['currentId_academic_year']; 
	  	   $siges_structure = infoGeneralConfig('siges_structure_session');
	  	   
	  	   if($siges_structure==1)
		    $sql='SELECT ey.id FROM evaluation_by_year ey inner join academicperiods a ON(a.id=ey.academic_year) WHERE last_evaluation=1 and academic_year='.$acad.' AND a.year='.$acad_year ;
		elseif($siges_structure==0)
		    $sql='SELECT ey.id FROM evaluation_by_year ey inner join academicperiods a ON(a.id=ey.academic_year) WHERE last_evaluation=1 and a.year='.$acad ;

	
				  $is_there = Yii::app()->db->createCommand($sql)->queryAll();
				  
            if($is_there!=null)
               return $is_there;
            else
               return null;
           
                        
           
           
	  	}
				
	// Return exam name 
	
	public function getExamName(){
		return $this->academicYear['name_period'];
	}
	
	 public function getEvaluationDate(){
            $time = strtotime($this->evaluation_date);
                         $month=date("m",$time);
                         $year=date("Y",$time);
                         $day=date("j",$time);
                         
            return $day.'/'.$month.'/'.$year;    
        }

	 
}
