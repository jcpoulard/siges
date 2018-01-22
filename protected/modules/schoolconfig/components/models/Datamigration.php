<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Datamigration extends Persons
{
	public $room = null;
        public $title = null;
        
        
        public function createUsername($last_name, $id){
            $explode_lastname=explode(" ",substr($last_name,0));
            
            if(isset($explode_lastname[1])&&($explode_lastname[1]!='')){
              $username= strtolower( $explode_lastname[0]).'_'.strtolower( $explode_lastname[1]).$id;
            }
            else{
              $username = strtolower( $explode_lastname[0]).$id;
            }
            
            return $username; 
        }
        
        public function getGroupIdByName($groupname){
            $group=Groups::model()->getGroupIdByName($groupname);
                  $group=$group->getData();
                  if(isset($group)&&($group!=''))
                     {  foreach($group as $g)
                            {
                                $group_id=$g->id;
                                }

                        }else{
                            $group_id = null;
                        }
                        
            return $group_id;            
                        
        }
        
        public function getProfilIdByName($profilname){
              $profil = Profil::model()->getProfilIdByName($profilname);
              $profil = $profil->getData();
              if(isset($profil)&&($profil!=''))
                 {  foreach($profil as $prof)
                        {
                            $profil_id=$prof->id;
                            }

                    }else{
                        $profil_id = null;
                    }
            return $profil_id;
        }
        
        
        
}
