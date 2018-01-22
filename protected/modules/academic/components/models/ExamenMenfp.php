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
 * This is the model class for table "examen_menfp".
 *
 * The followings are the available columns in table 'examen_menfp':
 * @property integer $id
 * @property integer $level
 * @property integer $subject
 * @property integer $weight
 * @property integer $academic_year
 *
 * The followings are the available model relations:
 * @property Academicperiods $academicYear
 * @property Levels $level0
 * @property Subjects $subject0
 * @property MenfpGrades[] $menfpGrades
 */
class ExamenMenfp extends BaseExamenMenfp
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public $subject_name;
	public $id_exam;
		
	
	public function rules()
	{
		 return array_merge(
                parent::rules(), array(
                   // array(),
           array('subject_name', 'length', 'max'=>150),
			array('id, level, subject,subject_name, weight, academic_year', 'safe', 'on'=>'search'),
			
                   
									
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


	//'academicYear' => array(self::BELONGS_TO, 'Academicperiods', 'academic_year'),
	//'level0' => array(self::BELONGS_TO, 'Levels', 'level'),
	//'subject0' => array(self::BELONGS_TO, 'Subjects', 'subject'),
	//'menfpGrades' => array(self::HAS_MANY, 'MenfpGrades', 'menfp_exam'),
	
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($acad)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		
		$criteria->with= array('level0','subject0');
		
		$criteria->condition = 'academic_year='.$acad;
		$criteria->order = 'level, subject0.subject_name ASC';
		
		$criteria->compare('id',$this->id);
		$criteria->compare('level',$this->level);
		$criteria->compare('subject',$this->subject);
		$criteria->compare('subject0.subject_name',$this->subject_name,true);
		$criteria->compare('weight',$this->weight);
		$criteria->compare('academic_year',$this->academic_year);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			
			'pagination'=>array(
        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    			),
		));
	}
	
	
public function searchStudentsForGrades($level,$acad)	
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		  $criteria->alias = 'em';
			
			$criteria->condition = ' em.level='.$level.' AND em.academic_year='.$acad;
			   
			$criteria->select = ' em.id as id_exam, s.subject_name,em.weight  ';
                       
			$criteria->join = 'inner join subjects s on(s.id=em.subject)  ';
			
			
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			
			'pagination'=>array(
        			'pageSize'=> 100,
    			),
		));
	}
	
	
	
	
	
	
	
}