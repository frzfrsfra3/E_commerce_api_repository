<?php 

namespace App\Contracts;

interface OrderRepositoryInterface
{
    public function create(array $data);
}
