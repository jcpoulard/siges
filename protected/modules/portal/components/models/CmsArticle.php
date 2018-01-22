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


class CmsArticle extends BaseCmsArticle
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BaseCmsArticle the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	
	
	

  public function attributeLabels()
	{
		
            return array_merge(
                    parent::attributeLabels(), 
                    array(
                        
                      
                      )
                    );
           
	}
        
        public function getPositionName()
         {
     return array(
         'main'=>Yii::t('app','Main article'),
         'box1'=>Yii::t('app','Lateral text 1'),
         'box2'=>Yii::t('app','Lateral text 2'),
                  
     );
 } 
 
 public function getPosition()
	{
                        switch($this->set_position)
                        {
                                case 'main':
                                    return Yii::t('app','Main article');
                                    break;
                                case 'box1':
                                     return Yii::t('app','Lateral text 1');
                                     break;
                                case 'box2':
                                     return Yii::t('app','Lateral text 2');
                                     break;
                                
                                }
        }
        
  public function getPublish(){
      
      switch ($this->is_publish){
          case 0:
              return Yii::t('app','No');
              break;
          case 1:
              return Yii::t('app','Yes');
              break;
      }
  }      
        
        public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('article_title',$this->article_title,true);
		$criteria->compare('article_description',$this->article_description,true);
		$criteria->compare('date_create',$this->date_create,true);
		$criteria->compare('create_by',$this->create_by,true);
                $criteria->compare('article_menu',$this->article_menu);
		$criteria->compare('is_publish',$this->is_publish);
                $criteria->compare('rank_article',$this->rank_article);
		$criteria->compare('section',$this->section);
		$criteria->compare('last_update',$this->last_update,true);
		$criteria->compare('set_position',$this->set_position,true);
                $criteria->order = 'article_menu ASC, id DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>array(
                        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
                        ),
		));
	}
        
        public function getDatePublish(){
           $time = strtotime($this->date_create);
                         $month=date("n",$time);
                         $year=date("Y",$time);
                         $day=date("j",$time);
                         $hour = date("h",$time);
                         $minutes = date("m",$time);
            return $day.'-'.  Schedules::model()->getMonth($month).'-'.$year.' '.$hour.':'.$minutes;             
        }


	
	
	
	
	
}