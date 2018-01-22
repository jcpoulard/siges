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






class CustomField extends BaseCustomField
{


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	
	
	public function rules()
	{
		return array_merge(
		    	parent::rules(), array(
                            array('field_name', 'unique'),
			));
	}
        
        public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'field_name' =>Yii::t('app','Field Name'),
			'field_label' =>Yii::t('app', 'Field Label'),
			'field_type' =>Yii::t('app', 'Field Type'),
			'field_related_to' =>Yii::t('app', 'Field Related To'),
			'date_created' =>Yii::t('app',  'Date Created'),
			'date_updated' =>Yii::t('app',  'Date Updated'),
                        'field_option' =>Yii::t('app',  'Field Option'),
			'create_by' =>Yii::t('app',  'Create By'),
			'update_by' =>Yii::t('app',  'Update By'),
		);
	}

	
        public function getFieldType(){
            return array(
                'txt'=>Yii::t('app','Text field'),
                'date'=>Yii::t('app','Date field'),
                'combo'=>Yii::t('app','Combo list'),
                //'checkbox'=>Yii::t('app','Checkbox'),
            );
        }
        
        public function getValueType(){
            return array(
                'int'=>Yii::t('app','Integer'),
                'float'=>Yii::t('app','Decimal value'),
                'text'=>Yii::t('app','Text value'),
            );
        }
        
        public function getPersonType(){
            return array(
                //'postu'=>Yii::t('app','Postulant'),
                'stud'=>Yii::t('app','Students'),
                //'emp'=>Yii::t('app','Employees'),
                //'teach'=>Yii::t('app','Teachers'),
                
            );
        }
  
   public function getPersonTypeVal(){
            switch($this->field_related_to)
            {
              //  case 'postu':
              //       return Yii::t('app','Postulant');
                case 'stud':
                    return Yii::t('app','Students');
             /*   case 'emp':
                    return Yii::t('app','Employees');
                case 'teach':
                    return Yii::t('app','Teachers');
               */
            }
        }
	
	
} 
