<?php
  require_once("inc/config.php");
  require_once("inc/field.php");

  $cfg = new VoterRegConfig();

  print $cfg->getFieldsUrl('MA', 'en') . "\n";

  $ma_fields = VoterRegField::getFields('MA', 'en');
  foreach ($ma_fields as $field) {
    print $field->name . " is " . ($field->required ? "" : "not " ) . "required\n";
  }

?>
