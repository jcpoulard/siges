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



	
// auto-loading



class Mails extends BaseMails
{
    
    
    
    public $room_email;
    public $group_email;
    
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	//public $arroondissement_name;
  public function rules()
	{
              
              return array_merge(
		    	parent::rules(), array(
                           
									));
	}
	

       public function getEmailGroup(){
            return array(
                1=>Yii::t('app','Employees'), // Les personnes dans person qui ont un poste [done] 
                2=>Yii::t('app','Teachers'), // Les professeurs uniquement sans un poste [done]
                3=>Yii::t('app','Rooms'), // Eleves par salle de classe [done]
                4=>Yii::t('app','Parents'), // Les parents en groupe et aussi par salle de classe
                5=>Yii::t('app','School broadcast'), // Broadcast all school persons (teachers, employees and students) [done] 
                6=>Yii::t('app','Parents broadcast'), // Broadcast all parents [done]
                7=>Yii::t('app','Students broadcast'), // Broadcasr all students [done]  
            );            
        }
        
        
        
        public function getDateEmail(){
           $time = strtotime($this->date_sent);
                         $month=date("n",$time);
                         $year=date("Y",$time);
                         $day=date("j",$time);
                         $hour = date("h",$time);
                         $minutes = date("m",$time);
            return $day.'-'.  Schedules::model()->getMonth($month).'-'.$year.' '.$hour.':'.$minutes;             
        }
        
        // Return all the unread mail for a specific user 
        
        public function searchUnreadMail($email)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                
                $criteria->condition = 'receivers=:email AND is_delete = 0 AND is_read = 0';
		$criteria->params = array(':email'=>$email);

		$criteria->compare('id',$this->id);
		$criteria->compare('sender',$this->sender,true);
		$criteria->compare('receivers',$this->receivers,true);
		$criteria->compare('subject',$this->subject,true);
		$criteria->compare('message',$this->message,true);
                $criteria->compare('id_sender',$this->id_sender,true);
		$criteria->compare('is_read',$this->is_read);
                
                 $criteria->order = 'date_sent DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>array(
        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    			),
		));
	}
        
        public function searchUnreadMailForCount($email)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                
                $criteria->condition = 'receivers=:email AND is_delete = 0 AND is_read = 0';
		$criteria->params = array(':email'=>$email);

		$criteria->compare('id',$this->id);
		$criteria->compare('sender',$this->sender,true);
		$criteria->compare('receivers',$this->receivers,true);
		$criteria->compare('subject',$this->subject,true);
		$criteria->compare('message',$this->message,true);
                $criteria->compare('id_sender',$this->id_sender,true);
		$criteria->compare('is_read',$this->is_read);
                
                 $criteria->order = 'date_sent DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                       'pagination'=>array(
        			'pageSize'=>10000,
    			),
		));
	}
        
        // Search all the sent mail for a specific user 
        public function searchSentMail($idSender)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                
                $criteria->condition = 'id_sender=:idSender AND is_my_send=:idSender AND is_delete = 0';
		$criteria->params = array(':idSender'=>$idSender);

		$criteria->compare('id',$this->id);
		$criteria->compare('sender',$this->sender,true);
		$criteria->compare('receivers',$this->receivers,true);
		$criteria->compare('subject',$this->subject,true);
		$criteria->compare('message',$this->message,true);
                $criteria->compare('id_sender',$this->id_sender,true);
		$criteria->compare('is_read',$this->is_read);
                $criteria->compare('is_my_send',$this->is_my_send);
                 $criteria->order = 'date_sent DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>array(
        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    			),
		));
	}
        
        // Search all the trash for a specific user 
        public function searchTrashMail($idSender)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                
                $criteria->condition = 'id_sender=:idSender AND is_delete = 1';
		$criteria->params = array(':idSender'=>$idSender);

		$criteria->compare('id',$this->id);
		$criteria->compare('sender',$this->sender,true);
		$criteria->compare('receivers',$this->receivers,true);
		$criteria->compare('subject',$this->subject,true);
		$criteria->compare('message',$this->message,true);
                $criteria->compare('id_sender',$this->id_sender,true);
		$criteria->compare('is_read',$this->is_read);
                
                 $criteria->order = 'date_sent DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>array(
        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    			),
		));
	}
        
        public function getTotalUnreadMails($userid){
            
             // Take the user id in table users 
             // Get the id person 
            $count_mail = 0;
            $person_ = Persons::model()->getIdPersonByUserID($userid)->getData();
            
           // For each persn make a loop to take the id person 
            $person_id;
            $email_id;
            foreach($person_ as $p){
               $person_id = $p->id;
               $email_id = $p->email;
            }
            if(isset($email_id)){
             // Construct the data provider with all the unread email 
            
            $data_a =  Mails::model()->searchUnreadMailForCount($email_id)->getData();
            
            foreach($data_a as $d){
                if($d->is_read==0){
                    $count_mail++;
                }
            }
        }
            
            return $count_mail;
        }
	
}
