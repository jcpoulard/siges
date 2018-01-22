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



/**
 * This is the model class for table "bareme".
 *
 * The followings are the available columns in table 'bareme':
 * @property integer $id
 * @property double $min_value
 * @property double $max_value
 * @property double $percentage
 * @property integer $compteur
 * @property integer $old_new
 * @property string $date_created
 * @property string $created_by
 */
class Bareme extends BaseBareme
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Bareme the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

/*
 public function rules()
	{
		 return array_merge(
                parent::rules(), array(
                   // array(),
                   // array('person_id+as+academic_year', 'application.extensions.uniqueMultiColumnValidator'),
               					
		));
	}


public function attributeLabels()
	{
		
            return array_merge(
                    parent::attributeLabels(), 
                    array(
                       'old_new'=> Yii::t('app','New setting'),
                                   
                        )
                    );
           
	}
*/


//return an integer   
public function getLastCompteur(){
	
	$sql = 'SELECT DISTINCT MAX(compteur) as compteur FROM bareme';
		$command = Yii::app()->db->createCommand($sql);
        $info__p = $command->queryAll(); 
        
        if($info__p!=null)
          {  foreach($info__p as $info_)
				  { return $info_['compteur'];
				       break;
				  }
          }
        else
           return 0;
	
   }
       
//return an array  
public function getBaremeInUse(){
	
	$sql = 'SELECT id, min_value, max_value, percentage FROM bareme WHERE old_new=1';
		$command = Yii::app()->db->createCommand($sql);
        $info__p = $command->queryAll(); 
        
        if($info__p!=null)
          {  
			  return $info__p;
			  
          }
        else
           return null;
	
   }
     

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('min_value',$this->min_value);
		$criteria->compare('max_value',$this->max_value);
		$criteria->compare('percentage',$this->percentage);
		$criteria->compare('compteur',$this->compteur);
		$criteria->compare('old_new',$this->old_new);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('created_by',$this->created_by,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}