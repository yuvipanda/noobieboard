#!/bin/bash

echo "Pushing..."
git push origin master
echo "Pulling..."
ssh willow.toolserver.org 'cd ~/public_html/noobieboard && git pull origin master'
