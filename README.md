
YouTube to M3U8
M3U8 Generator For YouTube
Updated m3u8 links of YouTube live channel, auto-updated every 3 hours.

How to get started?

1. Create a file.

channel-name.txt

~~ DO NOT EDIT THE FIRST 2 LINES	
~~ FORMAT: <channel name> | <group name> | <logo> | <tvg-id>


channel-name | | |
Paste here the URL you copied from the live youtube channel.

2. Generate Python for "channel-name.txt".

scripts/channel-name.py

#! /usr/bin/python3

import requests
import os
import sys

windows = False
if 'win' in sys.platform:
    windows = True

def grab(url):
    response = s.get(url, timeout=15).text
    if '.m3u8' not in response:
        response = requests.get(url).text
        if '.m3u8' not in response:
            if windows:
                print('https://raw.githubusercontent.com/user-name/repo-name/main/assets/info.m3u8')
                return
            #os.system(f'wget {url} -O temp.txt')
            os.system(f'curl "{url}" > temp.txt')
            response = ''.join(open('temp.txt').readlines())
            if '.m3u8' not in response:
                print('https://raw.githubusercontent.com/user-name/repo-name/main/assets/info.m3u8')
                return
    end = response.find('.m3u8') + 5
    tuner = 100
    while True:
        if 'https://' in response[end-tuner : end]:
            link = response[end-tuner : end]
            start = link.find('https://')
            end = link.find('.m3u8') + 5
            break
        else:
            tuner += 5
    streams = s.get(link[start:end]).text.split('#EXT')
    hd = streams[-1].strip()
    st = hd.find('http')
    print(hd[st:].strip())
    #print(f"{link[start : end]}")

print('#EXTM3U')
print('#EXT-X-VERSION:3')
print('#EXT-X-STREAM-INF:PROGRAM-ID=1,BANDWIDTH=2560000')
s = requests.Session()
with open('../channel-name.txt') as f:
    for line in f:
        line = line.strip()
        if not line or line.startswith('~~'):
            continue
        if not line.startswith('https:'):
            line = line.split('|')
            ch_name = line[0].strip()
            grp_title = line[1].strip().title()
            tvg_logo = line[2].strip()
            tvg_id = line[3].strip()
        else:
            grab(line)

if 'temp.txt' in os.listdir():
    os.system('rm temp.txt')
    os.system('rm watch*')
Re-edit : https://raw.githubusercontent.com/user-name/repo-name/main/assets/info.m3u8 and ../channel-name.txt


3. Add an error video (This happens if the youtube channel doesn't work at all).

assets/info.m3u8

#EXTM3U
#EXT-X-VERSION:3
#EXT-X-TARGETDURATION:10
#EXT-X-MEDIA-SEQUENCE:0
#EXTINF:10.000000,
staytuned0.ts
#EXTINF:10.000000,
staytuned1.ts
#EXT-X-ENDLIST
Download this short video and upload it to the "assets" folder and place it together with the info.m3u8 file. For example here

Click the link :

staytuned0.ts
staytuned1.ts

4. Create a Shell script file to install "channel-name.py" and auto generate a new file "channel-name.m3u8".

channel-name.sh

#!/bin/bash

echo $(dirname $0)

python3 -m pip install requests

cd $(dirname $0)/scripts/

python3 channel-name.py > ../channel-name.m3u8

echo m3u8 grabbed
Re-edit : channel-name.py and ../channel-name.m3u8


5. Run the workflows on "Github Actions".

channel-name.yml

--> Go to the Actions section --> click New then select set up a workflow yourself --> the last one create the name channel-name.yml and copy paste the script file below.

# This is a basic workflow to help you get started with Actions

name: channel-name

# Controls when the action will run. 
on:
  schedule:
    - cron: '0 0/3 * * *'
    
  pull_request:
    branches:
      - main
  
  # Allows you to run this workflow manually from the Actions tab
  workflow_dispatch:

# A workflow run is made up of one or more jobs that can run sequentially or in parallel
jobs:
  # This workflow contains a single job called "build"
  build:
    # The type of runner that the job will run on
    runs-on: ubuntu-latest

    # Steps represent a sequence of tasks that will be executed as part of the job
    steps:
      # Checks-out your repository under $GITHUB_WORKSPACE, so your job can access it
      - uses: actions/checkout@v2

      # Runs a single command using the runners shell
      #- name: Run a one-line script
      #  run: echo testing!

      # Runs a set of commands using the runners shell 
      - name: config
        run: |
          git pull
          git config --global user.email "your.email@gmail.com"
          git config --global user.name "your-name"
      
      
      - name: Main
        run: |
          pwd
          chmod +x channel-name.sh
          ./channel-name.sh
        
      - name: git add
        run: |
          git add -A
          ls -la 
          
      - name: commit & push
        run: |
          git commit -m "Link updated"
          git push
Re-edit : channel-name in the first part of the second line. your.email@gmail.com and your-name. Under it channel-name.sh and ./channel-name.sh


You Are Done!


Now you can wait until the Actions generates itself in 3 hours on the workflows or you can create your own test.

Like this : --> Go to the Actions section --> click Select workflow click on the name of the workflow file you just created. --> Next below you will find the button Run workflow click that button --> finally click the green button "Run workflow".

After that you wait in 2-3 seconds and refresh the page, you will see it working manually from yourself.


Action works
Workflow run results

This is a success :


This is a failure :



Credits : benmoose39

Another method

Get YouTube channel live URL using Cloudflare Workers

