<?php
 
namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use Omnipay\Omnipay;
use Contentful\Delivery\Client as DeliveryClient;
use jazmy\FormBuilder\Models\Form;
use Monarobase\CountryList\CountryListFacade;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client as GuzzleClient;

class PaymentController extends Controller
{
 
    public $gateway;
	private $client;
    public function __construct(DeliveryClient $client)
    {
		$this->client = $client;
		$this->renderer = new \Contentful\RichText\Renderer();
		$this->query = new \Contentful\Delivery\Query();
        $credentials = base64_encode(env('PAYPAL_SANDBOX_API_APPID').":".env('PAYPAL_SANDBOX_API_SECRET'));
		$headers = [
			'Authorization' => 'Basic '.$credentials,
			'Content-Type' => 'application/x-www-form-urlencoded'
			];
			$endpoint = "https://api-m.sandbox.paypal.com/v1/oauth2/token";
			$newclient = new GuzzleClient([
				'headers' => $headers
			]);
			
			$r = $newclient->request('POST', $endpoint, ['body'=> "grant_type=client_credentials"]);
			$response = $r->getBody()->getContents();
			$results = json_decode($response);
			$this->token = $results->access_token;
			$this->allheader = [
				'Authorization' => 'Bearer '.$this->token,
				'Content-Type' => 'application/json',
				'Accept' => 'application/json',
				'PayPal-Request-Id' => 'SUBSCRIPTION-21092019-001',
				'Prefer' => "return=representation",


				];
			$this->newclient = new GuzzleClient([
					'headers' => $this->allheader
				]);
         $this->form2 = Form::where('identifier', 'signup')
            ->firstOrFail();
        $this->form1 = Form::where('identifier', 'form1')
            ->firstOrFail();
    }
	public function create_product(){
		// create subscription product
			$endpoint = 'https://api-m.sandbox.paypal.com/v1/catalogs/products';
			$body = array(
				"name" => "Postcards For Free",
				"description" => "Get postcards for free by subscribing its monthly and annual plan",
				"type" => "SERVICE",
				"category" => "SOFTWARE",
				"image_url" => "http://148.75.76.204/postscards/public",
				"home_url" => "http://148.75.76.204/postscards/public"
			);
			$r = $this->newclient->request('POST', $endpoint, ['body'=> json_encode($body)]);
			$response = $r->getBody()->getContents();
			$results = json_decode($response);
			$insertedData = [
				'prod_id' => $results->id,
				'prod_name'=>$results->name,
				'description'=>$results->description
			];
	
			$id = DB::table('manage_product')->insertGetId($insertedData);
			return $id;
	}
	public function create_plan(){
		//create subscription plan
		$query2 = $this->query->setContentType("productOffer");
		
        $entries_pre2 = $this->client->getEntries($query2);
        $entrys = $entries_pre2[0];
		


		$endpoint = 'https://api-m.sandbox.paypal.com/v1/billing/plans';
			$body = '{
				"product_id": "PROD-2WD19693HS166435Y",
				"name": "'.$entrys->priceYearlyLabel.'",
				"description": "'.$entrys->priceYearlyLabel.' First month free",
				"billing_cycles": [
				  {
					"frequency": {
					  "interval_unit": "MONTH",
					  "interval_count": 1
					},
					"tenure_type": "TRIAL",
					"sequence": 1,
					"total_cycles": 1
				  },
				  {
					"frequency": {
					  "interval_unit": "YEAR",
					  "interval_count": 1
					},
					"tenure_type": "REGULAR",
					"sequence": 2,
					"total_cycles": 12,
					"pricing_scheme": {
					  "fixed_price": {
						"value": "'.$entrys->priceYearly.'",
						"currency_code": "USD"
					  }
					}
				  }
				],
				"payment_preferences": {
				  "auto_bill_outstanding": true,
				  "setup_fee": {
					"value": "0.5",
					"currency_code": "USD"
				  },
				  "setup_fee_failure_action": "CONTINUE",
				  "payment_failure_threshold": 3
				},
				"taxes": {
				  "percentage": "0.5",
				  "inclusive": false
				}
			  }';
			//echo $body; exit;
			//$r = $this->newclient->request('POST', $endpoint, ['body'=> $body]);
			//$response = $r->getBody()->getContents();
			//$results[] = json_decode($response); exit;
			//$endpoint = 'https://api-m.sandbox.paypal.com/v1/billing/plans';
			$body = '{
				"product_id": "PROD-2WD19693HS166435Y",
				"name": "'.$entrys->priceMonthlyLabel.'",
				"description": "'.$entrys->priceMonthlyLabel.' First month free",
				"billing_cycles": [
				  {
					"frequency": {
					  "interval_unit": "MONTH",
					  "interval_count": 1
					},
					"tenure_type": "TRIAL",
					"sequence": 1,
					"total_cycles": 1
				  },
				  {
					"frequency": {
					  "interval_unit": "MONTH",
					  "interval_count": 1
					},
					"tenure_type": "REGULAR",
					"sequence": 2,
					"total_cycles": 12,
					"pricing_scheme": {
					  "fixed_price": {
						"value": "'.$entrys->priceMonthy.'",
						"currency_code": "USD"
					  }
					}
				  }
				],
				"payment_preferences": {
				  "auto_bill_outstanding": true,
				  "setup_fee": {
					"value": "0.5",
					"currency_code": "USD"
				  },
				  "setup_fee_failure_action": "CONTINUE",
				  "payment_failure_threshold": 3
				},
				"taxes": {
				  "percentage": "0.5",
				  "inclusive": false
				}
			  }';
			//$r = $this->newclient->request('POST', $endpoint, ['body'=> $body]);
			//$response = $r->getBody()->getContents();
			//$results[] = json_decode($response);
			
			echo "<pre>"; print_r($results); echo "</pre>"; exit;
	}
	public function list_plan(){
		$endpoint = 'https://api-m.sandbox.paypal.com/v1/billing/plans?page_size=10&page=1&total_required=true&status=active';
		$body = '';
		$r = $this->newclient->request('GET', $endpoint, ['body'=> $body]);
		$response = $r->getBody()->getContents();
		$results = json_decode($response)->plans;
		foreach($results as $res){
			$arg = array(
				'plan_id' => $res->id,
				'plan_name' => $res->name,
				'plan_status' => $res->status,
				'plan_description' => $res->description,
				'price' => "0.00"
			);
			//$id = DB::table('manage_plans')->insertGetId($arg);
		}
		print_r($arg);
		
	}
    public function index()
    { 
		
		$arg = DB::table('manage_plans')->get()->toArray();
		
		$countries = CountryListFacade::getList('en');
		$form2 = $this->form2;
        $form1 = $this->form1;
        return view('user_panel.payment',compact('form2','form1','countries','arg'))->with('client', $this->client)->with('renderer',$this->renderer);
    }
 
    public function store(Request $request)
    {
        
		$number = $request->input('cardnumber');
		$name = $request->input('nameoncard');
		$expmon = $request->input('month');
		$expyear = $request->input('year');
		$cvv = $request->input('cvv');
		$planid = $request->input('offer_name');
		$address = $request->input('address');
		$country = $request->input('country');
		$city = $request->input('city');
		$state = $request->input('state');
		$zip = $request->input('zipcode');
		$names = explode(' ',$name);
        
 
        try {
            // Send purchase request
			$endpoint = 'https://api-m.sandbox.paypal.com/v1/billing/subscriptions';
			$body = '{
				"plan_id":"'.$planid.'",
				"start_time": "2021-05-04T00:00:00Z",
				"shipping_amount":{
				   "currency_code":"USD",
				   "value":"10.99"
				},
				"subscriber":{
				   "name":{
					  "given_name":"John",
					  "surname":"Doe"
				   },
				   "email_address":"raman@sourcesoftsolutions.com",
				   "shipping_address":{
					  "name":{
						 "full_name":"Raman Tripathi"
					  },
					  "address":{
						 "address_line_1":"2211 N First Street",
						 "address_line_2":"Building 17",
						 "admin_area_2":"San Jose",
						 "admin_area_1":"CA",
						 "postal_code":"95131",
						 "country_code":"US"
					  }
				   },
				   "payment_source":{
					  "card":{
						 "number":"4032038443105105",
						 "expiry":"2024-08",
						 "security_code":"549",
						 "name":"Raman Tripathi",
						 "billing_address":{
							"address_line_1":"2211 N First Street",
							"address_line_2":"17.3.160",
							"admin_area_1":"CA",
							"admin_area_2":"San Jose",
							"postal_code":"95131",
							"country_code":"US"
						 }
					  }
				   }
				}
			 }';
			 
			 $body = json_decode($body);
			 
			 echo $this->token; exit;
			$r = $this->newclient->request('POST', $endpoint, ['body'=> json_encode($body)]);
			$response = $r->getBody()->getContents();
			$results[] = json_decode($response);
			dd($results); ; 
			
            if ($response->isSuccessful()) {
		 $data = $response->getData();
         $user_auth = Auth::guard('user')->user();
        // dd($user_auth);
        $userId = $user_auth->id;
        $userName = $user_auth->name;
        $userEmail = $user_auth->email;
        $title = "Trial Period For 1 Month";
        $amount = 1;
        //$qty = $request->input('Qty');
        //$desc = $request->input('Desc');
        $invoiceId = uniqid();
        $invoiceDesc = "Offer #{$invoiceId} Invoice";
        
        $insertedData = [
            'user_id'        => $userId,
            'user_name'      => $userName,
            'user_email'     => $userEmail,
            'offer_name'     => $title,
            'offer_amount'   => $amount,
            'offer_qty'      => 1,
            'offer_desc'     => "Trial Period",
            'invoice_id'     => $invoiceId,
            'invoice_desc'   => $invoiceDesc,
            'transaction_id'     => $data['TRANSACTIONID'],
            'payment_status'     => "PAID"
        ];

        $id = DB::table('offer_payemnt_tbl')->insertGetId($insertedData);
 
                return  redirect('/quiz'); 
            } else {
                // Payment failed
                echo "Payment failed. ". $response->getMessage();
            }
        } catch(\Exception $e) {
			return \Redirect::back()->withErrors(['error', $e->getMessage()]);
            
        }
    }
}
