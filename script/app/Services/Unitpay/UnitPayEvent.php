<?php namespace App\Services\Unitpay;


class UnitPayEvent
{
    public function check($params)
    {    
         $unitPayModel = UnitPayModel::getInstance();         
         
         if ($unitPayModel->getAccountByName($params['account']))
         {
            return true;      
         }  
         return 'Character not found';
    }

    public function pay($params)
    {
         $unitPayModel = UnitPayModel::getInstance();
         $unitPayModel->donateForAccount($params['account'], $params['sum']);
    }
}
