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

/* conversation list */
$conversation = array(
  'logistic' =>
":) ค่าบริการการจัดส่ง สั่งกี่คู่ราคาส่งก็เท่ากันครับ

📦 จัดส่งด้วย ไปรษณีย์ แบบEMS(โอนเงิน): 60บาท
📦 จัดส่งด้วย Kerry(โอนเงิน): 80บาท
📦 จัดส่งด้วย Kerry แบบเก็บเงินปลายทาง: 100บาท

:) ค่าจัดส่งจะเป็นตามนี้ครับผม",

  'Thudong' =>
":) รองเท้าแตะชุดธุดงค์ มี4แบบตามภาพครับ
👞 ราคาคู่ละ 540บาท
👞 มีไซส์ 40-45ครับ",

  'Meesook' =>
":) รองเท้าแตะชุดมีสุข มี3แบบตามภาพครับ
👞 ราคาคู่ละ 540บาท
👞 มีไซส์ 39-44ครับ"
);

/* conversation logic */
$logics = array(
  array(
    "matchers" => array(
      array("type" => "exact", "value" => "สอบถามค่าบริการจัดส่ง")
    ),
    'resp' => array('text' => $conversation['logistic'])
  ),
  array(
    "matchers" => array(
      array("type" => "exact", "value" => "สอบถามชุดธุดงค์")
    ),
    "resp" => array(
      'text' => $conversation['Thudong'],
      // 'attachment' => array(
      //   'type' => 'image',
      //   'payload' => array(
      //     'url' => 'https://kkn-chat.herokuapp.com/img/td.mix.png',
      //     'is_reusable' => true
      //   )
      // )
    )
  )
);

function get_resp($text) {
  global $logics;
  foreach ($logics as $logic) {
    foreach ($logic['matchers'] as $matcher) {
      switch ($matcher['type']) {
        case 'exact':
          if ($matcher['value'] == $text)
            return $logic['resp'];
          break;
      }
    }
  }
  return;
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
    $resp = get_resp($text);
    if (!$sender || !$resp)
      continue;

    $output = array(
      'messaging_type' => 'RESPONSE',
      'recipient' => array('id' => $sender),
      'message' => $resp
    );

    /* curl setting to send a json post data */
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($output));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    $result = curl_exec($ch); // user will get the message
  }
}
