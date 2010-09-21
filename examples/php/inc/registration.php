<?php

require_once('config.php');
require_once('field.php');

class VoterRegRegistration {
  public $fields;
  public $state;
  public $lang;

  private $saved = false;
  private $id_sha1;
  private $pdf_link;

  private $cfg;
  private $user_data = Array();
  private $error;

  public function __construct($state, $lang) {
    $this->state = $state;
    $this->lang = $lang;

    $this->cfg = new VoterRegConfig();
    $this->fields = VoterRegField::getFields($state, $lang);
  }

  public function error() {
    return $this->error;
  }

  public function id_sha1() {
    if ( ! $this->saved ) {
      die("id_sha1 isn't available before save() is called successfully.\n");
    }
    return $this->id_sha1;
  }
  public function pdf_link() {
    if ( ! $this->saved ) {
      die("pdf_link isn't available before save() is called successfully.\n");
    }
    return $this->pdf_link;
  }

  public function fill_in_fields($regdata) {
    $this->user_data = $regdata;
  }

  public function missing_fields() {
    $missing = array();
    foreach ($this->fields as $fld) {
      if ( ! $fld->required ) {
        continue;
      }

      // adjust the format of the field name to match the api
      $name = $this->field_name_for_post($fld);
      if ( ! isset($this->user_data[$name]) ) {
        $missing[] = $fld;
      }

      // we should ideally check the validations here too
    }

    return $missing;
  }

  public function is_valid() {
    $missing = $this->missing_fields();
    return count($missing) == 0;
  }

  public function save() {
    if ( ! $this->is_valid() ) {
      return false;
    }

    $base_url = $this->cfg->getBaseRegistrationUrl();
    $url = $base_url .'&'. $this->build_query_string();

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, TRUE);

    $post_reply = curl_exec($ch);
    curl_close($ch);
    var_dump($post_reply);

    $parsed = json_decode($post_reply, TRUE);
    $this->id_sha1 = $parsed["id_sha1"];
    $this->pdf_link = $parsed["link"];

    $this->saved = true;
    return true;
  }

  private function build_query_string () {
    $tmp = Array();
    foreach ( $this->user_data as $ufield => $val ) {
      $tmp[] = $ufield .'='. urlencode($val);
    }

    return join('&', $tmp);
  }

  private function field_name_for_post($field) {
    return "registration[" . $field->name . "]";
  }

}

?>
