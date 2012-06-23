#!/bin/bash
rsync -vr --exclude '.git' --exclude 'vendor' --exclude 'LocalSettings.php' . yuvipanda@wolfsbane.toolserver.org:~/public_html/noobieboard
