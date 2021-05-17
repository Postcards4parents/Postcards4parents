<?php
namespace app\Helper;
use Contentful\RichText\NodeRenderer\NodeRendererInterface;
use Contentful\RichText\Node\NodeInterface;
use Contentful\RichText\Node\EmbeddedEntryInline;
use Contentful\RichText\RendererInterface;


class ContentEntryInline implements NodeRendererInterface
{
    public function supports(NodeInterface $node): bool
    {
        return $node instanceof EmbeddedEntryInline;
    }

    public function render(RendererInterface $renderer, NodeInterface $node, array $context = []): string
    {
       //$image_url= $node->getAsset()->getFile()->getUrl();
    
       
     
       $obj=$node;
       $refObj = new \ReflectionObject($obj);
       
       $refProp1 = $refObj->getProperty('entry');
       $refProp1->setAccessible(TRUE);
       $get=$refProp1->getValue($obj);

    //    $refProp2 = $get->getProperty('fields');
    //    $refProp2->setAccessible(TRUE);
    //    $get1=$refProp1->getValue($get);
       
     
     $objArr=json_decode(json_encode($get));
     $array_conv=(Array)$objArr->fields;
     $data="";
     foreach($array_conv as $arr_k=>$arr_val)
     {
        $valueType=gettype($arr_val);
        
        if($valueType=='string')
        {
        $ret='<p>';  
        $ret.=$arr_k.$arr_val;
        $ret.='</p>';
        
        $data.=$ret;
        
        }
        
         //echo '<pre>';print_r($arr_val);
         //echo '<pre>';print_r();

       //$new=$data+1;
     }
     return $data;
    // echo '<pre>';print_r($mret);
     //exit;  
     // $entry = $node->getEntry();
        //return '<div>'.'<img '.'src='."$image_url".' '.'/>'.'</div>';
    }



}


