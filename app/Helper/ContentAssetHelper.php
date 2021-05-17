<?php
namespace app\Helper;
use Contentful\RichText\NodeRenderer\NodeRendererInterface;
use Contentful\RichText\Node\NodeInterface;
use Contentful\RichText\Node\EmbeddedAssetBlock;
use Contentful\RichText\RendererInterface;


class ContentAssetHelper implements NodeRendererInterface
{
    public function supports(NodeInterface $node): bool
    {
        return $node instanceof EmbeddedAssetBlock;
    }

    public function render(RendererInterface $renderer, NodeInterface $node, array $context = []): string
    {
       $image_url= $node->getAsset()->getFile()->getUrl();
       //dd($image_url);
       // $entry = $node->getEntry();
        return '<div>'.'<img '.'src='."$image_url".' '.'/>'.'</div>';
    }



}


