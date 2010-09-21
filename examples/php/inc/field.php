<?php

require_once("config.php");

class VoterRegField {
  public $state = '';
  public $lang = '';

  public $name = '';
  public $required = false;
  public $help_text = '';
  public $label = '';
  public $options = Array();
  public $validations = Array();

  public function __construct($state, $lang, $parsed) {
    $this->state = $state;
    $this->lang = $lang;

    //var_dump($parsed);
    $this->name = $parsed["name"];
    $this->required = $parsed["required"] == "true";
    $this->help_text = $parsed["help_text"];
    $this->label = $parsed["label"];
    $this->options = isset($parsed["options"]) ? $parsed["options"] : NULL;
    $this->validations = $parsed["validations"];
  }

  // class methods
  private static function fetch_json($state, $lang) {
    $cfg = new VoterRegConfig();
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $cfg->getFieldsUrl($state, $lang));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $raw_json = curl_exec($ch);

    curl_close($ch);
    return $raw_json;
  }

  public static function getFields($state, $lang) {
    $raw_json = self::fetch_json($state, $lang);
    $parsed = json_decode($raw_json, true);

    $fields = Array();
    foreach ($parsed as $field_data) {
      $fields[] = new VoterRegField($state, $lang, $field_data);
    }

    return $fields;
  }

}

?>
