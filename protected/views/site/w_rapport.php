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
  $baseUrl = Yii::app()->baseUrl; 
  $cs = Yii::app()->getClientScript();
  $cs->registerScriptFile($baseUrl.'css/js/html5.js');
?> 




<!-- ================================================== -->



 <?php 
            $criteria = new CDbCriteria;
            $criteria->select = 'count(*) as total_stud';
           $criteria->condition='is_student=:item_name AND active IN(1,2)';
            $criteria->params=array(':item_name'=>1,);
            $total_stud = Persons::model()->find($criteria)->count();
           

            
            
      
        $tot_stud_s=0;
        $female_s = 0;
        $male_s = 0;

        $tot_stud=0;
        $female = 0;
        $male = 0;
        //teachers
        $tot_teach_s=0;
        $female1_s = 0;
        $male1_s = 0;

        $tot_teach=0;
        $female1 = 0;
        $male1 = 0;
        //employees									   
        $tot_emp_s=0;
        $female2_s = 0;
        $male2_s = 0;

        $tot_emp=0;
        $female2 = 0;
        $male2 = 0;

         $level = array();




        // Student data 
        $dataProvider= Persons::model()->searchStudentsReport($acad);

        if($dataProvider->getItemCount()!=0)
            $tot_stud =$dataProvider->getItemCount();


        //reccuperer la qt des diff. sexes
        $person=$dataProvider->getData();

        foreach($person as $stud)
         {
	        if($stud->gender==1)
	            $female++;
	        elseif($stud->gender==0)
	            $male++;
         }
        // Fin student data 

        // Teachers data 

        $dataProvider1= Persons::model()->searchTeacherReport($acad);

        if($dataProvider1->getItemCount()!=0)
        $tot_teach =$dataProvider1->getItemCount();


        //reccuperer la qt des diff. sexes
        $person=$dataProvider1->getData();

        foreach($person as $teacher)
         {
	        if($teacher->gender==1)
	             $female1++;
	        elseif($teacher->gender==0)
	              $male1++;
         }
        // Fin teachers

        // debut Employes 
        $dataProvider2= Persons::model()->searchEmployeeReport($acad);

        if($dataProvider2->getItemCount()!=0)
           $tot_emp =$dataProvider2->getItemCount();


        //reccuperer la qt des diff. sexes
        $person=$dataProvider2->getData();

        foreach($person as $employee)
         {
	        if($employee->gender==1)
	             $female2++;
	        elseif($employee->gender==0)
	            $male2++;
          }

// fin employes 


// Total pesonnes 
$tot_pers = $tot_stud + $tot_emp + $tot_teach;
      				
//reccuperer la qt des diff. sexes
$tot_fem = $female  + $female1 + $female2;
$tot_mal = $male  + $male1 + $male2;
// fin total personne 

// Stat sur Rooms 
$tot_rooms=0; 
$countRooms = Rooms::model()->searchReport(); 
if($countRooms->getItemCount()!=0)
    $tot_rooms = $countRooms->getItemCount();

// Stat sur Subjects 
$tot_sub=0; 
$countSubjects = Subjects::model()->searchReport(); 
if($countSubjects->getItemCount()!=0)
    $tot_sub = $countSubjects->getItemCount();

// Stat sur Courses 
 $countCourses = null;
$tot_course=0; 
if($acad!='')
 $countCourses = Courses::model()->searchReport($acad); 
