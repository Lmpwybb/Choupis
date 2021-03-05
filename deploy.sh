#!/bin/sh
rsync -avP ./ choupis@ssh-choupis.alwaysdata.net:~/www --exclude-from=.gitignore --exclude=.git
