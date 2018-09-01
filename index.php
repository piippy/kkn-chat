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
    "matchers" => array(
      array("type" => "exact", "value" => "สอบถามค่าบริการจัดส่ง")
    ),
    "return" =>
"ค่าบริการการจัดส่ง สั่งกี่คู่ราคาส่งก็เท่ากันครับ

จัดส่งด้วย ไปรษณีย์ แบบEMS(โอนเงิน): 60บาท
จัดส่งด้วย Kerry แบบเก็บเงินปลายทาง: 100บาท

ค่าจัดส่งจะเป็นตามนี้ครับผม"
  ),
  array(
    "matchers" => array(
      array("type" => "exact", "value" => "สอบถามชุดธุดงค์")
    ),
    "return" =>
"รองเท้าแตะชุดธุดงค์ มี4แบบตามภาพครับ
ราคาคู่ละ 540บาท
มีไซส์ 40-45ครับ
https://scontent.fbkk2-6.fna.fbcdn.net/v/t1.15752-0/p480x480/40545218_2108115272770277_6181129212267593728_n.jpg?_nc_cat=0&oh=60cc012ab59485274c48e66c3d0e62da&oe=5C33C299
https://scontent.fbkk2-6.fna.fbcdn.net/v/t1.15752-0/p480x480/40463218_285961015553297_675509540032086016_n.jpg?_nc_cat=0&oh=a2f1f76c6b66d68fac986d3ab26140f4&oe=5BFC460D
https://scontent.fbkk2-6.fna.fbcdn.net/v/t1.15752-0/p480x480/40448931_1833222963440838_956808118140928000_n.jpg?_nc_cat=0&oh=e49875cbe1638aecf4450072f732b1de&oe=5C33BA45
https://scontent.fbkk2-6.fna.fbcdn.net/v/t1.15752-0/p480x480/40573170_706525106348906_5674443755625644032_n.jpg?_nc_cat=0&oh=bcc4b956ec2b65a2cb724fa1dba3054b&oe=5BF46B70"
  )
);

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
    $msg = get_response($text);
    if (!$sender || !$msg)
      continue;

    /* curl setting to send a json post data */
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
      'recipient' => array('id' => $sender),
      'message' => array('text' => $msg)
    )));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    $result = curl_exec($ch); // user will get the message
  }
}
