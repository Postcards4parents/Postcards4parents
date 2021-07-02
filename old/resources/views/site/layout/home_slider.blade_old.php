<aside class="col-md-7 my-auto">
    <div id="info" class="owl-carousel owl-theme">
        <?php
          
          //$home_banner = $client->getEntry("2sv2CSQykVRWElEQ6GnZNt");

         
         
        $query->setContentType("homeBanner");
        $home_banner = $client->getEntries($query);
        //dd($home_banner);$client->getAsset
        $data_banner=$contentDynamic->ImageExcess($home_banner);
        echo '<pre>';print_r($data_banner['asset']);exit;
        
       foreach ($home_banner as $hm) { 
             

            $link1 = $hm->get('image1', null, false);
           
            if(!empty($link1)){
              $brand1 = $client->resolveLink($link1);
             
              if(!empty($brand1->getFile()))
              {
                $first_url= $brand1->getFile()->getUrl();
              }
              
            }else{
              $first_url="";
            }
            
            

            $link2 = $hm->get('image2', null, false);
            //dd($client->resolveLink($link2));
            if(!empty($link2)){
              $brand2 = $client->resolveLink($link2);
              
              if(!empty($brand2->getFile()))
              {
              $second_url= $brand2->getFile()->getUrl();
              }
            }else{
              $second_url="";
            }
            // dd($second_url);
           

            $link3 = $hm->get('image3', null, false);
            //dd($link3);
            if(!empty($link3)){
              $brand3 = $client->resolveLink($link3);
              if(!empty($brand3->getFile()))
              {
              $third_url= $brand3->getFile()->getUrl();
              } 
            }else{
              $third_url="";
            }
            $third_url="";
            $link4 = $hm->get('image4', null, false);
            if(!empty($link4)){
              $brand4 = $client->resolveLink($link4);
              if(!empty($brand4->getFile()))
              {
              $four_url= $brand4->getFile()->getUrl();
              }
            }else{
              $four_url="";
            }
          }
            
            ?>
      <div class="item">
      <img src="{{  $first_url }}"  class="img-fluid">
      </div>
      <div class="item">
        <img src="{{  $second_url }}"  class="img-fluid">
      </div>
      <div class="item">
        <img src="{{ $third_url }}"  class="img-fluid">
      </div>
      <div class="item">
            <img src="{{ $four_url }}"  class="img-fluid">
          </div>
   
  </div>
  </aside>