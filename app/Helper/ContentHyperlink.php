<?php
namespace app\Helper;
use Contentful\RichText\NodeRenderer\NodeRendererInterface;
use Contentful\RichText\Node\NodeInterface;
use Contentful\RichText\Node\Hyperlink;
use Contentful\RichText\RendererInterface;
use Contentful\RichText\Node\EntryHyperlink;


class ContentHyperlink implements NodeRendererInterface
{
    public function supports(NodeInterface $node): bool
    {
        return $node instanceof Hyperlink;
    }

    public function render(RendererInterface $renderer, NodeInterface $node, array $context = []): string
    {
      //dd($node->getType());  
     //return $node->getEntry();
   // return $entry = $node->getEntry();

    $link_value=json_decode(json_encode($node->getContent()[0]))->value;

    $uri=$node->getUri();
    $title=$node->getTitle();

     return 
        "<a target='_blank' href="."$uri".">$link_value</a>";
        //$image_url= $node->getAsset()->getFile()->getUrl();
       //dd($image_url);
       // $entry = $node->getEntry();
        //return '<div>'.'<img '.'src='."$image_url".' '.'/>'.'</div>';
    }



}


