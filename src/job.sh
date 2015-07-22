#!/bin/bash
#
guide="/opt/deepdream-api/doge.jpg"
input_dir="$1"
output_dir="$2"
for i in $(ls $input_dir); do
	/opt/deepdream-api/src/dream.py $guide $input_dir/$i $output_dir/$i;
done
