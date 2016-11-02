<?php
/**
 * Created by PhpStorm.
 * User: Tassio Pinheiro
 * Date: 12/10/2016
 * Time: 01:06
 */

namespace CodeDelivery\Services;

use Illuminate\Support\Facades\DB;

trait OrderService
{
    public function list_status()
    {
        $list_status = ['0' => 'Pendente', '1' => 'A caminho', '2' => 'Entregue'];
        return $list_status;
    }

    public function createOrderService(array $data)
    {
        DB::beginTransaction();
        try{
            $data['status'] = 0;
            if(isset($data['cupom_code'])){
                $cupom = $this->cupomRepository->findByField('code',$data['cupom_code'])->first();
                $data['cupom_id'] = $cupom->id;
                $cupom->used = 1;
                $cupom->save();
                unset($data['cupom_code']);
            }

            $items = $data['items'];
            unset($data['items']);

            $order = $this->orderRepository->create($data);
            $total = 0;

            foreach($items as $item){
                $item['price'] = $this->productRepository->find($item['product_id'])->price;
                $order->items()->create($item);
                $total += $item['price'] * $item['qtd'];
            }

            $order->total = $total;
            if(isset($cupom)) {
                $order->total = $total - $cupom->value;
            }
            $order->save();
            DB::commit();
            return $order;

        }catch (\Exception $e){
            DB::rollback();
            throw $e;
        }

    }
}