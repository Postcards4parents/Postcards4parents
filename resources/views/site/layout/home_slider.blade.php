<aside class="col-md-7 my-auto">
    <div id="info" class="owl-carousel owl-theme">
        <?php
          
          $home_banner = $client->getEntry("2sv2CSQykVRWElEQ6GnZNt");
          
         
         
        // $query->setContentType("homeBanner");
        // $home_banner = $client->getEntries($query);
        //dd($home_banner);$client->getAsset
        $data_banner=$contentDynamic->ImageExcessByEntry($home_banner);
      
        //echo '<pre>';print_r($data_banner['asset']);exit;
        
       foreach ($data_banner['asset'] as $hm) { 
        
          $asset=$client->getAsset($hm['id']);
           if(!empty($asset->getfile()))
           {
            $asset_url=$asset->getfile()->geturl();
            ?>

          <div class="item">
            <img src="{{  $asset_url }}"  class="img-fluid">
            </div>
           <?php } else{
            $asset_url="";
           }
         

         

        }
        ?>
     
   
  </div>
  </aside>