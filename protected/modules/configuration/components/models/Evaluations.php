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



class Evaluations extends BaseEvaluations
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
  public function rules()
	{
              
              return array_merge(
		    	parent::rules(), array(
                            //Make date_created, date_updated unsafe 
                            array('date_created, date_updated','unsafe'),
                            // Make evaluation_name unique 
                            //array('evaluation_name','unique'),
                             array('evaluation_name+academic_year', 'application.extensions.uniqueMultiColumnValidator'),
                            
				                 
									
									));
	}
	

			
			

  public function getEvaluationName(){
        return $this->evaluation_name; 
    }    
    

    public function search()
	{
		$criteria=new CDbCriteria;
		
		$criteria->with=array('academicYear');

		$criteria->compare('id',$this->id);

		$criteria->compare('evaluation_name',$this->evaluation_name,true);
		
		$criteria->compare('weight',$this->weight,true);

		$criteria->compare('academic_year',$this->academic_year,true);

		$criteria->compare('date_created',$this->date_created,true);

		$criteria->compare('date_updated',$this->date_updated,true);

		$criteria->compare('create_by',$this->create_by,true);

		$criteria->compare('update_by',$this->update_by,true);
                $criteria->order = 'evaluation_name ASC';

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
                        'pagination'=>array(
                        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
                        ),
                        
		));
	}


    public function search_($acad)
	{
		$criteria=new CDbCriteria;
		
		$criteria->condition='academic_year='.$acad;
		
		$criteria->with=array('academicYear');

		$criteria->compare('id',$this->id);

		$criteria->compare('evaluation_name',$this->evaluation_name,true);
		
		$criteria->compare('weight',$this->weight,true);

		$criteria->compare('academic_year',$this->academic_year,true);

		$criteria->compare('date_created',$this->date_created,true);

		$criteria->compare('date_updated',$this->date_updated,true);

		$criteria->compare('create_by',$this->create_by,true);

		$criteria->compare('update_by',$this->update_by,true);
                $criteria->order = 'evaluation_name ASC';

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
                        'pagination'=>array(
                        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
                        ),
                        
		));
	}


  public function searchPast($acad,$date_start)
	{
		$criteria=new CDbCriteria;
                
               
        $criteria->with=array('academicYear');

		$criteria->alias='e';
		
		$criteria->condition=' ( e.academic_year<>'.$acad.' AND academicYear.is_year=1  AND academicYear.date_end < \''.$date_start.'\') OR academicYear.year<>'.$acad.' AND academicYear.date_end < \''.$date_start.'\'' ; 
                
		$criteria->compare('id',$this->id);

		$criteria->compare('evaluation_name',$this->evaluation_name,true);
		
		$criteria->compare('weight',$this->weight,true);

		$criteria->compare('academic_year',$this->academic_year,true);

		$criteria->compare('date_created',$this->date_created,true);

		$criteria->compare('date_updated',$this->date_updated,true);

		$criteria->compare('create_by',$this->create_by,true);

		$criteria->compare('update_by',$this->update_by,true);
                $criteria->order = 'academicYear.date_end DESC';
       

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>array(
                        'pageSize'=> 1000000000,
                        ),

		));
	}
	
			
		
public function getEvaluationWeight($eval_id)
	{      
				  $sql='select weight from evaluations where id='.$eval_id;
		  $result = Yii::app()->db->createCommand($sql)->queryAll();
            return $result;
  
	
    }	
	

public function searchAllEvaluations($acad)
	{      
				  $sql='select id, weight from evaluations where academic_year='.$acad;
		  $result = Yii::app()->db->createCommand($sql)->queryAll();
            return $result;
  
	
    }	
	
	
}
