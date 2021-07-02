<?php

namespace App\Http\Controllers\Auth;
use DB;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Contentful\Delivery\Client as DeliveryClient;
use jazmy\FormBuilder\Models\Form;
use Monarobase\CountryList\CountryListFacade;
use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Support\Facades\Session;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';
    public $gateway;
	private $client;
    /**
     * Create a new controller instance.
     *
     * @return void
     */    
    public function __construct(DeliveryClient $client)
    {
        $this->middleware('guest');
		$this->client = $client;
      
		$this->renderer = new \Contentful\RichText\Renderer();
     
		$this->query = new \Contentful\Delivery\Query();
       
        $credentials = base64_encode(env('PAYPAL_SANDBOX_API_APPID').":".env('PAYPAL_SANDBOX_API_SECRET'));
		$headers = [
			'Authorization' => 'Basic '.$credentials,
			'Content-Type' => 'application/x-www-form-urlencoded'
			];
			$endpoint = "https://api-m.paypal.com/v1/oauth2/token";
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
      //dd($this->form1,$this->form2);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

   public function showRegistrationForm()
    {
      	
        $arg = DB::table('manage_plans')->where('coupon_code',NULL)->get()->toArray();
      
		//$fname = "raman";
		$countries = CountryListFacade::getList('en');
      //dd($countries);
		$form2 = $this->form2;
        $form1 = $this->form1;
      //dd($this->client,$this->renderer);
        return view('auth.register',compact('form2','form1','countries','arg'))->with('client', $this->client)->with('renderer',$this->renderer);
    }

}
