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



class GroupsHasActions extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'groups_has_actions';
	}

	public function rules()
	{
		return array(
			array('groups_id, actions_id', 'required'),
			array('groups_id, actions_id', 'numerical', 'integerOnly'=>true),
			array('groups_id, actions_id, action_id', 'safe', 'on'=>'search'),
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
			'actions_id' => Yii::t('app', 'Actions'),
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('groups_id',$this->groups_id);

		$criteria->compare('actions_id',$this->actions_id);

		return new CActiveDataProvider(get_class($this), array(
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
            
           $criteria->alias = 'ga';
            $criteria->select = '*';
               
            
            $criteria->join = 'inner join groups g on (ga.groups_id = g.id)  inner join actions a on (ga.actions_id = a.id)';
            
			
			
			
    return new CActiveDataProvider($this, array(
        'pagination'=>array(
        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    			),
		'criteria'=>$criteria,
    ));
          
			   
	
    } 
}
