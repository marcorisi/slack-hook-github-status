<?php

  include 'config.php';

  // retrieve slack hook params
  $token = isset($_POST['token']) ? $_POST['token'] : null;
  $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : null;

  // validate request
  if (SLACK_TOKEN !== $token) {
    die('Invalid token');
  }

  // validate user whitelist
  if (CHECK_USER_ID_WHITELIST && !in_array($user_id, $user_id_whitelist)) {
    die('Cannot authorize hook');
  }

  // initialize curl for performing request to GitHub status API
  $curl = curl_init();
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_URL, 'https://status.github.com/api/status.json');
  curl_setopt($curl, CURLOPT_TIMEOUT, 5);
  curl_setopt($curl, CURLOPT_USERAGENT, 'slack-hook-github-status (https://github.com/marcorisi)');
  $response = curl_exec($curl);
  curl_close($curl);

  if ( !$response ) {
    echo "Could not reach GitHub Status API";
  } else {
    // parse json response
    $response = json_decode($response, true);
    $gh_status = $response['status'];
    $gh_last_updated = $response['last_updated'];
    $seconds_ago = strtotime('now') - strtotime($gh_last_updated);
    echo "GitHub status is: " . $gh_status . "\nLast update: " . $seconds_ago . " seconds ago";
  }

 ?>
