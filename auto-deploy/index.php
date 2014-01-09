<?php

/* Credit where credit is due: some code adapted from https://github.com/bkorte/auto-deploy
   © BK I.I. Services (www.bkit.ca) */

require('config.php');

function _log($message) {
  global $deploy_log;
  if(isset($deploy_log) && !empty($deploy_log)) {
    if (file_exists($deploy_log) && is_writable($deploy_log)) {
      file_put_contents($deploy_log, $message, FILE_APPEND);
    } else {
      return -1;
    }
  }
}

if(isset($_POST['payload'])) {
  $payload = json_decode($_POST['payload']);
}

// Check that the request is coming from an approved host (if set in config)

if (isset($_SERVER['REMOTE_ADDR'])) {
  $remote_ip = $_SERVER['REMOTE_ADDR'];
}
if(!isset($allowed_ips) || !in_array($remote_ip, $allowed_ips, true)) {
  _log("The POST came from an IP that isn't allowed: " . $remote_ip);
  return;
}

// Check that we're properly configured

if(! isset($deploy_user)) {
  _log('Please define the user the deploy should run as.  Must have access to the repo and local folder');
  return;
}


if(! isset($allowed_branches)) {
  _log('Please define the allowed branches (must exactly match `ref` in the payload)');
  return;
}

// Check the recieved data

if(! isset($payload) || $payload == NULL) {
  _log('Payload is either not properly formatted or not present');
  return;
}

if(! in_array($payload->ref, $allowed_branches)) {
  _log('Ignoring this branch.');
  return;
}

// If  we've made it this far...

$command = 'sudo -u ' . $deploy_user . ' /usr/bin/git pull 2>&1';

if (isset($deploy_live) && $deploy_live) {
  if (isset($deploy_path) && $deploy_path != '') {
    chdir($deploy_path);
  }
  $command_output = system($command);
}
// Log the output to file
$log = $payload->repository->name . ' deployed, ' . date('Y-m-d H:i:s') . "\n";
if (isset($deploy_live) && $deploy_live) {
  $log .= $command_output . "\n\n";
} else {
  $log .= '[TESTING]' . "\n\n";
}
_log($log);

