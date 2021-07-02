<?php
namespace app\Helper;

class ContentDynamicExcess
{
   public function DataExcess($data)
   {
         
    $obj=$data;
    $refObj = new \ReflectionObject($obj);
    $refProp1 = $refObj->getProperty('fields');
    // echo '<pre>';print_r($refObj);exit;
    // dd($refObj);
    // if(!empty($refObj->getProperty('fields')))
    // {
    //    echo !empty($refObj->getProperty('fields')); exit;
        
    // }else if(!empty($refObj->getProperty('items')))
    // {
    //     $refProp1 = $refObj->getProperty('items');
    // }
    
    
    
    $refProp1->setAccessible(TRUE);
    $get=$refProp1->getValue($obj);
    
    //$refProp2 = $get->getProperty('fields');
    //$refProp2->setAccessible(TRUE);
    //$get1=$refProp1->getValue($get);
    
//    dd($get)
//    $objArr=json_decode(json_encode($get));
//    dd((Array)$objArr);
//   $array_conv=(Array)$objArr->fields;
//   $data="";
  foreach($get as $arr_k=>$arr_val)
  {
    echo $valueType=gettype($arr_val['en-US']);
     
     if($valueType=='string')
     {
      
     $ret['string'][]=['key'=>$arr_k , 'value'=>$arr_val];
     
     }else if($valueType=='object'){
        $objArr=json_decode(json_encode($arr_val['en-US']));
        if (!empty($objArr->nodeType))
        {
               if($objArr->nodeType=='document')    {
                $ret['richtext'][]=['key'=>$arr_k , 'value'=>$arr_val];
               }           
        }else if(!empty($objArr->sys)){
               
            if(!empty($objArr->sys->linkType))
            {
                if($objArr->sys->linkType='Asset'){
                    $ret['asset'][]=['key'=>$arr_k , 'value'=>$arr_val];
                }else if($objArr->sys->linkType='Entry'){
                   
                    $ret['link'][]=['key'=>$arr_k , 'value'=>$arr_val];
                }

            }
     
        }

       
     }
     
     
     
  }
  return $ret;
   //dd($ret);
   //echo '<pre>';print_r($ret);
   
  //exit;





  
   }

   public function ImageExcessByContentType($data)
   {
         
    $obj=$data;
    $refObj = new \ReflectionObject($obj);
    $refProp1 = $refObj->getProperty('items');
    $refProp1->setAccessible(TRUE);
    $get=$refProp1->getValue($obj);
    $image_data=json_decode(json_encode($get[0]));
    $image_do= (Array)$image_data->fields;
    
    // $refProp2 = $get[0]->getProperty('en-US');
    // dd($refProp2);
    // $refProp2->setAccessible(TRUE);
    // $get1=$refProp1->getValue($get);
    
//    dd($get)
//    $objArr=json_decode(json_encode($get));
//    dd((Array)$objArr);
//   $array_conv=(Array)$objArr->fields;
//   $data="";
  foreach($image_do as $arr_k=>$arr_val)
  {
    //dd($arr_val);
   
     $valueType=gettype($arr_val);

   
     
     if($valueType=='string')
     {
      
     $ret['string'][]=['key'=>$arr_k , 'value'=>$arr_val];
     
     }else if($valueType=='object'){
        $objArr=$arr_val;
        if (!empty($objArr->nodeType))
        {
               if($objArr->nodeType=='document')    {
                $ret['richtext'][]=['key'=>$arr_k , 'value'=>$arr_val];
               }           
        }else if(!empty($objArr->sys)){
               
            if(!empty($objArr->sys->linkType))
            {
                if($objArr->sys->linkType='Asset'){
                    $ret['asset'][]=['key'=>$arr_k , 'id'=>$objArr->sys->id];
                }else if($objArr->sys->linkType='Entry'){
                   
                    $ret['link'][]=['key'=>$arr_k , 'id'=>$objArr->sys->id];
                }

            }
     
        }

       
     }
     
     
     
  }
  return $ret;
  
}


public function ImageExcessByEntry($data)
{
      
 $obj=$data;
 $refObj = new \ReflectionObject($obj);
 $refProp1 = $refObj->getProperty('fields');
 $refProp1->setAccessible(TRUE);
 $get=$refProp1->getValue($obj);

 $image_data=json_decode(json_encode($get));
 //dd($image_data);
 $image_do= (Array)$image_data;
 //dd($image_do);
 // $refProp2 = $get[0]->getProperty('en-US');
 // dd($refProp2);
 // $refProp2->setAccessible(TRUE);
 // $get1=$refProp1->getValue($get);
 
//    dd($get)
//    $objArr=json_decode(json_encode($get));
//    dd((Array)$objArr);
//   $array_conv=(Array)$objArr->fields;
//   $data="";
foreach($image_do as $arr_k=>$arr_val)
{
  $arr_val=(Array) $arr_val;
  $arr_val=$arr_val['en-US'];
  //echo '<pre>'; print_r($arr_val);exit;

   $valueType=gettype($arr_val);


  //echo '<pre>'; print_r($arr_val);
  if($valueType=='string')
  {
   
  $ret['string'][]=['key'=>$arr_k , 'value'=>$arr_val];
  
  }else if($valueType=='object'){
     $objArr=$arr_val;
     if (!empty($objArr->nodeType))
     {
            if($objArr->nodeType=='document')    {
             $ret['richtext'][]=['key'=>$arr_k , 'value'=>$arr_val];
            }           
     }else if(!empty($objArr->sys)){
            
         if(!empty($objArr->sys->linkType))
         {
             if($objArr->sys->linkType='Asset'){
                 $ret['asset'][]=['key'=>$arr_k , 'id'=>$objArr->sys->id];
             }else if($objArr->sys->linkType='Entry'){
                
                 $ret['link'][]=['key'=>$arr_k , 'id'=>$objArr->sys->id];
             }

         }
  
     }

    
  }
  
  
  
}
//exit;
return $ret;

}

}
?>