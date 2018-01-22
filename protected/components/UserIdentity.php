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

?>
<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
//		$users=array(
//			// username => password
//			'demo'=>'demo',
//			'admin'=>'admin',
//		);
//		if(!isset($users[$this->username]))
//			$this->errorCode=self::ERROR_USERNAME_INVALID;
//		elseif($users[$this->username]!==$this->password)
//			$this->errorCode=self::ERROR_PASSWORD_INVALID;
//		else
//			$this->errorCode=self::ERROR_NONE;
//		return !$this->errorCode;
            
            $user = User::model()->findByAttributes(array(
                'username'=>$this->username,'active'=>true
            ));
			//$this->setState('profil',null);
            
            if ($user===null){
                $this->errorCode=self::ERROR_USERNAME_INVALID;
                $this->setState('profil', " ");
                $this->setState('fullname',"");
                $this->setState('groupid',0);
                $this->setState('personid',0);
                $this->setState('partname',""); // first word of the name
                $this->setState('email',""); // take the email of the login user
			}
            elseif($user->check($this->password))
            {
                
                  $this->setState('profil', $user->profil0->profil_name);
                   $this->setState('userid',$user->id);    
                $this->setState('groupid',$user->group_id);   
                  //pour profil_selector
                  Yii::app()->session['main_profil']=$user->profil0->profil_name;
                  
                
                   
		        $this->setState('fullname',$user->full_name);
               
               if(!isset($user->person->email))
                  $this->setState('email',"");
                else  
                  $this->setState('email',$user->person->email);
                  
               
               if(!isset($user->person->id))
                  $this->setState('personid',0);
                else  
                  $this->setState('personid',$user->person->id);
                  
                  
                
                //Prendre les deux premiers mots de full_name
                $fcw = $user->full_name;
                $fl = '';
                $arr = explode(' ',trim($fcw));
                if(!isset($arr[1]))
                {
                $fl = $arr[0];
                }
                else
                {
                    $fl = $arr[0];
                }
                
                $this->setState('partname',$fl); 
                              
                $this->errorCode=self::ERROR_NONE;
            }
            else
                $this->errorCode=self::ERROR_PASSWORD_INVALID;
            return !$this->errorCode;
	}
}