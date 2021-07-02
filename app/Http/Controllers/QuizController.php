<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Managetemp;
use App\UserQuiz;
use Illuminate\Support\Facades\Auth;
use Newsletter;
class QuizController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth:admin');
    }

    public function index(Request $request){
		
        $all=$request->all();
        $reqdata = ($all['resultdata']);
        $i = 0;
        $j =0;
        
        foreach($reqdata as $req){
				if((strpos($req["name"],"description")) !== false){
							$args['description'] = $req["name"];
							$args['desans'] 	= $req["value"];
							
							}
					 elseif((strpos($req["name"],"fname")) !== false ){
							$fname = $req["value"];
						 }
					elseif((strpos($req["name"],"lname")) !== false ){
							$lname = $req["value"];
						 }
					elseif((strpos($req["name"],"email")) !== false ){
							$email = $req["value"];
						 }
					elseif((strpos($req["name"],"grade")) !== false ){
							$grade = $req["value"];
						 }
					else{
							if((strpos($req['name'],"Question")) !== false ){
									if($i > 0){
											$args[$j]['answer'] = 4;
											$i = 0;
											$j++;
										}
									$args[$j]['question'] = $req['value'];
									$i =1;
								}else{
										if($i < 1){
											$args[$j-1]['answer'] = $args[$j-1]['answer']."," .$req['value'];
											}else{
													$args[$j]['answer'] = $req['value'];
													$i =0; 
													$j++;
												}
										
									}
						}
			}
			
			
			$resultdata = $request->input('resultdata');
        $arg = array();

        foreach ($resultdata as $key => $resultdatalist) {
            if($resultdatalist['name']=='fname'){
                $arg['data'] = "Hi ".$resultdatalist['value']."!";
            }
        }
						$pt1 =4;$pc2 =4;$ex2 = 4;
						$pt2 = 4;$py =4;$rl1 = 4;
						$play1 = 4;$sa = 4;$rl2 =4;
						$play2 =4;$parentCalm =4;$rt1 =4;
						$ed1 = 4;$pe = 4;$rt1 =4;$rt2=4;
						$ed2 = 4;$po =4;$sx1 =4;$sx2 =4;
						$ex1 =4;$ph = 4;$pc1 = 4;

        if(!empty($args)){
			foreach($args as $key=>$value){
				if(is_array($value)){
						
						if($value['question'] == 'emp_perspective_yes'){
								$pt1 = $value['answer'];
							}
						if($value['question'] == 'emp_perspective_no'){
								$pt2 = $value['answer'];
							}
						if($value['question'] == 'emp_play_yes'){
								$play1 = $value['answer'];
							}
						if($value['question'] == 'emp_play_no'){
								$play2 = $value['answer'];
							}
						if($value['question'] == 'emp_democratic_yes'){
								$ed1 = $value['answer'];
							}
						if($value['question'] == 'emp_democratic_no'){
								$ed2 = $value['answer'];
							}
						if($value['question'] == 'emp_expressive_yes'){
								$ex1 = $value['answer'];
							}
						if($value['question'] == 'emp_expressive_no'){
								$ex2 = $value['answer'];
							}
						if($value['question'] == 'str_rules_yes'){
								$rl1 = $value['answer'];
							}
						if($value['question'] == 'str_pushover'){
								$rl2 = $value['answer'];
							}
						if($value['question'] == 'str_routine_yes'){
								$rt1 = $value['answer'];
							}
						if($value['question'] == 'str_routine_no'){
								$rt2 = $value['answer'];
							}
						if($value['question'] == 'str_expect_hi'){
								$sx1 = $value['answer'];
							}
						if($value['question'] == 'str_expect_lo'){
								$sx2 = $value['answer'];
							}
						if($value['question'] == 'parent_confident'){
								$pc1 = $value['answer'];
							}
							if($value['question'] == 'parent_joy'){
								$pjoy1 = $value['answer'];
							}
							if($value['question'] == 'parent_handsoff'){
								$hands1 = $value['answer'];
							}
						if($value['question'] == 'parent_worry'){
								$pc2 = $value['answer'];
							}
						if($value['question'] == 'parent_yell'){
								$py = $value['answer'];
							}
						if($value['question'] == 'str_authority'){
								$sa = $value['answer'];
							}
						if($value['question'] == 'parent_calm'){
								$parentCalm = $value['answer'];
							}
						if($value['question'] == 'parent_escape'){
								$pe = $value['answer'];
							}
						if($value['question'] == 'parent_overwhelm'){
								$po = $value['answer'];
							}
						if($value['question'] == 'parent_helicopter'){
								$ph = $value['answer'];
							}
					}
			} 
		}
			//calculation on the basis of 
			$perspectiveTaking = $pt1 - $pt2;
			$playTime = $play1 - $play2;
			$democratic = $ed1 - $ed2;
			$positiveCommunication = $ex1 - $ex2;
			$settingLimits = $rl1 - $rl2;
			$structureAndRoutine = $rt1 - $rt2;
			$expectation = $sx1 - $sx2;
			$parentAnxity = $pc1 - $pc2;
			$parentJoy = $pjoy1 - $po;
			$autonomy = $hands1 - $ph;
			$selfRegulation = $parentCalm - $py;
			//calculate the result for graph and snapshot summary
				$grd = array("Quiz Taken");
				$emp_attune = (($ed1+$play1+$pt1+$ex1+$po) - ($ed2+$play2+$pt2+$ex2+$pc2))/5;
				$struc_control = (($rl1+$rt1+$sx1) - ($rl2+$rt2+$sx2))/3;
				$arg['emp_attune'] = $emp_attune;
				$arg['struc_control'] = $struc_control;
				if(((($emp_attune < 0)AND($emp_attune > -2)) AND ($struc_control > 2)) OR (($emp_attune < -2) AND ($struc_control >= 0))){
						//snapshot cluster authoritarian
						$arg['snapshot_cluster_1'] = "5y9nTY5HvdopyYZ0LDJ5YS";
						array_push($grd,"Authoritarian");
						
					}if(($emp_attune > 0) AND ($struc_control > 2)){
						//helicoptor
						$arg['snapshot_cluster_2'] = "4BrIeO90P3EZtFYPbWVPrO";
						array_push($grd,"Helicopter");
						
						
					}if(($emp_attune >= 0) AND ($struc_control < -2)){
						//permissive
						$arg['snapshot_cluster_3'] = "2rBbftDecoC0K708ZKbMod";
						array_push($grd,"Permissive");
						
					}if((( -2 <= $emp_attune) AND ($emp_attune <= 2)) AND ((-2 <= $struc_control ) AND ($struc_control <= 2) )){
						//average 
						$arg['snapshot_cluster_4'] = "1OYviLzisEjJPSps5oN1xn";
						array_push($grd,"Average");
						
					}
					if(( $emp_attune >= 2) AND  ((-2 <= $struc_control ) AND ($struc_control <= 2) )){
						//secure
						$arg['snapshot_cluster_5'] = "7ahdG77Z26novrxHxGIQ8N";
						array_push($grd,"Secure");
						
						
					}if((( $emp_attune < -2) AND ($struc_control < 0) ) OR ((($emp_attune < 0)AND($emp_attune > -2)) AND ($struc_control < -2))){
						  //Undersupported	
							$arg['snapshot_cluster_6'] = "7G2lqT04XKuaFNBaNEQ6C6";
							array_push($grd,"Undersupported");
							
						}
			//code ends here
			if($selfRegulation >= 4){
				$arg['self_regulation'] = "3Og5C7egX5aane07cb8kBC"; 
			}elseif(($selfRegulation < 4) && ($selfRegulation > -4)){
					$arg['self_regulation'] = "3bSYhpdzooh845DHGI6qKZ";
				}else{
						$arg['self_regulation'] = "5S9np6Rjxf7MVeTXWJbVA1";
					}
			if($perspectiveTaking >= 4){
					$arg['perspective_taking'] = "2bWYeg5KEEIvBX5vle5AwM"; 
				}elseif(($perspectiveTaking < 4) && ($perspectiveTaking > -4)){
						$arg['perspective_taking'] = "76mEGboRzI3JnknZn17nXo";
					}else{
							$arg['perspective_taking'] = "6GNEJOSR9CLb1bXfnfStdc";
						}
			if($parentJoy >= 4){
				$arg['parent_joy'] = "36pP5ULyU7vqLwiA8v4eZl"; 
			}elseif(($parentJoy < 4) && ($parentJoy > -4)){
					$arg['parent_joy'] = "5aqFIZ51FOivROBBqfVNsp";
				}else{
						$arg['parent_joy'] = "1C9ZbEs3sdQTaEezs5krKL";
					}
			if($autonomy >= 4){
				$arg['autonomy'] = "iPKahTaaxyu4ZwETZdKj4"; 
			}elseif(($autonomy < 4) && ($autonomy > -4)){
					$arg['autonomy'] = "6aPiKkWZ4ck5n30hfbbWHU";
				}else{
						$arg['autonomy'] = "27rfvURtHw17qHreUC48Er";
					}
			if($playTime >= 4){
					$arg['play_and_time'] = "6EhgJU9BVadm33p4FmzeCR";
				}elseif(($playTime < 4) && ($playTime > -4)){
						$arg['play_and_time'] = "zVBZmpvmbNqgRPdwl5sh3";
					}else{
							$arg['play_and_time'] = "D9FeMkfUb57geqzXpoSYJ";
						}
			if($democratic >= 4){
					$arg['democratic'] = "4qvMwWsiCcI8nwllLVKdQ9";
				}elseif(($democratic < 4) && ($democratic > -4)){
						$arg['democratic'] = "26X5Dq7nNwCStnS1cAwXok";
					}else{
							$arg['democratic'] = "440kOp9eMmLNqsJRhmN0MZ";
						}
			if($positiveCommunication >= 4){
					$arg['positive_communication'] = "4KWZdal141uiQYDDw8GgBR";
				}elseif(($positiveCommunication < 4) && ($positiveCommunication > -4)){
						$arg['positive_communication'] = "70Kl85Bs4xUqfr0gH4AC42";
					}else{
							$arg['positive_communication'] = "4E70pd6RDkCU9grf4DJdxx";
						}
			if($settingLimits >= 4){
					$arg['setting_limits'] = "4el6FWH5zP5AM3IZsOKayj";
				}elseif(($settingLimits < 4) && ($settingLimits > -4)){
						$arg['setting_limits'] = "1n1Bs3NRQLKCAKFg9TLgjK";
					}else{
							$arg['setting_limits'] = "2IUfkqYIU9N4ummKdDgPVK";
						}
			if($structureAndRoutine >= 4){
					$arg['structure_and_routine'] = "5cJ6UtFZNVD6MCXSis3b5G";
				}elseif(($structureAndRoutine < 4) && ($structureAndRoutine > -4)){
						$arg['structure_and_routine'] = "Q8yEqkDZ5tTVP10HF70ay";
					}else{
							$arg['structure_and_routine'] = "1aowuf30MtNMH4ZLdOsqhF";
						}
			if($expectation >= 4){
					$arg['expectation'] = "3JWJIDDFngEBGV0qMJ6bBn";
				}elseif(($expectation < 4) && ($expectation > -4)){
						$arg['expectation'] = "7krwgDQUat9E2cKeSIV9X4";
					}else{
							$arg['expectation'] = "1KD4d2EKPd0KTwozHqltxY";
						}
			if($parentAnxity >= 4){
					$arg['parent_anxity'] = "42fBCnPdHimNJ4fOlTSfF5";
				}elseif(($parentAnxity < 4) && ($parentAnxity > -4)){
						$arg['parent_anxity'] = "qnTy2sYD7ZwWMw8E2KT6X";
					}else{
							$arg['parent_anxity'] = "2rvlyshYvut6cjC57VzDiY";
						}
			$A = $py + $sa;
			$B = $ph + $sx1;
			$C = $parentCalm + $ed1;
			$D = $pe + $po;
			$max = max($A,$B,$C,$D);
			if($max == $A){
					$arg['parent_stress_response'] = "4kIqI9y3ZOLN5y3MV4JWZg";
				
				}elseif($max==$B){
					$arg['parent_stress_response'] = "73YCGLaUvkmAiSVyMKoBb2";
					
					}elseif($max==$C){
						$arg['parent_stress_response'] = "5XlqezGxdbarnjo1EFMrpg";
						}else{
							$arg['parent_stress_response'] = "6dhC3B7YF8sGB0iO39cVXP";
							}
			$userquiz = new UserQuiz;
			
			if (Auth::guard('user')
            ->check())
			{
				$user_auth = Auth::guard('user')->user();
				$userquiz->user_id = $user_auth->id;
				$name = explode(" ",$user_auth->name);
				$fname = $name[0];
				$lname = $name[1];
				$email = $user_auth->email;
				$grade = '4';
				$arg['login'] = "loggedin";
			}
			else
			{
				$userquiz->user_id = Null;
				$arg['login'] = "notloggedin";
			}
			$userquiz->user_name = $fname." ".$lname;
			$userquiz->user_email = $email;
			$userquiz->grade = $grade;
			$userquiz->results = json_encode($arg);
			$userquiz->response = json_encode($arg);
			$userquiz->save();
			
			$this->SendSignupMail($email,$fname,$lname,$grd);
        return response()->json($arg);
    }
     
    //update mailchimp record on the basis of results
    
    public function SendSignupMail( $email,$fname,$lname,$grade)
    {
        
        $MailChimp = Newsletter::getApi();
         
        $return=Newsletter::getMember($email,'list3');
        
        if ($return['status'] !='404') {

            foreach ($return['tags'] as $tag) {
                $tag_num=$tag['name'];
                if(!is_numeric($tag_num))
                {
				if(in_array($tag_num,$grade,true)){
						$old_tags[]=[
						'name'=>$tag_num,
						'status' => 'inactive'
						];
					
					}
              }
            }
            $subscriber_hash=md5(strtolower($email));
       
            $tag_url="lists/d2ae77bf0e/members/$subscriber_hash/tags";
           if(!empty($old_tags)){
            
            
            $remove_tags=['tags'=>$old_tags];
            
            $remove=$MailChimp->post($tag_url,$remove_tags);
           }
    
           foreach ($grade as $gd) {
            $new_tags[]=[
            'name'=>$gd,
            'status' => 'active'
            ];
          }
    
            $add_tags=['tags'=>$new_tags];
            
            $add=$MailChimp->post($tag_url,$add_tags);
    
           
            Newsletter::subscribeOrUpdate($email, ['FNAME'=>$fname, 'LNAME'=>$lname], 'list3');
         
    




        }else{
            $argd = Newsletter::subscribeOrUpdate($email, ['FNAME'=>$fname, 'LNAME'=>$lname], 'list3' , ['tags' => $grade]);
			print_r($argd);
        }
      



    }


    

}
