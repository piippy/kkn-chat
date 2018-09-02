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

/*initialize curl setting to send a json post data*/
$ch = curl_init("https://graph.facebook.com/v2.6/me/messages?access_token=$access_token");
function bot_answer($resp, $sender) {
  global $ch;
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
    'recipient' => array('id' => $sender),
    'message' => array('text' => $resp)
  )));
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
  $result = curl_exec($ch); // user will get the message
}

/* receive and send messages */
$input = json_decode(file_get_contents('php://input'), true);

foreach ($input['entry'] as $entry) {
  foreach ($entry['messaging'] as $messaging) {
    $sender = $messaging['sender']['id'];
    if (empty($sender))
      continue;
    bot_answer(array('text'=>$sender), $sender);
    bot_answer(array('text'=>$messaging['message']['text']), $sender);

    // $responses = get_responses($messaging['message']['text']);
    // if (empty($responses))
    //   continue;
    // foreach($responses as $resp)
    //   bot_answer($resp, $sender);
  }
}
