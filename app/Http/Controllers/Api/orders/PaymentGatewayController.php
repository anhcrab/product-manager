<?php

namespace App\Http\Controllers\Api\orders;

use App\Http\Controllers\Controller;
use App\Models\Order\Order;
use Illuminate\Http\Request;

class PaymentGatewayController extends Controller
{
    public function vnPay ()
    {
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "https://localhost/vnpay_php/vnpay_return.php";
        $vnp_TmnCode = "3WRQPN2B";//Mã website tại VNPAY
        $vnp_HashSecret = "SJPMIQDQKSXPXKCZZOSNUAJLDLFSVAJP"; //Chuỗi bí mật

        $vnp_TxnRef = '10000'; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = 'Thanh toán hóa đơn ';
        $vnp_OrderType = 'shop';
        $vnp_Amount = 150000 * 100;
        $vnp_Locale = 'VN';
        $vnp_BankCode = 'NCB';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }

        //var_dump($inputData);
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        $returnData = array('code' => '00'
        , 'message' => 'success'
        , 'data' => $vnp_Url);
        if (isset($_POST['redirect'])) {
            header('Location: ' . $vnp_Url);
            die();
        } else {
            echo json_encode($returnData);
        }
        // vui lòng tham khảo thêm tại code demo
    }

    public function paypalStore(Request $request)
    {
        try {
            $order = Order::create([
                'products' => json_encode($request->products),
                'total_price' => $request->total_price,
                'device_id' => $request->user_device,
                'address' => $request->address,
                'fullname' => $request->fullname,
                'email' => $request->email,
                'phone' => $request->phone,
                'shipping_id' => $request->shipping_id,
                'payment_id' => $request->payment_id,
                'status' => $request->status == null ? 'accepted' : $request->status,
            ]);
            if($request->user_id){
                $order->user_id = $request->user_id;
                $order->save();
            }
            return response()->json($order, 200);
        } catch (\Throwable $err){
            return response()->json([
                'msg' => $err->getMessage()
            ]);
        }
    }

    public function paypalCapture(Request $request)
    {
        try {
            return response()->json(Order::findOrFail($request->order_id));
        } catch (\Throwable $th) {
            return response()->json([
                'msg' => $th->getMessage()
            ]);
        }
    }

    public function paypalShow()
    {

    }
}
