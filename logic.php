<?php
require_once "conversation.php";

$LOGICS = array(
  array(
    "matchers" => array(
      array("type" => "exact", "value" => "สอบถามค่าบริการจัดส่ง")
    ),
    "return" => array(
      array('text' => $CONVERSATION['shipping'])
    )
  ),
  array(
    'matchers' => array(
      array("type" => "regex", "value" => "/ปลายทาง.*(มั้ย|ไหม|ป่ะ|นะ)/")
    ),
    'return' => array(
      array('text' => $CONVERSATION['COD'])
    )
  ),
  array(
    "matchers" => array(
      array("type" => "exact", "value" => "สอบถามชุดธุดงค์")
    ),
    "return" => array(
      array('text' => $CONVERSATION['TD']),
      array("attachment" => array(
        "type" => "image",
        "payload" => array(
          "url" => "https://kkn-chat.herokuapp.com/img/td.mix.png",
          "is_reusable" => true
        )
      ))
    )
  ),
  array(
    "matchers" => array(
      array("type" => "exact", "value" => "สอบถามชุดมีสุข")
    ),
    "return" => array(
      array('text' => $CONVERSATION['MS']),
      array("attachment" => array(
        "type" => "image",
        "payload" => array(
          "url" => "https://kkn-chat.herokuapp.com/img/ms.mix.png",
          "is_reusable" => true
        )
      ))
    )
  )
);

function get_responses($text) {
  global $LOGICS;
  foreach ($LOGICS as $logic) {
    foreach ($logic['matchers'] as $matcher) {
      if (
        ($matcher['type'] == 'exact' && $text == $matcher['value']) ||
        ($matcher['type'] == 'regex' && preg_match($matcher['value'], $text))
      )
        return $logic['return'];
    }
  }
}