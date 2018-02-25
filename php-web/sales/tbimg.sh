#!/bin/bash
rsync -vzrtopg --delete -e ssh root@192.168.30.186:/root/xuguanjun/getimg/ /var/www/ping/sales/wx/getimg/
