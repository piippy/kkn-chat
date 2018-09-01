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
    'matchers' => array(
      'type' => 'exact',
      'value' => 'สอบถามค่าบริการจัดส่ง'
    ),
    'return' =>
'ค่าบริการการจัดส่ง สั่งกี่คู่ราคาส่งก็เท่ากันครับ

ลงทะเบียนธรรมดา - 20บาท
EMS - 60บาท
Kerry - 80บาท
Kerry เก็บเงินปลายทาง - 100บาท

ค่าจัดส่งจะเป็นตามนี้ครับผม'
  )
);

function match_response($input) {
  for ($i = 0, $ii = count($logics); $i < $ii; $i++) {
    for ($j = 0, $jj = count($logics[$i]['matchers']); $j < $jj; $j++) {
      $matcher = $logics[$i]['matchers'][$j];
      switch ($matcher['type']) {
        case 'exact':
          if ($matcher['value'] == $input['entry'][0]['messaging'][0]['message']['text'])
            return $logics[$i]['return'];
          break;

        default:
          // code...
          break;
      }
    }
  }
  return "Your message is {$input['entry'][0]['messaging'][0]['message']['text']}.";
}

/* receive and send messages */
$input = json_decode(file_get_contents('php://input'), true);
if (isset($input['entry'][0]['messaging'][0]['sender']['id'])) {
  $sender = $input['entry'][0]['messaging'][0]['sender']['id'];
  $message = $input['entry'][0]['messaging'][0]['message']['text'];
  $url = 'https://graph.facebook.com/v2.6/me/messages?access_token=' . $access_token;
  /*initialize curl*/
  $ch = curl_init($url);
  /*prepare response*/
  $resp = array(
    'recipient' => array(
      'id' => $sender
    ),
    'message' => array(
      'text' => match_response($input['entry'][0]['messaging'][0]['message']['text'])
    )
  );

  /* curl setting to send a json post data */
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($resp));
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
  if (!empty($message)) {
    $result = curl_exec($ch); // user will get the message
  }
}
