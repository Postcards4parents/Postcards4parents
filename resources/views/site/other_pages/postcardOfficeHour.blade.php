@extends('site.layout.main')

@section('title')
Post card
@endsection

@section('content')

@php 
$user_auth=Auth::guard('user')->user();
$name = $user_auth->name;
$names = explode(' ',$name);
@endphp
<section class="topBanner accountInfo">
  <div class="container">
    <div class="row">
        <aside class="col-lg-3 col-md-4 d-none d-md-block">
            <ul class="leftLinks">
                <li><a href="{{ url('welcomeKit') }}"><i class="far fa-user"></i> Welcome Kit</a></li>
                <li><a href="{{ url('postcards-office-hours') }}"><i class="far fa-file-alt"></i> Your Postcards</a></li>
                <!-- <li><a href="{{ url('story-circle') }}"><i class="far fa-file-alt"></i> Story Circle</a></li> -->
                <li><a href="{{ url('userDashboard') }}"><i class="fas fa-info"></i> Account Info</a></li>	
                <li><a href="{{ url('user_log/logout') }}"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </aside>
        <aside class="col-lg-9 col-md-8 col-12">
            <h2>{{$names[0]}}’s Room</h2>
            <div class="qot">“ {{$quotation->get('summaryOfTestimonial')}}”<span>– {{$quotation->get('authorName')}}</span></div>
            <div class="hourTime">
                <table class="data-table table-striped" id="learning">
                    <thead>
                        <tr>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $grades_arr=Session::get('grades_array_data');
                            $querycat=$query->setContentType("grade");
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
                            // print_r($grade_arr_id);
                            // echo"---------------";
                            foreach($grades_arr as $gVal)
                            {
                              $Gids[]=$grade_arr_id[$gVal];
                            }
                            // print_r(implode(',',$Gids));die;
                            $query = $query->setContentType("postcard")
                              ->where("fields.gradeLevel.sys.id[in]",implode(',',$Gids)); 
                              // ->orderBy("sys.createdAt",true);

                            $entries_pre = $client->getEntries($query);
                        @endphp
                        @foreach($entries_pre as $postcardList)    
                            
                                @php
                                    if(!empty($postcardList->officeHours)){
                                        $link= $postcardList->officeHours->ooVideoLink;
                                        $vedioLink = explode("=",$link);
                                    }    
                                    $entry_id=$postcardList->getId();
                                    $pre_title=$postcardList->get('title');
                                    if(!empty($pre_title)){
                                        $pre_title= $pre_title;
                                        $pre_name = strtolower(str_replace(' ', '-', $pre_title));
                                    }else{
                                        $pre_title="";
                                        $pre_name = "";
                                    }  
                                @endphp
                                <tr>
                                    <td><a href="{{url("details/$entry_id/$pre_name")}}" target="_blank" class="your_postcard_link">{{$postcardList->title}}</a></td>
                                    @if(!empty($postcardList->officeHours))
                                        <td><a href="#" data-toggle="modal" data-target="#videoModal"><i class="fas fa-play"></i></a>
                                        <!-- Video Modal -->    
                                        <div class="modal fade loginMd" id="videoModal">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                            <div class="modal-body">
                                                <!--<button type="button" class="close" data-dismiss="modal">&times;</button>-->
                                                <div class="row">
                                                <iframe width="100%" height="500" src="https://www.youtube.com/embed/{{$vedioLink[1]}}?loop=1&playlist={{$vedioLink[1]}}&showinfo=0&controls=0" frameborder="0" allowfullscreen></iframe>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                        </div>
                                        </td>
                                    @else
										<td></td>
                                    @endif  
                                </tr>
                            
                        @endforeach                
                    </tbody>
                </table>
                <!-- <p class="text-center loadMore"><a href="">Load more...</a></p> -->
            </div>
        </aside>
    </div>
  </div>
</section>


@endsection
@section('script')

    @php
        $disabledrag=1;
    @endphp
@endsection
