<?php

class Woodpecker_For_Wordpress_Connector_Curl
{
  /**
   * data to API
   *
   * @var string
   */
  private $url = 'https://api.woodpecker.co';
  private $urlconnect = '';

  private $apikey = '';

  private $urlaction = '';

  /**
   * user name
   *
   * @var string
   */
  private $username = '';

  /**
   * response data
   *
   * @var string
   */
  private $thisJson = '';

  /**
   * data to send
   *
   * @var string
   */
  private $postdata = '';

  private $total = 0;

  /**
   * Constructor
   *
   * @param string $urlaction
   * @param string $apikey
   *
   */
  public function __construct($urlaction, $apikey, $postdata = array())
  {
    if ($urlaction == '' or $apikey == '') {
      return 'Need data to connect';
    }

    $this->urlconnect = $this->url . preg_replace('/\s+/', '', $urlaction);
    $this->apikey = $apikey;
    $this->postdata = $postdata;
  }


  private function woodpeckerAPIconnect()
  {
    $basicauth = 'Basic ' . base64_encode($this->apikey . ":");

    if (!empty($this->postdata) && count((array)$this->postdata)) {
      $woodpecerMethod = 'POST';
    } else {
      $woodpecerMethod = 'GET';
    }

    $woodpeckerParam = array(
      'method' => $woodpecerMethod,
      'headers' => array(
        'Content-type' => 'application/json',
        'Cache-Control' => 'no-cache',
        'Authorization' => $basicauth,
      ),
      'timeout' => '100',
      'redirection' => '5',
      'httpversion' => '1.0',
      'blocking' => true,
      'sslverify' => false,
      'body' => $this->postdata,
    );

    $jsonData = wp_remote_post($this->urlconnect, $woodpeckerParam);


    $return = "";

    $httpCode = wp_remote_retrieve_response_code($jsonData);

    if ($httpCode != 200) {
      $return .= "Return code is {" . $httpCode . "} \n" . '<br>';
      $jsonData = null;
    }

    $this->total = wp_remote_retrieve_header($jsonData, 'x-total-count');
    $this->thisJson = wp_remote_retrieve_body($jsonData);
    $this->thisJsonerror = $return;
  }

  public function getJson()
  {
    $this->woodpeckerAPIconnect();

    return array(
      'total' => json_decode($this->total),
      'data' => json_decode($this->thisJson)
    );
  }

  public function getDataJson()
  {
    $this->woodpeckerAPIconnect();
    return json_decode($this->thisJson);
  }
}
