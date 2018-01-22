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






class Taxes extends BaseTaxes
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Taxes the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

//public $id_taxe;
				
 public function rules()
	{
		 return array_merge(
                parent::rules(), array(
                   // array(),
                   array('taxe_description+academic_year+employeur_employe', 'application.extensions.uniqueMultiColumnValidator'),
                                      									
		));
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
		$criteria->condition='academic_year='.$acad;

		$criteria->compare('id',$this->id);
		$criteria->compare('taxe_description',$this->taxe_description,true);
		$criteria->compare('employeur_employe',$this->employeur_employe,true);
		$criteria->compare('taxe_value',$this->taxe_value);
		$criteria->compare('particulier',$this->particulier,true);
		$criteria->compare('academic_year',$this->academic_year);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	
//return info of all taxes description       
public static function searchTaxesForPS($acad)
  {
		$command= Yii::app()->db->createCommand("SELECT  id, taxe_description,taxe_value FROM taxes WHERE  employeur_employe=0 AND academic_year=".$acad);
		//$command->bindValue(':acad', $acad);
		$sql_result = $command->queryAll();
		//if($sql_result!=null)
		  return $sql_result;
  }
       
	
	
public function getTaxeValue(){
             if(($this->taxe_description=='IRI'))
            {  return Yii::t('app','According to the range' );
            	
             }
            else 
                return $this->taxe_value;
        }	
	
       public function getEmployeurEmploye(){
          if($this->employeur_employe!=null)
            {  switch($this->employeur_employe)
	            {
	                case 0:
	                    return Yii::t('app','Employee');
	                case 1:
	                    return Yii::t('app','Employer');
	                    
	                
	                
	            }
            }
           else
               return NULL;
        }
        
     
     
         public function getEmployeurEmployeValue(){
            return array(
                
                0=>Yii::t('app','Employee'),
                1=>Yii::t('app','Employer'),
                
                               
            );            
        } 			
	
	
  public function getParticulier(){
          if($this->particulier!=null)
            {  switch($this->particulier)
	            {
	                case 0:
	                    return Yii::t('app','General');
	                case 1:
	                    return Yii::t('app','Particular');
	                    
	                
	                
	            }
            }
           else
               return NULL;
        }
        
	
 public function getParticulierValue(){
            return array(
                
                0=>Yii::t('app','General'),
                1=>Yii::t('app','Particular'),
                
                               
            );            
        } 		
        
        
        	
	
	
	
	
}