<?php
require_once "conversation.php";

$init = array(
  array(
    'text' => ":) สวัสดีครับ แก่นขนุน ยินดีให้บริการครับ\r\n💬 หากท่านต้องการติดต่อ จนท รบกวนพิมพ์ว่า \"ต้องการติดต่อ\" ทิ้งไว้นะครับ",
    "quick_replies" => array(
      array("content_type" => "text", "title" => "สอบถามชุดธุดงค์", "payload" => "TD"),
      array("content_type" => "text", "title" => "สอบถามชุดมีสุข", "payload" => "MS")
    )
  )
);
$resp = array(
  'TD' => array(
    array('text' => ":) รองเท้าแตะชุดธุดงค์มี 4 แบบตามภาพครับ\r\n👞 ราคาคู่ละ 540บาท\r\n👞 มีไซส์ 40-45ครับ"),
    array("attachment" => array(
      "type" => "image",
      "payload" => array(
        "url" => "https://kkn-chat.herokuapp.com/img/td.mix.png",
        "is_reusable" => true
      )
    )),
    array(
      "text" => ":) สนใจแบบไหนอยู่ครับ",
      "quick_replies" => array(
        array("content_type" => "text", "title" => "1.หนีบตาล", "payload" => "TD205"),
        array("content_type" => "text", "title" => "2.หนีบแทน", "payload" => "TD206"),
        array("content_type" => "text", "title" => "3.สวม3ชั้นตาล", "payload" => "TD207"),
        array("content_type" => "text", "title" => "4.สวม2ชั้นตาล", "payload" => "TD208")
      )
    )
  ),
  'MS' => array(
    array('text' => ":) รองเท้าแตะชุดมีสุขมี 3 แบบตามภาพครับ\r\n👞 ราคาคู่ละ 220บาท\r\n👞 มีไซส์ 39-44ครับ"),
    array("attachment" => array(
      "type" => "image",
      "payload" => array(
        "url" => "https://kkn-chat.herokuapp.com/img/ms.mix.png",
        "is_reusable" => true
      )
    )),
    array(
      "text" => ":) สนใจแบบไหนอยู่ครับ",
      "quick_replies" => array(
        array("content_type" => "text", "title" => "1.หนีบตาล", "payload" => "MS105"),
        array("content_type" => "text", "title" => "2.หนีบแทน", "payload" => "MS106"),
        array("content_type" => "text", "title" => "3.สวม3ชั้นตาล", "payload" => "MS107")
      )
    )
  ),
  'TDSize' => array(
    array(
      'text' => ":) เลือกขนาดรองเท้าได้เลยครับ",
      "quick_replies" => array(
        array("content_type" => "text", "title" => "เบอร์40", "payload" => "#40"),
        array("content_type" => "text", "title" => "เบอร์41", "payload" => "#41"),
        array("content_type" => "text", "title" => "เบอร์42", "payload" => "#42"),
        array("content_type" => "text", "title" => "เบอร์43", "payload" => "#43"),
        array("content_type" => "text", "title" => "เบอร์44", "payload" => "#44"),
        array("content_type" => "text", "title" => "เบอร์45", "payload" => "#45")
      )
    )
  ),
  'MSSize' => array(
    array(
      'text' => ":) เลือกขนาดรองเท้าได้เลยครับ",
      "quick_replies" => array(
        array("content_type" => "text", "title" => "เบอร์39", "payload" => "#39"),
        array("content_type" => "text", "title" => "เบอร์40", "payload" => "#40"),
        array("content_type" => "text", "title" => "เบอร์41", "payload" => "#41"),
        array("content_type" => "text", "title" => "เบอร์42", "payload" => "#42"),
        array("content_type" => "text", "title" => "เบอร์43", "payload" => "#43"),
        array("content_type" => "text", "title" => "เบอร์44", "payload" => "#44")
      )
    )
  ),
  'ship' => array(
    array(
      'text' => ":) เลือกวิธีการจัดส่งได้เลยครับ",
      "quick_replies" => array(
        array("content_type" => "text", "title" => "Kerry เก็บปลายทาง", "payload" => "$1"),
        array("content_type" => "text", "title" => "ไปรษณีย์ EMS", "payload" => "$2"),
        array("content_type" => "text", "title" => "Kerry ธรรมดา", "payload" => "$3"),
        array("content_type" => "text", "title" => "ไปรษณีย์ ธรรมดา", "payload" => "$4")
      )
    )
  )
);

function concat_payloadToResp($payload, $responses) {
  foreach ($responses as &$response)
    if (isset($response['quick_replies']))
      foreach ($response['quick_replies'] as &$reply)
        $reply['payload'] = $payload . $replay['payload'];
  return $responses;
}

function get_responses($payload) {
  global $init;
  global $resp;

  if ($payload == 'init')
    return $init;

  if (strlen($payload) == 2)
    return $resp[$payload];

  if (strlen($payload) == 5)
    return concat_payloadToResp($payload, $resp[substr($payload, 0, 2) . 'Size']);

  if (strlen($payload) == 8)
    return concat_payloadToResp($payload, $resp['ship']);

  if (strlen($payload) == 10) {
    return array(array('text' => "End: $payload"));
  }
}
