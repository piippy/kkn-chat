<?php
require_once "conversation.php";

$staticResp = array(
  'init' => array(
    array(
      'text' => ":) สวัสดีครับ แก่นขนุน ยินดีให้บริการครับ\r\n💬 หากท่านต้องการติดต่อ จนท รบกวนพิมพ์ว่า \"ต้องการติดต่อ\" ทิ้งไว้นะครับ",
      "quick_replies" => array(
        array("content_type" => "text", "title" => "สนใจชุดธุดงค์", "payload" => "TD"),
        array("content_type" => "text", "title" => "สนใจชุดมีสุข", "payload" => "MS")
      )
    )
  ),
  'Meesuk' => array(
    array(
      "attachment" => array(
        "type" => "image",
        "payload" => array(
          "url" => "https://kkn-chat.herokuapp.com/img/ms.mix.png",
          "is_reusable" => true
        )
      )
    ),
    array(
      'text' => ":) รองเท้าแตะชุดมีสุขมี 3 แบบตามภาพครับ\r\n👞 ราคาคู่ละ 220บาท\r\n👞 มีไซส์ 39-44ครับ",
      "quick_replies" => array(
        array("content_type" => "text", "title" => "สั่งรองเท้า", 'payload' => 'null'),
        array("content_type" => "text", "title" => "ค่าส่ง", 'payload' => 'null'),
        array("content_type" => "text", "title" => "ติดต่อเจ้าหน้าที่", 'payload' => 'null')
      )
    )
  ),
  'shipping' => array(
    array(
      'text' => ":) ค่าบริการการจัดส่ง สั่งกี่คู่ราคาส่งก็เท่ากันครับ\r\n\r\n📦 จัดส่งด้วย Kerry เก็บเงินปลายทาง: 100บาท\r\n📦 จัดส่งด้วย ไปรษณีย์ไทยแบบ EMS(โอนเงิน): 60บาท\r\n📦 จัดส่งด้วย Kerry แบบธรรมดา(โอนเงิน): 80บาท\r\n📦 จัดส่งด้วย ไปรษณีย์ไทยแบบลงทะเบียนธรรมดา(โอนเงิน): 20บาท\r\n\r\n:) ค่าจัดส่งจะเป็นตามนี้ครับผม",
      "quick_replies" => array(
        array("content_type" => "text", "title" => "สั่งรองเท้า", 'payload' => 'null'),
        array("content_type" => "text", "title" => "ติดต่อเจ้าหน้าที่", 'payload' => 'null')
      )
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
        array("content_type" => "text", "title" => "1.หนีบเรียบ", "payload" => "MS105"),
        array("content_type" => "text", "title" => "2.หนีบลาย", "payload" => "MS106"),
        array("content_type" => "text", "title" => "3.สวม", "payload" => "MS107")
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
        array("content_type" => "text", "title" => "ไปรษณีย์ธรรมดา", "payload" => "$4")
      )
    )
  )
);
$term = array(
  'TD205' => 'หนีบสีน้ำตาลเข้ม',
  'TD206' => 'หนีบสีแทน',
  'TD207' => 'สวม3ชั้นสีน้ำตาลเข้ม',
  'TD208' => 'สวม2ชั้นสีน้ำตาลเข้ม',
  'MS105' => 'หนีบเรียบ',
  'MS106' => 'หนีบลาย',
  'MS107' => 'สวม',
  'TDPrice' => '540',
  'MSPrice' => '220',
  'ship1' => 'Kerry แบบเก็บเงินปลายทาง 100บาท',
  'ship2' => 'ไปรษณีย์ แบบEMS 60บาท',
  'ship3' => 'Kerry แบบธรรมดา 80บาท',
  'ship4' => 'ไปรษณีย์ แบบลงทะเบียนธรรมดา 20บาท',
  'pro' => "✨ โปรโมชั่นส่วนลดพิเศษ 41บาท\r\n"
);

function concat_payloadToResp($payload, $responses) {
  foreach ($responses as &$response)
    if (isset($response['quick_replies']))
      foreach ($response['quick_replies'] as &$reply)
        $reply['payload'] = $payload . $reply['payload'];
  return $responses;
}

function get_responses($payload) {
  global $staticResp;
  return $staticResp[$payload];
}

function process_order($payload) {
  global $resp;
  global $term;

  if (strlen($payload) == 2)
    return $resp[$payload];

  if (strlen($payload) == 5)
    return concat_payloadToResp($payload, $resp[substr($payload, 0, 2) . 'Size']);

  if (strlen($payload) == 8)
    return concat_payloadToResp($payload, $resp['ship']);

  if (strlen($payload) == 10) {
    $model = $term[substr($payload, 0, 5)];
    $size = substr($payload, 6, 2);
    $price = $term[substr($payload, 0, 2) . 'Price'];
    $ship = $term['ship' . substr($payload, 9, 1)];
    $pro = substr($payload, 0, 2) == 'TD' ? $term['pro'] : '';
    $total = 0;
    if (substr($payload, 0, 2) == 'TD')
      $total += 499;
    if (substr($payload, 0, 2) == 'MS')
      $total += 220;
    if (substr($payload, 9, 1) == '1')
      $total += 100;
    if (substr($payload, 9, 1) == '2')
      $total += 60;
    if (substr($payload, 9, 1) == '3')
      $total += 80;
    if (substr($payload, 9, 1) == '4')
      $total += 20;
    $bill = substr($payload, 9, 1) == '1' ? '' : "พร้อมแสดงหลักฐานการโอนเงิน";
    $finalResp = array();
    if (substr($payload, 0, 2) == 'TD')
      $finalResp[] = array('text' => "✨ ตอนนี้มีโปรโมชั่นพิเศษเฉพาะลูกค้าใหม่ทางเฟสบุ๊คนะครับ\r\n✨ เพียงกดไลค์และกดแชร์เพจแก่นขนุนไปที่หน้าวอลของตัวเอง\r\n✨ รับส่วนลดราคารองเท้าพิเศษ 7.5% จาก540บาท เหลือ499บาทได้เลยครับ");
    $finalResp[] = array('text' => "👞 รองเท้าแตะแบบ$model เบอร์$size จำนวน 1คู่ ราคา{$price}บาท\r\n📦 จัดส่งด้วย $ship\r\n{$pro}💰 ทั้งหมด {$total}บาท\r\n\r\n:) รบกวนแจ้ง ชื่อ ที่อยู่ และเบอร์โทรติดต่อ ของผู้รับ{$bill}ด้วยครับผม");
    if (substr($payload, 9, 1) != '1')
      $finalResp[] = array('text' => "🏦 รายละเอียดบัญชี\r\nธนาคาร: กสิกรไทย\r\nชื่อบัญชี: นายภัทกร คูณานุภาพกุล\r\nเลขที่บัญชี: 037-8-35766-7");
    return $finalResp;
  }
}
