<?php
/**
 * Created by PhpStorm.
 * User: Tassio Pinheiro
 * Date: 12/10/2016
 * Time: 01:06
 */

namespace CodeDelivery\Services;

trait ClientService
{
    public function updateClientService(array $data, $id)
    {
        $this->clientRepository->update($data, $id);

        $userId = $this->clientRepository->find($id)->user_id;

        $this->userRepository->update($data['user'], $userId);
    }

    public function storeClientService(array $data)
    {
        $data['user']['password'] = bcrypt('123456');

        $userId = $this->userRepository->create($data['user']);

        $data['user_id'] = $userId->id;

       $this->clientRepository->create($data);
    }
}