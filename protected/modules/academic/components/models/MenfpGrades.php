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
 * This is the model class for table "menfp_grades".
 *
 * The followings are the available columns in table 'menfp_grades':
 * @property integer $id
 * @property integer $student
 * @property integer $menfp_exam
 * @property double $grade
 *
 * The followings are the available model relations:
 * @property ExamenMenfp $menfpExam
 * @property Persons $student0
 */
class MenfpGrades extends BaseMenfpGrades
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MenfpGrades the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}



	public $student_fullname;
	public $academic_period;
	
	public $subject_name;
	public $last_name;
	public $level;
	public $id_exam;
	public $id_grade;
	public $weight;
	
	
	
	
	public function rules()
	{
		 return array_merge(
                parent::rules(), array(
                   // array(),
                              
			array('id, student,last_name,subject_name,level, menfp_exam, grade', 'safe', 'on'=>'search'),
			
                   
									
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
	
	
	//'menfpExam' => array(self::BELONGS_TO, 'ExamenMenfp', 'menfp_exam'),
	//'student0' => array(self::BELONGS_TO, 'Persons', 'student'),
	

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($acad)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

        $criteria->with= array('student0','menfpExam');
        $criteria->alias='mg';
        
        
		
		//$criteria->join = 'inner join examen_menfp em on(em.id=mg.menfp_exam) inner join subjects s on(s.id=em.subject) inner join persons p on(p.id=mg.student)';
		$criteria->condition = 'menfpExam.academic_year='.$acad;
		$criteria->order = 'student0.last_name ASC';


		$criteria->compare('mg.id',$this->id);
		$criteria->compare('menfpExam.level',$this->level);
		$criteria->compare('s.subject_name',$this->subject_name,true);
		$criteria->compare('student0.last_name',$this->last_name,true);
		$criteria->compare('student',$this->student);
		$criteria->compare('student0.fullName)',$this->student_fullname,true);
		$criteria->compare('menfp_exam',$this->menfp_exam);
		$criteria->compare('grade',$this->grade);
		

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			
			'pagination'=>array(
        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    			),
		));
	}


public function search_($acad)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

        $criteria->with= array('student0','menfpExam');
        $criteria->alias='mg';
        
		//$criteria->join = 'inner join examen_menfp em on(em.id=mg.menfp_exam) inner join subjects s on(s.id=em.subject) inner join persons p on(p.id=mg.student)';
		$criteria->condition = 'menfpExam.academic_year='.$acad;
		$criteria->order = 'student0.last_name ASC';
		$criteria->group = 'student';
		


		$criteria->compare('menfpExam.level',$this->level);
		$criteria->compare('student0.last_name',$this->last_name,true);
		$criteria->compare('student',$this->student);
		$criteria->compare('student0.fullName)',$this->student_fullname,true);
		

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			
			'pagination'=>array(
        			'pageSize'=> 100000,
    			),
		));
	}





	public function searchByStudent($student,$acad)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

        $criteria->with= array('student0','menfpExam');
        $criteria->alias='mg';
		
		$criteria->join = 'inner join examen_menfp em on(em.id=mg.menfp_exam) inner join subjects s on(s.id=em.subject) inner join persons p on(p.id=mg.student)';
		$criteria->condition = 'student='.$student.' AND menfpExam.academic_year='.$acad;
		$criteria->order = 'student0.last_name ASC';


		$criteria->compare('mg.id',$this->id);
		$criteria->compare('menfpExam.level',$this->level);
		$criteria->compare('s.subject_name',$this->subject_name,true);
		$criteria->compare('student0.last_name',$this->last_name,true);
		$criteria->compare('student',$this->student);
		$criteria->compare('student0.fullName)',$this->student_fullname,true);
		$criteria->compare('menfp_exam',$this->menfp_exam);
		$criteria->compare('grade',$this->grade);
		

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			
			'pagination'=>array(
        			'pageSize'=> 100,
    			),
		));
	}


	
public function searchGradesForStudent($stud,$level,$acad)	
	{	// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

         $criteria->alias = 'mg';
			
			$criteria->condition = ' mg.student='.$stud.' AND em.level='.$level.' AND em.academic_year='.$acad;
			   
			$criteria->select = ' em.id as id_exam,mg.id as id_grade, s.subject_name,em.weight,mg.grade  ';
                       
			$criteria->join = 'inner join examen_menfp em on(em.id=mg.menfp_exam) inner join subjects s on(s.id=em.subject) ';
       

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			
			'pagination'=>array(
        			'pageSize'=>100,
    			),
		));
	}
	
	
	
	
	
	
	
}