@extends('site.layout.main')

@section('title')
Post card
@endsection

@section('content')


<section class="thanks disclaimer">
    <div class="container">
      <h1>P4P disclaimer</h1>
  @php
   
  $pre_k = $client->getEntry("5htPoosPPO2nqquZtSspp2");
 //echo '<pre>'; print_r($pre_k); echo '</pre>'; exit;
         $desc=$pre_k->get('atThisAge');

  if(!empty($desc))
         {
          $k_desc= $renderer->render($desc);
         }else{
           $k_desc="";
         }
 @endphp

        <p>{!! $k_desc !!}</p>
      <!--<p>The information provided through Postcards for Parents is for educational purposes only. The Materials include information about forms of treatment that are general in nature and do not cover all possible uses, actions, precautions, side effects, or interactions of any medicines or treatments, nor is the information intended as advice for individual problems or for making an evaluation as to the risks and benefits of a particular form of treatment. The text that may be displayed on the website or in emails at any one time may contain only a portion of relevant information.</p>
      <p>INFORMATION SUPPLIED BY DR. ELIZABETH KNAKE AND POSTCARDS FOR PARENTS, LLC IS PROVIDED "AS IS" AND NEITHER DR. ELIZABETH KNAKE NOR ANY OTHER PERSON MAKE ANY REPRESENTATION OR WARRANTY WITH RESPECT TO THE CONTENTS OF THIS SERVICE OR INFORMATION FURNISHED BY THEM OR OUR AGENT, EMPLOYEES OR REPRESENTATIVES. WE SPECIFICALLY DISCLAIM TO THE FULLEST EXTENT PERMITTED BY LAW AND NEGATE ANY AND ALL WARRANTIES, EXPRESS OR IMPLIED, INCLUDING, BUT NOT LIMITED TO, IMPLIED WARRANTIES OF COMPLETENESS, TIMELINESS, CORRECTNESS, NON INFRINGEMENT, MERCHANTABILITY, OR FITNESS FOR ANY PARTICULAR USE, APPLICATION OR PURPOSE. DR. ELIZABETH KNAKE AND POSTCARDS FOR PARENTS, LLC DO NOT WARRANT OR MAKE ANY REPRESENTATIONS CONCERNING THE ACCURACY, LIKELY RESULTS, OR RELIABILITY OF THE USE OF THE ADVICE ON ITS WEB PAGES OR OTHERWISE RELATING TO SUCH MATERIALS OR OF ANY SITES LINKED TO THESE PAGES.</p>
      <p>BY USING THIS WEBSITE, YOU HEREBY ALSO AGREE THAT DR. ELIZABETH KNAKE AND POSTCARDS FOR PARENTS, LLC, SHALL IN NO EVENT BE LIABLE TO YOU FOR ANY DAMAGES, CLAIMS, DEMANDS OR CAUSES OF ACTION, DIRECT OR INDIRECT, SPECIAL, INCIDENTAL, CONSEQUENTIAL OR PUNITIVE, AS A RESULT OF YOUR USE OR INABILITY TO USE THIS SERVICE OR ANY INFORMATION YOU OBTAIN ON IT OR ANY OTHER INTERACTION WITH IT.</p>
    !--></div>
  </section>
@endsection
