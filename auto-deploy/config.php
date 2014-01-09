<?php

// Any branches that you wish to delpoy.  I only allow master to be deployed.
$allowed_branches = array('refs/heads/master');

// If this is set, only POST requests from one of these IPs will be honored
// GitHub uses 4 * 256 different addresses to send their webbooks, so we aren't checking
//$allowed_ips = array();

// The user to sudo in as to run the git pull command from.
$deploy_user = 'restomanifesto';

// If you set this, auto-deploy will log all deploys. Absolute path to the log file.  I use "/var/log/deploy"
$deploy_log = '/var/log/auto-deploy.log';

// If this is set, then chdir will be used to change to this directory before git pull is run
$deploy_path = '/var/www/restomanifesto.com';

// If this is set to false, live deploy's will be disabled
$deploy_live = true;
