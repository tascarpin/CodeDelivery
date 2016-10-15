<?php
/**
 * Created by PhpStorm.
 * User: Tassio Pinheiro
 * Date: 12/10/2016
 * Time: 01:06
 */

namespace CodeDelivery\Services;


class OrderService
{


    public function __construct()
    {

    }

    public function list_status()
    {
        $list_status = ['0' => 'Pendente', '1' => 'A caminho', '2' => 'Entregue'];
        return $list_status;
    }
}