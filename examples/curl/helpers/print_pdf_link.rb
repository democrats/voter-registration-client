#!/usr/bin/env ruby

require 'rubygems'
require 'json'

json_file = ARGV[0] || 'pdflink.json'

pdfdata = JSON.load(File.open(json_file))
puts "Registration ID: #{pdfdata["id_sha1"]}"
puts "URL: #{pdfdata["link"]}"
