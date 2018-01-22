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



class Groups extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	
	//public $profil_name;
	
	
	
	

	public function tableName()
	{
		return 'groups';
	}

	public function rules()
	{
		return array(
			array('group_name,belongs_to_profil', 'required'),
                        array('group_name', 'unique'),
                        array('belongs_to_profil', 'numerical', 'integerOnly'=>true),
			array('group_name, create_by, update_by', 'length', 'max'=>32),
			array('create_date, update_date', 'safe'),
			array('id, group_name, belongs_to_profil, profil_name, create_date, update_date, create_by, update_by', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'modules' => array(self::MANY_MANY, 'Modules', 'groups_has_modules(groups_id, modules_id)'),
                        'users' => array(self::HAS_MANY, 'Users', 'group_id'),
                        'actions' => array(self::MANY_MANY, 'Actions', 'groups_has_actions(groups_id, actions_id)'),
                        'profil'=>array(self::BELONGS_TO,'Profil','belongs_to_profil'),
                         
		);
	}

	public function behaviors()
	{
		return array('CAdvancedArBehavior',
				array('class' => 'ext.CAdvancedArBehavior')
				);
	}

	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('app', 'ID'),
			'group_name'=>Yii::t('app','User Group'),
			'belongs_to_profil'=> Yii::t('app', 'Belongs to ... profil'),
			'create_date' => Yii::t('app', 'Create Date'),
			'update_date' => Yii::t('app', 'Update Date'),
			'create_by' => Yii::t('app', 'Create By'),
			'update_by' => Yii::t('app', 'Update By'),
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;
		
		$criteria->alias = 'g';
		
		

		$criteria->compare('g.id',$this->id);

		$criteria->compare('group_name',$this->group_name,true);
		
		$criteria->compare('belongs_to_profil',$this->belongs_to_profil,true);
		
		

		$criteria->compare('create_date',$this->create_date,true);

		$criteria->compare('update_date',$this->update_date,true);

		$criteria->compare('create_by',$this->create_by,true);

		$criteria->compare('update_by',$this->update_by,true);

		return new CActiveDataProvider(get_class($this), array(
			'pagination'=>array(
        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    			),
		'criteria'=>$criteria,
		));
	}
        
         /**
         * Make a query to search all the action id save in the database 
         * @param type $id
         * @return \CActiveDataProvider
         */
       public function searchActionById($id)
	{     
            $criteria = new CDbCriteria;
           
            
           $criteria->condition = 'ga.groups_id=:idGroups ';
            $criteria->params = array(':idGroups' => $id);
            
           $criteria->alias = 'g';
            $criteria->select = '*';
               
           
            $criteria->join = 'inner join groups_has_actions ga on (g.id = ga.groups_id)  inner join actions a on (ga.actions_id = a.id)';
            
			
			
			
    return new CActiveDataProvider($this, array(
        'pagination'=>array(
        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    			),
		'criteria'=>$criteria,
    ));
          
			   
	
    } 
    
    
    public function getGroupIdByName($group_name)
	{
		$criteria=new CDbCriteria;

		 $criteria->condition = 'group_name=:prof';
		$criteria->params = array(':prof'=>$group_name);
		
		$criteria->compare('id',$this->id);
		$criteria->compare('group_name',$this->group_name,true);
		$criteria->compare('belongs_to_profil',$this->belongs_to_profil,true);
		
		
		$criteria->compare('create_date',$this->create_date,true);

		$criteria->compare('update_date',$this->update_date,true);

		$criteria->compare('create_by',$this->create_by,true);

		$criteria->compare('update_by',$this->update_by,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
		
    
     }
    
    
    
    
    
    
    
    
    
    
    
    
}







