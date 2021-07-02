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
use Illuminate\Support\Facades\Mail;

class PaymentController extends Controller
{

	public $gateway;
	private $client;
	public function __construct(DeliveryClient $client)
	{
		$this->client = $client;
		$this->renderer = new \Contentful\RichText\Renderer();
		$this->query = new \Contentful\Delivery\Query();
		$credentials = base64_encode(env('PAYPAL_SANDBOX_API_APPID') . ":" . env('PAYPAL_SANDBOX_API_SECRET'));
		$headers = [
			'Authorization' => 'Basic ' . $credentials,
			'Content-Type' => 'application/x-www-form-urlencoded'
		];
		$endpoint = "https://api-m.paypal.com/v1/oauth2/token";
		$newclient = new GuzzleClient([
			'headers' => $headers
		]);

		$r = $newclient->request('POST', $endpoint, ['body' => "grant_type=client_credentials"]);
		$response = $r->getBody()->getContents();
		$results = json_decode($response);
		$this->token = $results->access_token;
		$this->allheader = [
			'Authorization' => 'Bearer ' . $this->token,
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
	public function create_product()
	{
		// create subscription product
		$endpoint = 'https://api-m.paypal.com/v1/catalogs/products';
		$body = array(
			"name" => "Postcards For Free",
			"description" => "Get postcards for free by subscribing its monthly and annual plan",
			"type" => "SERVICE",
			"category" => "SOFTWARE",
			"image_url" => "https://postcardsforparents.com/",
			"home_url" => "https://postcardsforparents.com/"
		);
		$r = $this->newclient->request('POST', $endpoint, ['body' => json_encode($body)]);
		$response = $r->getBody()->getContents();
		$results = json_decode($response);
		$insertedData = [
			'prod_id' => $results->id,
			'prod_name' => $results->name,
			'description' => $results->description
		];

		$id = DB::table('manage_product')->insertGetId($insertedData);
		return $id;
	}
	public function create_plan()
	{
		//create subscription plan
		$query2 = $this->query->setContentType("productOffer");

		$entries_pre2 = $this->client->getEntries($query2);
		$entrys = $entries_pre2[0];


		$endpoint = 'https://api-m.paypal.com/v1/billing/plans';
		$bodys = '{
				"product_id": "PROD-5BM20287KR617335V",
				"name": "' . $entrys->priceYearlyLabel . '",
				"description": "' . $entrys->priceYearlyLabel . ' ",
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
						"value": "' . $entrys->priceYearly . '",
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
		//$results[] = json_decode($response); exit;
		$endpoint = 'https://api-m.paypal.com/v1/payments/billing-plans';
		$body = '{
				"product_id": "PROD-5BM20287KR617335V",
				"name": "' . $entrys->priceMonthlyLabel . '",
				"description": "' . $entrys->priceMonthlyLabel . ' First month free",
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
						"value": "' . $entrys->priceMonthy . '",
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

		$r = $this->newclient->request('POST', $endpoint, ['body' => $body]);
		$response = $r->getBody()->getContents();
		$results[] = json_decode($response);

		echo "<pre>";
		print_r($results);
		echo "</pre>";
		exit;
	}
	public function list_plan()
	{
		$endpoint = 'https://api-m.paypal.com/v1/billing/plans?page_size=10&page=1&total_required=true&status=active';
		$body = '';
		$r = $this->newclient->request('GET', $endpoint, ['body' => $body]);
		$response = $r->getBody()->getContents();
		$results = json_decode($response)->plans;
		unset($results[0]);
		unset($results[5]);

		foreach ($results as $res) {
			$arg = array(
				'plan_id' => $res->id,
				'plan_name' => $res->name,
				'plan_status' => $res->status,
				'plan_description' => $res->description,
				'price' => "0.00"
			);
			$id = DB::table('manage_plans')->insertGetId($arg);
		}
		echo '<pre>';
		print_r($results);
	}
	public function index()
	{
		/*$query2 = $this->query->setContentType("additionalEmails")->where('sys.id','64EdnPdIMB1GKeCB5F30py');
					$entries_pre2 = $this->client->getEntries($query2);
					$entrys = $entries_pre2[0];
					echo '<pre>'; print_r($entrys); exit; */
		//  dd($this->form2, $this->form1,$this->client,$this->renderer);
		$arg = DB::table('manage_plans')->where('coupon_code', NULL)->get()->toArray();
		//$fname = "raman";
		$countries = CountryListFacade::getList('en');
		$form2 = $this->form2;
		$form1 = $this->form1;
		return view('user_panel.payment', compact('form2', 'form1', 'countries', 'arg'))->with('client', $this->client)->with('renderer', $this->renderer);
		//return view('mailer.checkwelcom',compact('form2','form1','fname','entrys'))->with('client', $this->client)->with('renderer',$this->renderer);
	}
	public function couponcheck(Request $request)
	{
		$cpn = $request->input('coupon');
		$id = DB::table('manage_plans')->where('coupon_code', $cpn)->get()->toArray();
		if (!empty($id)) {
			$arg['success'] = true;
			$arg['data'] = ($id);
		} else {
			$arg['success'] = false;
			$arg['data'] = '';
		}
		echo json_encode($arg);
		exit;
	}
	public function store(Request $request)
	{

		if (Auth::guard('user')
			->check()
		) {
			$user_auth = Auth::guard('user')->user();
			$user_id = $user_auth->id;

			$email = $user_auth->email;
		}
		// dd(Auth::guard('user')->user());
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
		$names = explode(' ', $name);

		// try {
		// Send purchase request
		$endpoint = 'https://api-m.paypal.com/v1/billing/subscriptions';
		// $array = array(
		// 	'plan_id' => $planid,
		// 	'start_time' => date('Y-m-d', strtotime(" + 1 Day")) . 'T' . date('H:i:s') . 'Z',
		// 	'shipping_amount' =>
		// 	array(
		// 		'currency_code' => 'USD',
		// 		'value' => '0',
		// 	),
		// 	'subscriber' =>
		// 	array(
		// 		'name' =>
		// 		array(
		// 			'given_name' => (isset($names[0]) ? $names[0] : $request->input('nameoncard')),
		// 			'surname' => (isset($names[1]) ? $names[1] : ''),
		// 		),
		// 		'email_address' => $email,
		// 		'shipping_address' =>
		// 		array(
		// 			'name' =>
		// 			array(
		// 				'full_name' => $name,
		// 			),
		// 			'address' =>
		// 			array(
		// 				'address_line_1' => $address,
		// 				'address_line_2' => '',
		// 				'admin_area_2' => $city,
		// 				'admin_area_1' => $state,
		// 				'postal_code' => $zip,
		// 				'country_code' => $country,
		// 			),
		// 		),
		// 		'payment_source' =>
		// 		array(
		// 			'card' =>
		// 			array(
		// 				'number' => $number,
		// 				'expiry' => $expyear - $expmon,
		// 				'security_code' => $cvv,
		// 				'name' => $name,
		// 				'billing_address' =>
		// 				array(
		// 					'address_line_1' => $address,
		// 					'address_line_2' => '',
		// 					'admin_area_2' => $city,
		// 					'admin_area_1' => $state,
		// 					'postal_code' => $zip,
		// 					'country_code' => $country,
		// 				),
		// 			),
		// 		),
		// 	),
		// );
		$body = '{
				"plan_id":"' . $planid . '",
				"start_time": "' . date('Y-m-d', strtotime(" + 1 Day")) . 'T' . date('H:i:s') . 'Z",
				"shipping_amount":{
				   "currency_code":"USD",
				   "value":"0"
				},
				"subscriber":{
				   "name":{
					   "given_name":"' . (isset($names[0]) ? $names[0] : $request->input('nameoncard')) . '",
					   "surname":"' . (isset($names[1]) ? $names[1] : '') . '"
					},
					"email_address":"' . $email . '",
				   "shipping_address":{
					   "name":{
						   "full_name":"' . $name . '"
						},
					  "address":{
						  "address_line_1":"' . $address . '",
						  "address_line_2":"",
						  "admin_area_2":"' . $city . '",
						 "admin_area_1":"' . $state . '",
						 "postal_code":"' . $zip . '",
						 "country_code":"' . $country . '"
						}
				   },
				   "payment_source":{
					  "card":{
						 "number":"' . $number . '",
						 "expiry":"' . $expyear . '-' . $expmon . '",
						 "security_code":"' . $cvv . '",
						 "name":"' . $name . '",
						 "billing_address":{
							 "address_line_1":"' . $address . '",
							"address_line_2":"",
							"admin_area_2":"' . $city . '",
							"admin_area_1":"' . $state . '",
							"postal_code":"' . $zip . '",
							"country_code":"' . $country . '"
						}
					}
				}
			}
		}';

		try {
			$r = $this->newclient->request('POST', $endpoint, ['body' => $body]);
			$response = $r->getBody()->getContents();
			$response = json_decode($response);
			if ($response->status == 'ACTIVE') {
				$user_auth = Auth::guard('user')->user();
				$userId = $user_auth->id;
				$userName = $user_auth->name;
				$userEmail = $user_auth->email;



				$insertedData = [
					'user_id'        => $userId,
					'user_name'      => $name,
					'user_email'     => $userEmail,
					'card_number'     => $number,
					'card_cvv'   =>  $cvv,
					'expiry_month'     => $expmon,
					'expiry_year'     => $expyear,
					'subscription_id' => $response->id,
					'plan_id' => $response->plan_id,
					'start_time' => $response->start_time,
					'address' => $address,
					'city' => $city,
					'state' => $state,
					'country' => $country,
					'zip_code' => $zip
				];

				$id = DB::table('offer_payemnt_tbl')->insertGetId($insertedData);


				$query2 = $this->query->setContentType("additionalEmails")->where('sys.id', '4Zyq6tgjoRMjUHx77659Jy');
				$entries_pre2 = $this->client->getEntries($query2);
				$entrys = $entries_pre2[0];
				$emailSubjectLine = $entrys->emailSubject;
				Mail::send('mailer.newsub', ["entrys" => $entrys, 'fname' => $names[0]], function ($message) use ($email, $emailSubjectLine) {

					$message->to($email)->subject($emailSubjectLine);
				});

				return redirect('/thank-you');
			} else {
				// Payment failed
				echo "Payment failed. " . $response->getMessage();
			}
		} catch (\Exception $e) {
			return \Redirect::back()->withErrors(['error', $e->getMessage()]);
		}
	}
}
