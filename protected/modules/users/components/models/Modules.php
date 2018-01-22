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


class Modules extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'modules';
	}

	public function rules()
	{
		return array(
			array('module_short_name, module_name', 'required'),
                        array('module_short_name,module_name', 'unique'),
			array('module_short_name, module_name,mod_lateral_menu', 'length', 'max'=>64),
			array('create_by, update_by', 'length', 'max'=>45),
			array('create_date, update_date', 'safe'),
			array('id, module_short_name, module_name,mod_lateral_menu, create_date, update_date, create_by, update_by', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'groups' => array(self::MANY_MANY, 'Groups', 'groups_has_modules(groups_id, modules_id)'),
			
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
			'module_short_name' => Yii::t('app', 'Module Short Name'),
			'module_name' => Yii::t('app', 'Module Name'),
                        'mod_lateral_menu' => Yii::t('app', 'Lateral menu'),
			'create_date' => Yii::t('app', 'Create Date'),
			'update_date' => Yii::t('app', 'Update Date'),
			'create_by' => Yii::t('app', 'Create By'),
			'update_by' => Yii::t('app', 'Update By'),
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);

		$criteria->compare('module_short_name',$this->module_short_name,true);

		$criteria->compare('module_name',$this->module_name,true);
                
        $criteria->compare('mod_lateral_menu',$this->mod_lateral_menu,true);

		$criteria->compare('create_date',$this->create_date,true);

		$criteria->compare('update_date',$this->update_date,true);

		$criteria->compare('create_by',$this->create_by,true);

		$criteria->compare('update_by',$this->update_by,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
			'pagination'=>array(
        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    			),
		));
	}
        
  
  public function searchByProfil($profil_id)
	{
		$criteria=new CDbCriteria;
		
		$criteria->alias = 'm';
		
		$criteria->join='inner join profil_has_modules pm on(m.id=pm.module_id)';

		$criteria->condition = 'pm.profil_id=:profilID';
        $criteria->params = array(':profilID' => $profil_id);

		$criteria->compare('m.id',$this->id);

		$criteria->compare('m.module_short_name',$this->module_short_name,true);

		$criteria->compare('m.module_name',$this->module_name,true);
                
        $criteria->compare('m.mod_lateral_menu',$this->mod_lateral_menu,true);

		$criteria->compare('create_date',$this->create_date,true);

		$criteria->compare('update_date',$this->update_date,true);

		$criteria->compare('create_by',$this->create_by,true);

		$criteria->compare('update_by',$this->update_by,true);

        $criteria->order='pm.profil_id';

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
			'pagination'=>array(
        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    			),
		));
	}
	
	
	
  public function searchModuleByGroupId()
	{     
			$criteria = new CDbCriteria;
			
			
			$criteria->alias = 'm';
                        $criteria->select = '*';
			
			
    return new CActiveDataProvider($this, array(
        'pagination'=>array(
        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    			),
		'criteria'=>$criteria,
    ));
          
			   
	
    }
    
    /**
     * 
     * @param type $moduleName
     * @return \CActiveDataProvider
     */
    public function getModuleId($moduleName)
    {
            $criteria = new CDbCriteria;
			
            $criteria->alias = 'm';
            
            $criteria->select = '*';

            $criteria->condition = 'm.module_short_name=:moduleName';
            $criteria->params = array(':moduleName' => $moduleName);
			
			
    return new CActiveDataProvider($this, array(
        		'criteria'=>$criteria,
    ));
           
    }        
}
