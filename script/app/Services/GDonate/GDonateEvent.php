<?php namespace App\Services\GDonate;


class GDonateEvent
{
    public function check($params)
    {    
         $GDonateModel = GDonateModel::getInstance();         
         
         if ($GDonateModel->getAccountByName($params['account']))
         {
            return true;      
         }  
         return 'Character not found';
    }

    public function pay($params)
    {
         $GDonateModel = GDonateModel::getInstance();
         $GDonateModel->donateForAccount($params['account'], $params['sum']);
    }
}
