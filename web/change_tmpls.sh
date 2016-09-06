#!/bin/bash
codehome=/home/ubuntu/gitrepo/bbaero-site
tmplhome=${codehome}/templates/php
#docroot=\'\\\\\\\/var\\\\\\\/www\\\\\\\/testlogs\'
docroot=\'\\\\\\\/home\\\\\\\/ubuntu\\\\\\\/gitrepo\\\\\\\/bbaero-site\\\\\\\/web\'

if [ ! -d php ]; then
    mkdir php
fi

for tf in `ls ${tmplhome}`; do
    cp ${tmplhome}/${tf} php/${tf}-orig
    sed -e "s/docroot/${docroot}/g" ${tmplhome}/docroot-rep.sed > dr-rep.sed
    sed -f dr-rep.sed php/${tf}-orig > php/${tf} 
done

php -f ${tmplhome}/runtest.php > runtest.html

