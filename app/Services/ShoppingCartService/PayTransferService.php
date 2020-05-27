<?php


namespace App\Services\ShoppingCartService;


use App\Models\Order;
use App\Models\Transaction;

class PayTransferService extends PayBaseService implements PayServiceInterface
{
    protected $data;
    protected $idTransaction;

    public function __construct($data)
    {
        $this->data = $data;
        $this->saveTransaction();
    }

    public function saveTransaction()
    {
        $dataTransaction = $this->getDataTransaction($this->data);
        $this->idTransaction = Transaction::insertGetId($dataTransaction);
        $orders = $this->data['options']['orders'] ?? [];
        if ($this->idTransaction)
            $this->syncOrder($orders, $this->idTransaction);

        // Mail::to($request->tst_email)->send(new TransactionSuccess($shopping));
        return $this->idTransaction;
    }
}
