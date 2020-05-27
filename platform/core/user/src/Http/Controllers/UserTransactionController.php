<?php

namespace Core\User\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Core\MetaSeo\Http\Controllers\RenderMetaSeo;
use Illuminate\Http\Request;
use App\Models\Transaction;

class UserTransactionController extends Controller
{
    public function index(Request $request)
    {
        $transactions = Transaction::with('user:id,name','document:id,dcm_name,dcm_slug','combo:id,cd_name,cd_slug')->whereRaw(1)
            ->where('tst_user_id', \Auth::id());

        if ($request->id) $transactions->where('id', $request->id);
        if ($email = $request->email) {
            $transactions->where('tst_email', 'like', '%' . $email . '%');
        }

        if ($type = $request->type) {
            if ($type == 1) {
                $transactions->where('tst_user_id', '<>', 0);
            } else {
                $transactions->where('tst_user_id', 0);
            }
        }

        if ($status = $request->status) {
            $transactions->where('tst_status', $status);
        }

        $transactions = $transactions->orderByDesc('id')
            ->paginate(10);

        // if ($request->export) {
        //     return \Excel::download(new TransactionExport($transactions), 'don-hang.xlsx');
        // }

		$optionsMeta             = [
			'meta_title'       => 'Tài liệu đã mua',
			'meta_description' => '',
			'meta_keywords'    => '',
			'meta_image'       => '',
			'meta_robots'      => ''
		];
		$metaSeo                 = RenderMetaSeo::MetaSeo($optionsMeta);

        $viewData = [
            'transactions' => $transactions,
			'metaSeo'	   => $metaSeo,
            'query'        => $request->query()
        ];

        return view('user::pages.transaction', $viewData);
    }



    protected function getOrderByTransactionID($transactionID)
    {
        return Order::with('product:id,pro_name,pro_slug,pro_avatar')
            ->where('od_transaction_id', $transactionID)
            ->get();
    }
}
