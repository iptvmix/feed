#!/bin/bash
# Thanks to pshanmu3 user on github
echo $(dirname $0)
cd $(dirname $0)
python3 sozcutv.py > ../feed/blop/main/sozcutv.m3u8

echo m3u grabbed
