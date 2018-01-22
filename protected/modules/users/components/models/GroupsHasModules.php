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




class GroupsHasModules extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'groups_has_modules';
	}

	public function rules()
	{
		return array(
			array('groups_id, modules_id', 'required'),
			array('groups_id, modules_id', 'numerical', 'integerOnly'=>true),
			array('groups_id, modules_id', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
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
			'groups_id' => Yii::t('app', 'Groups'),
			'modules_id' => Yii::t('app', 'Modules'),
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('groups_id',$this->groups_id);

		$criteria->compare('modules_id',$this->modules_id);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
        
        /**
         * 
         * @param type $idModule
         * @param type $idGroup
         * @return type
         */
        public function checkModuleGroupExist($idModule,$idGroup)
	{
		 $sql='SELECT * FROM groups_has_modules WHERE groups_id='.$idGroup.' AND modules_id='.$idModule;
		 $is_there = Yii::app()->db->createCommand($sql)->queryAll();
            return $is_there;
 	
	}
        
        /**
         * Make a query to search all the module id save in the database 
         * @param type $id
         * @return \CActiveDataProvider
         */
        public function searchModuleByGroupId($id)
	{     
			$criteria = new CDbCriteria;
			
			
			$criteria->alias = 'mg';
			
			$criteria->condition = 'mg.groups_id=:idGroups ';
			$criteria->params = array(':idGroups' => $id);
			
			
                        $criteria->select = 'g.group_name, m.module_short_name, m.module_name';
			$criteria->join = 'inner join groups g on (mg.groups_id = g.id) inner join modules m on (mg.modules_id = m.id)';
			
			
			
			
    return new CActiveDataProvider($this, array(
        'pagination'=>array(
        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    			),
		'criteria'=>$criteria,
    ));
          
			   
	
    } 
       
}
