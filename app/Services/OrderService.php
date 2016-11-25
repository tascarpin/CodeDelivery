<?php
/**
 * Created by PhpStorm.
 * User: Tassio Pinheiro
 * Date: 12/10/2016
 * Time: 01:06
 */

namespace CodeDelivery\Services;

use CodeDelivery\Models\Order;
use CodeDelivery\Repositories\CupomRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

trait OrderService
{

    /**
     * @var CupomRepository
     */
    private $cupomRepository;

    public function __construct(CupomRepository $cupomRepository){

        $this->cupomRepository = $cupomRepository;
    }

    public function list_statusService()
    {
        $list_status = ['0' => 'Pendente', '1' => 'A caminho', '2' => 'Entregue'];
        return $list_status;
    }

    public function createOrderService(array $data)
    {
        DB::beginTransaction();
        try{
            $data['status'] = 0;
            if(isset($data['cupom_id'])){
                unset($data['cupom_id']);
            }
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

    public function getByIdAndDeliverymanService($id, $idDeliveryman)
    {
        $result = $this->orderRepository
            ->skipPresenter(false)
            ->with(['client', 'items', 'cupom'])->findWhere([
            'id' => $id,
            'user_deliveryman_id' => $idDeliveryman
        ]);

        if($result instanceof Collection) {
            $result = $result->first();
        }else {
            if (isset($result['data']) && count($result['data']) == 1) {
                $result = [
                    'data' => $result['data'][0]
                ];
            } else {
                throw new ModelNotFoundException('Order não existe.');
            }
        }

        return $result;
    }

    public function updateStatusService($id, $idDeliveryman, $status)
    {
        $order = $this->getByIdAndDeliverymanService($id, $idDeliveryman);
        if ($order instanceof Order){
            $order->status = $status;
            $order->save();
            return $order;
        }
        return false;
    }
}