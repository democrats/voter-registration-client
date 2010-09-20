#!/usr/bin/env ruby

require 'rubygems'
require 'uri'
require 'json'

api_key = ARGV[0] || raise("No API key specified")
json_file = ARGV[1] || 'sample_data/reg.json'

base_url = "https://register.barackobama.com/api/registrations.json?key=#{api_key}"

regdata = JSON.load(File.open(json_file))
puts URI.escape(base_url + '&' + regdata.collect{|k,v| "#{k}=#{v}"}.join('&'))
