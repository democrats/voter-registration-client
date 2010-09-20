#!/bin/bash

source vars.sh

REG_FILE="sample_data/reg.json"
REG_URL=`ruby helpers/registration_url.rb ${API_KEY} ${REG_FILE}`

# All the data is in the URL, hence -d ''
curl $CURLOPTS --globoff -X POST -d '' "$REG_URL" > pdflink.json
