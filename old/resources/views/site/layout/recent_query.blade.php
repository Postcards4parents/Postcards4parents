@php
function getIDS($client,$option=null)
{
 
$day_before = date( 'Y-m-d', strtotime('-2 month' ));
$q=new \Contentful\Delivery\Query();
// if(Auth::guard('user')->check()){
//     $grades_arr=Session::get('grades_array_data');
    
//     $querycat=$q->setContentType("grade")
//           ->where("sys.publishedCounter[gte]","1");
//     $entries_grade =$client->getEntries($querycat);
    
//     foreach($entries_grade as $egrade)
//     {
//         if(!empty($egrade))
//         {
//            $grade_number=$egrade->get('grade');
//            $grade_ID=$egrade->getID();
//            $grade_arr_id[$grade_number]=$grade_ID;
           
  
//         }
//     }
    
//     foreach($grades_arr as $gVal)
//     {
//        $Gids[]=$grade_arr_id[$gVal];
//     }


//  $Rquery=$q->setContentType("postcard")

//  ->where("fields.gradeLevel.sys.id[in]",implode(',',$Gids)) 
// ->where("sys.updatedAt[gte]",$day_before)
// ->orderBy("sys.createdAt",true)
// ->setLimit(10)

// ->where("sys.publishedCounter[gte]","1");


    
// }else{

//     $Rquery=$q->setContentType("postcard")

// ->where("sys.updatedAt[gte]",$day_before)
// ->orderBy("sys.createdAt",true)
// ->setLimit(10)
// ->where("sys.publishedCounter[gte]","1");


//    }

//read cookies


if(empty($_COOKIE['grade_number']) && empty($option))
{

   $grades_arr=[2];

}else{
   if(!empty($option))
   {
      $grades_arr=json_decode($option);
   }else{
      $grades_arr=json_decode($_COOKIE['grade_number']);
   }
   

}

    
    $querycat=$q->setContentType("grade")
          ->where("sys.publishedCounter[gte]","1");
    $entries_grade =$client->getEntries($querycat);
    
    foreach($entries_grade as $egrade)
    {
        if(!empty($egrade))
        {
           $grade_number=$egrade->get('grade');
           $grade_ID=$egrade->getID();
           $grade_arr_id[$grade_number]=$grade_ID;
           
  
        }
    }
    
    foreach($grades_arr as $gVal)
    {
       $Gids[]=$grade_arr_id[$gVal];
    }


 $Rquery=$q->setContentType("postcard")

 ->where("fields.gradeLevel.sys.id[in]",implode(',',$Gids)) 
->where("sys.updatedAt[gte]",$day_before)
->orderBy("sys.createdAt",true)
->setLimit(10)

->where("sys.publishedCounter[gte]","1");




return $Rquery;
   
}
@endphp