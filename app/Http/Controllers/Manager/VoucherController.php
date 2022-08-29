<?php

namespace App\Http\Controllers\Manager;

use App\AgentHasCommision;
use App\Detail;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Voucher;

class VoucherController extends Controller
{
    public function store(Request $request)
    {
        // dd($request->all());
        $voucher = new Voucher();
        $amtpaid=$request->amtpaid;
        $cmsAg=null;

        if($amtpaid==0){
        return ['status' => 'failed'];
        }
        $commision = AgentHasCommision::where([
            ['agent_id',$request->agent_id],
            ['kista_id',$request->kista_id],
        ])->first();

        if($commision){
            $cmsType= $commision->commission_type;
            // dd($cmsType);

        
        $cmsAmt= $commision -> commission;

        if($cmsType=="1"){
        $calcAmt= ($cmsAmt/100) * $amtpaid ;
        $cmsAg= ($request->amtpaid - $calcAmt);

        //  dd($cmsAg);
        $voucher->amt_ac = $cmsAg;
        $voucher->amtac_word=$this->convertNo($cmsAg);

        }

        if($cmsType=="2"){
            $paidclient=Detail::where([
                ['agent_id',$request->agent_id],
                ['kista_id',$request->kista_id],
                ['luckydraw_id',$request->luckydraw_id],
                ['lottery_status',2]
            ])->count();
            $calcAmt=($cmsAmt * $paidclient);
            $cmsAg= ($request->amtpaid - $calcAmt);

        $vccount=Voucher::count();

        $recp= '00'+ $vccount;

        $voucher->amtac_word=$this->convertNo($cmsAg);
        $voucher->amt_ac = $cmsAg;
        }
    }

    if(strtolower($request->type)=="default"){
        $voucher_check=Voucher::where([
            ['type',strtolower($request->type)],
            ['kista_id',$request->kista_id],
            ['luckydraw_id',$request->luckydraw_id],
            ['client_id',$request->client_id],
            ['amount_paid',$request->amtpaid]]);

            if($voucher_check->exists()){
                return ['status' => 'exists'];
            }
    }
    else{
        // $voucher->payment_type = $request->payment_type;
    }
    // $voucher->amt_ac = null;
        $voucher->amt_to_be_paid = $request->amt2bepaid;
        $voucher->amount_paid = $request->amtpaid;
        $voucher->amtpaid_word=$this->convertNo($amtpaid);
        $voucher->type = $request->type;
        $voucher->luckydraw_id = $request->luckydraw_id;
        $voucher->kista_id = $request->kista_id;
        $voucher->agent_id = $request->agent_id;
        $voucher->payment_type = $request->payment_type;
        $voucher->client_id = $request->client_id;
        $voucher->recp_no =  $this->IdGenerator(new Voucher,'recp_no',3,'PRD');
        $voucher->date = $request->date;
        $voucher->date_np = $this->helper->date_np_con_parm($request->date);
        $voucher->time = date("H:i:s");
        if ($voucher->save()) {
            return response()->json([
                'status' => 'success'
            ]);
        }
    }

    public function IdGenerator($model, $trow, $length, $prefix){
        $data = $model::orderBy('id', 'desc')-> first();
        if(!empty($data)){
            return $data->id + 1;

        }
        else{
            return 1;
        }

        //         $og_length =$length;
        //         $last_number = '';
        // }else{
        //     $code = substr($data-> $trow,strlen($prefix) + 1);
        //     $actual_last_number = ($code/1) + 1;
        //     $increment_last_number = $actual_last_number + 1;
        //     $last_number_length = strlen($increment_last_number);
        //     $og_length = $length - $last_number_length ;
        //     $last_number = $increment_last_number;
        // }
        // $zeros = "";
        // for($i = 0;$i < $og_length;$i++){
        //     $zeros.= "0";
        // }
        // return $zeros.$last_number;
    }

    public static function convertNo($number)
    {

        $hyphen      = '-';
        $conjunction = ' and ';
        $separator   = ', ';
        $negative    = 'negative ';
        $decimal     = ' point ';
        $dictionary  = array(
            0                   => 'zero',
            1                   => 'one',
            2                   => 'two',
            3                   => 'three',
            4                   => 'four',
            5                   => 'five',
            6                   => 'six',
            7                   => 'seven',
            8                   => 'eight',
            9                   => 'nine',
            10                  => 'ten',
            11                  => 'eleven',
            12                  => 'twelve',
            13                  => 'thirteen',
            14                  => 'fourteen',
            15                  => 'fifteen',
            16                  => 'sixteen',
            17                  => 'seventeen',
            18                  => 'eighteen',
            19                  => 'nineteen',
            20                  => 'twenty',
            30                  => 'thirty',
            40                  => 'fourty',
            50                  => 'fifty',
            60                  => 'sixty',
            70                  => 'seventy',
            80                  => 'eighty',
            90                  => 'ninety',
            100                 => 'hundred',
            1000                => 'thousand',
            1000000             => 'million',
            1000000000          => 'billion',
            1000000000000       => 'trillion',
            1000000000000000    => 'quadrillion',
            1000000000000000000 => 'quintillion'
        );

        if (!is_numeric($number)) {
            return false;
        }

        if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
            // overflow
            trigger_error(
                'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
                E_USER_WARNING
            );
            return false;
        }

        if ($number < 0) {
            return $negative . Self::convertNo(abs($number));
        }

        $string = $fraction = null;

        if (strpos($number, '.') !== false) {
            list($number, $fraction) = explode('.', $number);
        }

        switch (true) {
            case $number < 21:
                $string = $dictionary[$number];
                break;
            case $number < 100:
                $tens   = ((int) ($number / 10)) * 10;
                $units  = $number % 10;
                $string = $dictionary[$tens];
                if ($units) {
                    $string .= $hyphen . $dictionary[$units];
                }
                break;
            case $number < 1000:
                $hundreds  = $number / 100;
                $remainder = $number % 100;
                $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
                if ($remainder) {
                    $string .= $conjunction . Self::convertNo($remainder);
                }
                break;
            default:
                $baseUnit = pow(1000, floor(log($number, 1000)));
                $numBaseUnits = (int) ($number / $baseUnit);
                $remainder = $number % $baseUnit;
                $string = Self::convertNo($numBaseUnits) . ' ' . $dictionary[$baseUnit];
                if ($remainder) {
                    $string .= $remainder < 100 ? $conjunction : $separator;
                    $string .= Self::convertNo($remainder);
                }
                break;
        }

        if (null !== $fraction && is_numeric($fraction)) {
            $string .= $decimal;
            $words = array();
            foreach (str_split((string) $fraction) as $number) {
                $words[] = $dictionary[$number];
            }
            $string .= implode(' ', $words);
        }

        return $string;
    }

}
