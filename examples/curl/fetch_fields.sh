#!/bin/bash

source vars.sh

FIELDS_BASE_URL="https://${HOST}/api/registration/fields/"
LANGUAGES="en es"
QRY_STRING="?key=${API_KEY}"
STATES="MA NY DE"

for st in $STATES ; do
  for lang in $LANGUAGES ; do
    curl $CURLOPTS "${FIELDS_BASE_URL}${st}.json${QRY_STRING}&language=${lang}" > field_json/${st}_${lang}.json
  done
done