if($countCourses->getItemCount()!=0)
    $tot_course = $countCourses->getItemCount();

 ?>
 
 
   


    
 			
			
			
			
			
			<div class="span2">
			
			<div class="box2 box2-default">
			        <div class="box-header with-border">
			            <h5 class="box-title">
							<div><?php echo Yii::t('app','Subjects'); ?></div></h5>
			                  <div class="box-tools pull-right">
			                    
			                  </div>
			        </div>
			    
			    <div class="box2-body" style="vertical-align: center; alignment-adjust: middle; font-size: 1.5em; color:#EE6539; clear: both;">           
				    
			                <i class="fa fa-file-o "></i>
			               <div class="box-tools pull-right"> <?php echo $tot_sub; ?>  </div>
			                <!--<i class="fa fa-building-o fa-2x"></i> -->
			
			            
			    </div>
			                
			</div>                 
			
			
			
			
			
			
			
			
			
			<div class="span2">
			
			<div class="box2 box2-default">
			        <div class="box-header with-border">
			            <h5 class="box-title">
							<div><?php echo Yii::t('app','Courses'); ?></div></h5>
			                  <div class="box-tools pull-right">
			                    
			                  </div>
			        </div>
			    
			    <div class="box2-body" style="vertical-align: center; alignment-adjust: middle; font-size: 1.5em; color:#EE6539; clear: both;">           
				    
			                <i class="fa fa-folder-open"></i>
			               <div class="box-tools pull-right"> <?php echo $tot_course; ?>  </div>
			                <!--<i class="fa fa-building-o fa-2x"></i> -->
			
			            
			    </div>
			                
			</div>                 
			
			
			
			
			
			
			
			
			
			<div class="span2">
			
						<div class="box2 box2-default">
			               <div class="box-header with-border">
							 <h6 class="box-title"> <?php echo $tot_stud." ".Yii::t('app','Students'); ?></h6>
			           
			              <div class="box-tools pull-right">
			                    
			             </div>
			            </div>
			    
				    <div class="box2-body" style="vertical-align: center; alignment-adjust: middle; font-size: 1.5em; color:#EE6539; clear: both;">           
				               <span>
				               <i class="fa fa-female">:</i><?php echo $female; ?> 
				               <div class="box-tools pull-right">   </div> 
				                <!--<i class="fa fa-building-o fa-2x"></i> -->
				               
				               <div class="box-tools pull-right"> <i class="fa fa-male ">:</i><?php echo $male; ?>   </div>
				               </span>	
				    </div>
			                
			 </div>
			
			
			
			
			
			
			
			<div class="span2">
			
						<div class="box2 box2-default">
			               <div class="box-header with-border">
							 <h6 class="box-title">  <?php echo $tot_teach." ".Yii::t('app','Teachers'); ?></h6>
			           
			              <div class="box-tools pull-right">
			                    
			             </div>
			            </div>
			    
				    <div class="box2-body" style="vertical-align: center; alignment-adjust: middle; font-size: 1.5em; color:#EE6539; clear: both;">           
				                
				               <span>
				               <i class="fa fa-female">:</i><?php echo $female1; ?> 
				               <div class="box-tools pull-right">   </div> 
				                <!--<i class="fa fa-building-o fa-2x"></i> -->
				               
				               <div class="box-tools pull-right"> <i class="fa fa-male">:</i><?php echo $male1; ?>   </div>
				               </span>	
				    </div>
			                
			 </div>
			
			
			
			
			
			
			
			<div class="span2">
			
						<div class="box2 box2-default">
			               <div class="box-header with-border">
							<h8 class="box-title"> <?php echo $tot_pers." ".Yii::t('app','Persons'); ?></h8>
			              <div class="box-tools pull-right">
			                    
			             </div>
			            </div>
			    
				    <div class="box2-body" style="vertical-align: center; alignment-adjust: middle; font-size: 1.5em; color:#EE6539; clear: both;">           
				                
				               <span>
				               <i class="fa fa-female">:</i><?php echo $tot_fem; ?> 
				               <div class="box-tools pull-right">   </div> 
				                <!--<i class="fa fa-building-o fa-2x"></i> -->
				            
				               <div class="box-tools pull-right">    <i class="fa fa-male fa-1.5x">:</i><?php echo $tot_mal; ?>   </div>
				               </span>	
				    </div>
			
			    </div> <!--end fluid 2-->








