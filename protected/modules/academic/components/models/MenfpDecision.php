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

?>
<?php

/**
 * This is the model class for table "menfp_decision".
 *
 * The followings are the available columns in table 'menfp_decision':
 * @property integer $id
 * @property integer $student
 * @property double $total_grade
 * @property double $average
 * @property string $mention
 *
 * The followings are the available model relations:
 * @property Persons $student0
 */
class MenfpDecision extends BaseMenfpDecision
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MenfpDecision the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

public $student_fullname;
public $level;
public $last_name;
	
	
	
	public function rules()
	{
		 return array_merge(
                parent::rules(), array(
                   // array(),
           
			array('id, student, last_name, level, total_grade, average, mention,academic_year', 'safe', 'on'=>'search'),
			
                   
									
		));
	}	
/*
  public function attributeLabels()
	{
		
            return array_merge(
                    parent::attributeLabels(), 
                    array(
                    
                    //'' => Yii::t('app',''),
                                        
                        )
                    );
           
	}
	*/
	

	//'student0' => array(self::BELONGS_TO, 'Persons', 'student'),
   //'academicYear0' => array(self::BELONGS_TO, 'Academicperiods', 'academic_year'),

	public function checkDecisionMenfp($stud_id, $acad)
	  {
	        $command= Yii::app()->db->createCommand("SELECT id,total_grade,average,mention FROM menfp_decision WHERE student=:studID AND academic_year=:acad");
			$command->bindValue(':studID', $stud_id);
			$command->bindValue(':acad', $acad);	
			
			$sql_result = $command->queryAll();
			
			
			   return $sql_result;
			
	    
	  }
	
	
	
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($acad)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

          $criteria->with= array('student0','academicYear0');
		
		
		
		$criteria->alias='md';
        $criteria->condition = 'md.academic_year='.$acad;
		$criteria->order = 'last_name ASC';
		
		$criteria->compare('md.id',$this->id);
		$criteria->compare('md.student',$this->student);
		$criteria->compare('concat(first_name," ",last_name)',$this->student_fullname,true);
		$criteria->compare('average',$this->average);
		$criteria->compare('total_grade',$this->total_grade);
		$criteria->compare('mention',$this->mention,true);
		$criteria->compare('md.academic_year',$this->academic_year);
		
		
		
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			
			'pagination'=>array(
        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    			),
		));
	}
	
	
	
public function getLevelByStudID($id_stud,$acad)
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
	
	
	
	
	
	
	
	
}