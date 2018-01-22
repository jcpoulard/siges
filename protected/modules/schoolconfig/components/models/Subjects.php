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



class Subjects extends BaseSubjects
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public $master_subject; 
	
  public function rules()
	{
              
              return array_merge(
		    	parent::rules(), array(
                            // Make date_created, date_updated unsafe 
                            array('date_created,date_updated','unsafe'),
                            // make subject_name unique 
                            array('subject_name,short_subject_name','unique'),
                            array('id, subject_name, short_subject_name, is_subject_parent, master_subject, subject_parent, date_created, date_updated, create_by, update_by', 'safe', 'on'=>'search'),
				                  
									
									));
	}
	






public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->condition="subject_parent <> '' OR is_subject_parent=0 ";
		$criteria->compare('id',$this->id);
		$criteria->compare('subject_name',$this->subject_name,true);
		$criteria->compare('short_subject_name',$this->short_subject_name,true);
		$criteria->compare('is_subject_parent',$this->is_subject_parent);
		$criteria->compare('subject_parent',$this->subject_parent);
		
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('update_by',$this->update_by,true);
		$criteria->order = 'subject_parent DESC, subject_name ASC';
		
		return new CActiveDataProvider($this, array(
	        
			'criteria'=>$criteria,
                        'pagination'=>array(
                        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
                        ),
                        
		));
	}
        
 
 public function searchReport()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('subject_name',$this->subject_name,true);
		$criteria->compare('short_subject_name',$this->short_subject_name,true);
		$criteria->compare('is_subject_parent',$this->is_subject_parent);
		$criteria->compare('subject_parent',$this->subject_parent);
		
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('update_by',$this->update_by,true);
		$criteria->order = 'subject_parent DESC, subject_name ASC';

		return new CActiveDataProvider($this, array(
	        
			'criteria'=>$criteria,
                        'pagination'=>array(
                        'pageSize'=> 100000,
                        ),
                        
		));
	}
        
 
 
 public function getSubjectNameBySubjectID($subject_id){
            
            $criteria = new CDbCriteria;
			
			$criteria->condition = 's.id='.$subject_id;
			$criteria->alias = 's';
			$criteria->select = 'subject_name, short_subject_name, is_subject_parent, subject_parent';
						
    return new CActiveDataProvider($this, array(
        'criteria'=>$criteria,
    ));
	
	    
 }
	    

 
 public function  getIsParent()
        {
            $bool = $this->is_subject_parent; 
            $bool_label = null;
            if($bool==0)
                $bool_label = Yii::t('app','No');
            else
                $bool_label = Yii::t('app','Yes');
            return $bool_label;
            
        }
	
 public function  getSubjectName()
        {
            if($this->subjectParent['subject_name']!='')
             return $this->subject_name.' ('.$this->subjectParent['subject_name'].')';
            else
              return $this->subject_name;
              
            
        }
		
public function  getShortSubjectName()
        {
            if($this->subjectParent['subject_name']!='')
             return $this->short_subject_name.' ('.$this->subjectParent['subject_name'].')';
            else
              return $this->short_subject_name;
              
            
        }
	 

//return an array(id, subject_name, subject_parent)  
public function getSubjectByCourseId($course){
	
	$sql = 'SELECT s.id, subject_name, short_subject_name, subject_parent FROM subjects s INNER JOIN courses c ON(s.id = c.subject) WHERE c.id='.$course;
		$command = Yii::app()->db->createCommand($sql);
        $info__p = $command->queryAll(); 
        
        if($info__p!=null)
          {  
			  return $info__p;
			  
          }
        else
           return null;
	
   }
     



	
}
