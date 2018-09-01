<?php
$access_token = 'EAAhGuNGZCkpcBABPnOz6f7entM9lg3ZAPFqhuFK2AsEuQLKF2ZCshZCHxyxr4ZBO42IT176TiQCPsmCZCLkauoV9b2B2E9tek60s7qR78GuuiBhs3yfdxBNVe1cThH6qWuFVM4NX0pfJvqY2h5QqABE9TAanEBYS9mQkdsMZBWnDAZDZD';

/* validate verify token needed for setting up web hook */
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

/* conversation logic */
$logics = array(
  array(
    matchers => array(
      "type" => "exact",
      "value" => "สอบถามค่าบริการจัดส่ง"
    ),
    "return" =>
"ค่าบริการการจัดส่ง สั่งกี่คู่ราคาส่งก็เท่ากันครับ

ลงทะเบียนธรรมดา - 20บาท
EMS - 60บาท
Kerry - 80บาท
Kerry เก็บเงินปลายทาง - 100บาท

ค่าจัดส่งจะเป็นตามนี้ครับผม"
  )
);

function get_response($text) {
  global $logics;
  $msg = ":);text:$text;";
  foreach ($logics as $logic) {
    foreach ($logic['matchers'] as $matcher) {
      $msg .= "type:{$matcher['type']};";
      switch ($matcher['type']) {
        case 'exact':
          if ($matcher['value'] == $text)
            $msg .= 'return:' . $logic['return'] . ';';
          break;
        default:
          // code...
          break;
      }
    }
  }
  return $msg;
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
    $resp = array(
      'recipient' => array('id' => $sender),
      'message' => array('text' => get_response($text))
    );

    /* curl setting to send a json post data */
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($resp));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    $result = curl_exec($ch); // user will get the message
  }
}
