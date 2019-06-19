<?php

namespace App\Http\Controllers;

use App\Category;
use App\Services\PaymentService;
use App\Order;
use App\view\ChartHistory;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        if (!Auth::check()) {
            return redirect()->route('login');
        } else {
            if (Cart::content()->count() == 0) {
                return redirect()->route('home');
            }
        }

        $data         = [];
        $categoryMenu = Category::orderBy('category_name', 'asc')->get();
        $chartHistory = ChartHistory::where('user_id','=', Auth::user()->id)->where('basket_id', session('active_basket_id'))->get();
        $user_detail  = Auth::user()->detail;
        $user         = Auth::user();
        $order        = Cart::total();
        $random       = rand(1, 10000);

        $data["user_detail"]  = $user_detail;
        $data["user"]         = $user;
        $data["order"]        = $order;
        $data["categoryMenu"] = $categoryMenu;
        $data["chartHistory"] = $chartHistory;

        session()->put('order_no', $random);


        $service = new PaymentService();
        $form                   = [];
        $form['sessionOrderNo'] = session('order_no');
        $form['orderPrice']     = $order;
        $form['basketID']       = session('active_basket_id');
        $form['route']          = 'pay';
        $form['userID']         = Auth::id();
        $form['name']           = Auth::user()->name;
        $form['surname']        = Auth::user()->surname;
        $form['phone']          = Auth::user()->detail->phone;
        $form['email']          = Auth::user()->email;
        $form['city']           = Auth::user()->detail->city;
        $form['country']        = Auth::user()->detail->country;
        $form['zipcode']        = Auth::user()->detail->zipcode;
        $form['address']        = Auth::user()->detail->address;

        $data['getFormContent'] = $service->IyzicoForm($form);
        $service->IyzicoForm($form);

        $categories = Category::orderBy('category_name','asc')->get();

        return view('payment')->with($data);
        // return view('payment', compact('data'));
    }

    // public function pay()
    // {

    //     $token   = session('_token');
    //     $orderNo = session('order_no');

    //     $pay = new PaymentService();
    //     $pay->IyzicoRequest($orderNo, $token);

    //     $order                   = [];
    //     $order['name']           = Auth::user()->name.' '.Auth::user()->surname;
    //     $order['address']        = Auth::user()->detail->address;
    //     $order['phone']          = Auth::user()->detail->phone;
    //     $order['m_phone']        = Auth::user()->detail->m_phone;
    //     $order['basket_id']      = session('active_basket_id');
    //     $order['user_id']        = Auth::id();
    //     $order['installments']   = 1;
    //     $order['status']         = "Your order has been received";
    //     $order['payment_method'] = "Credit Cart";
    //     $order['order_price']    = Cart::total();
    //     $order['token']          = $token;
    //     $order['order_no']       = session('order_no');


    //     Order::create($order);
    //     Cart::destroy();
    //     session()->forget('active_basket_id');
    //     session()->forget('order_no');

    //     Session::flash("status", 2);

    //     return redirect()->route('orders');
    // }

    public function handleonlinepay(Request $request){  
        
        // $input = $request->input();
        $chartHistory = ChartHistory::where('user_id','=', Auth::user()->id)->where('basket_id', session('active_basket_id'))->get();
        try {
            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
                
            
            $unique_id = uniqid(); // just for tracking purpose incase you want to describe something.

            foreach($chartHistory as $productCartItem){
        
                // Charge to customer
                $charge = \Stripe\Charge::create(array(
                    'description' => "Product Name: ".$productCartItem->product_name." - Amount: ".number_format($productCartItem->total).' - '. $unique_id,
                    'source' => $request->stripeToken,                    
                    'amount' => (int)(($productCartItem->total/14000) * 100), // the mount will be consider as cent so we need to multiply with 100
                    'currency' => 'USD'
                ));

                $token   = session('_token');
                $orderNo = session('order_no');

                $pay = new PaymentService();
                $pay->IyzicoRequest($orderNo, $token);

                $order                   = [];
                $order['name']           = Auth::user()->name.' '.Auth::user()->surname;
                $order['address']        = Auth::user()->detail->address;
                $order['phone']          = Auth::user()->detail->phone;
                $order['m_phone']        = Auth::user()->detail->m_phone;
                $order['basket_id']      = session('active_basket_id');
                $order['user_id']        = Auth::id();
                $order['charge_id']      = $charge->id;
                $order['stripe_id']      = $unique_id;
                $order['status']         = "Your order has been received";
                $order['payment_method'] = "Credit Cart";
                $order['order_price']    = $productCartItem->total;
                $order['token']          = $token;
                $order['order_no']       = session('order_no');


                Order::create($order);
                Cart::destroy();
                session()->forget('active_basket_id');
                session()->forget('order_no');
            }

            

            // Session::flash("status", 2);

            // return redirect()->route('orders');

            

            return response()->json([
                'message' => 'Charge successful, Thank you for payment!',
                'state' => 'success'
            ]);                
        } catch (\Exception $ex) {
            return response()->json([
                'message' => 'There were some issue with the payment. Please try again later.',
                'state' => 'error'
            ]);
        }             
                
    }
}
