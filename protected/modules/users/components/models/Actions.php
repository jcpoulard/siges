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


class Actions extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        

	public function tableName()
	{
		return 'actions';
	}
        
        public $module_short_name;
        public $module_name; 

	public function rules()
	{
		return array(
			array('action_id, action_name, controller, module_id', 'required'),
			array('action_id, action_name, module_name, controller', 'length', 'max'=>64),
                        array('module_id', 'numerical', 'integerOnly'=>true),
			array('create_by, update_by', 'length', 'max'=>45),
			array('create_date, update_date', 'safe'),
                        array('action_id+controller+module_id', 'application.extensions.uniqueMultiColumnValidator'),  
			array('id, action_id, action_name,module_short_name, controller, module_id, module_name, create_date, update_date, create_by, update_by', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
                        'module' => array(self::BELONGS_TO, 'Modules', 'module_id'),
			'groups' => array(self::MANY_MANY, 'Groups', 'groups_has_actions(actions_id, groups_id)'),
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
			'action_id' => Yii::t('app', 'Action'),
			'action_name' => Yii::t('app', 'Action Name'),
			'controller' => Yii::t('app', 'Controller Name'),
                        'module_id' => Yii::t('app', 'Module'),
			'create_date' => Yii::t('app', 'Create Date'),
			'update_date' => Yii::t('app', 'Update Date'),
			'create_by' => Yii::t('app', 'Create By'),
			'update_by' => Yii::t('app', 'Update By'),
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->with='module';
		
		$criteria->compare('id',$this->id);

		$criteria->compare('action_id',$this->action_id,true);

		$criteria->compare('action_name',$this->action_name,true);
		
		$criteria->compare('controller',$this->controller,true);
                
        $criteria->compare('module_id',$this->module_id,true);
        
        $criteria->compare('module.module_name',$this->module_name,true);

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
        
        
        public function getIdModuleByIdAction($idAction)
        {
          
            $criteria = new CDbCriteria;
            
            $criteria->condition = 'id=:idAction';
            $criteria->params = array(':idAction'=>$idAction);
            
            $criteria->select = '*'; 
            
            return new CActiveDataProvider($this, array(
        
                    'criteria'=>$criteria,
                 ));
           
        }
        
   public function searchActionById($controller, $module_name, $group_id)
	{     
            $criteria = new CDbCriteria;
            
            $criteria->condition = 'a.controller like("'.$controller.'") AND m.module_short_name like("'.$module_name.'") AND ga.groups_id='.$group_id;
            
            $criteria->alias = 'a';
            $criteria->select = 'a.action_id';
          
            $criteria->join = 'inner join groups_has_actions ga on (ga.actions_id = a.id) inner join modules m on(a.module_id=m.id)';
            
			
			
    return new CActiveDataProvider($this, array(
        		'pagination'=>array(
        			'pageSize'=> 100000000000000,
    			),
				
				'criteria'=>$criteria,
    ));
          
			   
	
    } 
    
     public function searchActionByModuleId($group_id,$mod_id)
	{     
            $criteria = new CDbCriteria;
            
            $criteria->condition = 'a.module_id=:idModule AND ga.groups_id =:gid';
            $criteria->params = array(':idModule' => $mod_id,':gid'=>$group_id);
            
            $criteria->distinct = true;
            $criteria->alias = 'a';
            $criteria->select = '*';
          
            $criteria->join = 'inner join groups_has_actions ga on (ga.actions_id = a.id) inner join groups g on (ga.groups_id = g.id) join modules m on (a.module_id = m.id)';
            
			
		
			
    return new CActiveDataProvider($this, array(
       'pagination'=>array(
        			'pageSize'=> 100000000000000,
    			),
    			
		'criteria'=>$criteria,
    ));
          
			   
	
    } 
}
