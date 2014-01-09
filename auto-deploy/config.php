<?php

// Any branches that you wish to delpoy.  I only allow master to be deployed.
$allowed_branches = array('refs/heads/master');

// If this is set, only POST requests from one of these IPs will be honored
$allowed_ips = array('207.97.227.253', '50.57.128.197', '108.171.174.178', '72.5.167.148' ); // These are for GitHub

// The user to sudo in as to run the git pull command from.
$deploy_user = 'restomanifesto';

// If you set this, auto-deploy will log all deploys. Absolute path to the log file.  I use "/var/log/deploy"
$deploy_log = '/var/log/auto-deploy.log';

// If this is set, then chdir will be used to change to this directory before git pull is run
$deploy_path = '/var/www/restomanifesto.com';

// If this is set to false, live deploy's will be disabled
$deploy_live = true;
