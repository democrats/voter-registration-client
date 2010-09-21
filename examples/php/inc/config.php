<?php

class VoterRegConfig {
  public $api_key = '';
  public $host = 'register.barackobama.com';
  public $base_path = '/api/';

  public function getFieldsUrl($state, $lang) {
    return "https://" . $this->host . $this->base_path . "registration/fields/" . $state . ".json?lang=" . $lang . "&key=" . $this->api_key;
  }

  public function getBaseRegistrationUrl () {
    return "https://" . $this->host . $this->base_path . "registrations.json?key=" . $this->api_key;
  }

}

?>
