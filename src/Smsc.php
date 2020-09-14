<?php

namespace rashpil91\smsc\src;

use yii\base\BaseObject;

class Smsc extends BaseObject
{

    public $config;
    public $debug_details = [];

    private function send($method, $param = [])
    {

        $param['login'] = $this->config['login'];
        $param['psw'] = $this->config['psw'];
        $param['fmt'] = 3;
        $param['charset'] = $this->config['charset'];

        $url = "https://smsc.ru/sys/{$method}?" . http_build_query($param);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);

        $output = curl_exec($ch);
        $output = json_decode($output);

        if ($this->config['debug'])
        {
            $this->debug_details = [
                'method' => $method,
                'param' => $param,
                'output' => $output
            ];
        }

        return $output;
    }

    private function sendMessage($phones, $mes, $cost = 3)
    {

        if (is_array($phones)) $phones = implode(',', $phones);

        return $this->send("send.php", ['phones' => $phone, 'mes' => $mes, 'cost' => $cost]);

    } 

    /*
     * Отправка сообщения. Возвращает объект с id сообщения, информацией о цене, остатке баланса клиента.
     */

    public function Message($phones, $mes)
    {
        
        return $this->sendMessage($phones, $mes);

    }
    
    /*
     * Баланс клиента. Возвращает дробь
     */

    public function getBalance()
    {

        $result = $this->send("balance.php");

        return floatval($result['balance']);

    }

    /*
     * Статус сообщения. Возвращает информацию о сообщении (дату, текст, получателя, статус, отправителя)
     */

    public function getStatus($phone, $id)
    {

        return $this->send("status.php", ['phone' => $phone, 'id' => $id, 'all' => 1]);

    }
   
    /*
     * Стоимость сообщения. Возвращает объект
     */

    public function getCost($phones, $mes)
    {
        
        return $this->sendMessage($phones, $mes, 1);

    }
}