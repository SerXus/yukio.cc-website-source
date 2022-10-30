<?php
include "../includes/db.php";

class PaypalPayment
{
  protected $clienteIDSandbox;
  protected $secretSandbox;

  
  protected $clienteIDLive;
  protected $secretLive;
  public  $currency;

  public $mode;
  public $urlPaypal;

  public function __construct() {

    $this->mode = 'production'; //production

    $this->clienteIDSandbox = '';
    $this->secretSandbox = '';

    $this->clienteIDLive = '';
    $this->secretLive = '';

    $this->currency = 'EUR';

    if($this->mode == 'sandbox') {
      $this->urlPaypal = 'https://api-m.sandbox.paypal.com/v1/';
    }else {
      $this->urlPaypal = 'https://api-m.paypal.com/v1/';
    }
  }

	public function getClienteIDSandbox() {
    return $this->clienteIDSandbox;
  }

  public function getClienteIDLive()
  {
    return $this->clienteIDLive;
  }

  protected function getAccessToken()
  {
    
    if($this->mode == 'sandbox') {
      $ClientID = $this->clienteIDSandbox;
      $Secret = $this->secretSandbox;
    } else {
      $ClientID = $this->clienteIDLive;
      $Secret = $this->secretLive;
    }

    $login = curl_init($this->urlPaypal . 'oauth2/token');
    curl_setopt($login, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($login, CURLOPT_USERPWD, $ClientID . ':' . $Secret);
    if ($this->mode == 'sandbox') {
      /** Esto es para poderlo probar en localhost */
      curl_setopt($login, CURLOPT_SSL_VERIFYHOST, 0);
      curl_setopt($login, CURLOPT_SSL_VERIFYPEER, 0);
    }
    curl_setopt($login, CURLOPT_POSTFIELDS, 'grant_type=client_credentials');
    $result = curl_exec($login);
    curl_close($login);
    if($result){
      $object = json_decode($result);
      return $object->access_token;
    }else {
      return 'fail';
    }
  }

  public function verify()
  {
    $paymentID = isset($_GET['paymentId']) ? $_GET['paymentId'] : '';
    if (!empty($paymentID)) {
      $accesToken = $this->getAccessToken();
      if($accesToken != 'fail') {

        $sales = curl_init($this->urlPaypal . 'payments/payment/' . $paymentID);
        curl_setopt($sales, CURLOPT_HTTPHEADER, ['Content-Type: application/json', 'Authorization: Bearer ' . $accesToken]);
        curl_setopt($sales, CURLOPT_RETURNTRANSFER, true);
        if ($this->mode == 'sandbox') {
          /** Esto es para poderlo probar en localhost */
          curl_setopt($sales, CURLOPT_SSL_VERIFYHOST, 0);
          curl_setopt($sales, CURLOPT_SSL_VERIFYPEER, 0);
        }
        $result = curl_exec($sales);
        curl_close($sales);
        if($result){
          $object = json_decode($result);

          $state = $object->state;
          $email = $object->payer->payer_info->email;
          $first_name = $object->payer->payer_info->first_name;
          $last_name = $object->payer->payer_info->last_name;
          $country_code = $object->payer->payer_info->country_code;
          $total = $object->transactions[0]->amount->total;
          $currency = $object->transactions[0]->amount->currency; // USD
          $description = $object->transactions[0]->description;
          $custom = $object->transactions[0]->custom;
          $idTransaction = $object->transactions[0]->related_resources[0]->sale->id;
          if($state == 'approved' && ($total == "10.99" || $total == "9.99")) 
          {
              return $result;
          }

        } else {
          die();
        }
      }
    }
  }

}