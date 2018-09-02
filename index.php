<?php
require_once "logic.php";

/* validate verify token needed for setting up web hook */
$access_token = 'EAAma1qnSTo0BAFBoFIZBUQDczPxZAj8ho34AcGhH6abqwAKelg4yCRKQZBRgyNBnnRJs23kRVvFVJiMOAhdBpYkX2yMHZCZB2HHTIu6daxtQ7dvNcUZB7yRmgTHpfqacpIMdNbvH7wkCOueAm9JWfr5O86dxW7dN9JRoa9q5Ws1QZDZD';
if (isset($_GET['hub_verify_token'])) {
  if ($_GET['hub_verify_token'] === $access_token) {
    echo $_GET['hub_challenge'];
    return;
  } else {
    echo 'Invalid Verify Token';
    return;
  }
}

/* Debug data */
$file = fopen("logs.txt","w");
fwrite($file, file_get_contents('php://input'));
fclose($file);

function get_response($text) {
  global $logics;
  foreach ($logics as $logic) {
    foreach ($logic['matchers'] as $matcher) {
      switch ($matcher['type']) {
        case 'exact':
          if ($matcher['value'] == $text)
            return $logic['return'];
          break;
        default:
          // code...
          break;
      }
    }
  }
}

/*initialize curl*/
$ch = curl_init("https://graph.facebook.com/v2.6/me/messages?access_token=$access_token");

/* receive and send messages */
$input = json_decode(file_get_contents('php://input'), true);
foreach ($input['entry'] as $entry) {
  foreach ($entry['messaging'] as $messaging) {
    $sender = $messaging['sender']['id'];
    $text = $messaging['message']['text'];

    /*prepare response*/
    // $msg = get_response($text);
    // if (!$msg)
    //   continue;

    /* curl setting to send a json post data */
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
      'recipient' => array('id' => $sender),
      'message' => array('text' => $text)
    )));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    $result = curl_exec($ch); // user will get the message
  }
}
