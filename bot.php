<?php
	$i2;
 include('simple_html_dom.php');
 $html = file_get_html('http://tts.railway.co.th/srttts/view');
 foreach($html->find('table tr td') as $e){
    $arr[] = trim($e->innertext);
  }
  foreach($html->find('font[color="blue"]') as $e){
    $number[] = trim($e->innertext);
  }
  $i2=0;
  for ($i=12;$i<sizeof($arr)-9;$i+=9)
  {
	  $arr[$i] = $number[$i2];
	  //print_r($arr[$i]);
	  if ($i2<sizeof($number)-1) $i2++;
	  //echo "\r\n";
  }

$access_token = 'EZhc3qkbHr8CzNimKi8y3eZbY+C897upwPu/0Np+4I1XhliJCxBVY9oCjPgAB9SXA69lnCGL/O7Qw+81fWTeJJyeQShqZDNXBjFU1VGPJ0XeIGXVS7DFD197JIBBcyUzfMuVj5gjKqm2F2amX+mj/AdB04t89/1O/w1cDnyilFU=';
// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
// Validate parsed JSON data
if (!is_null($events['events'])) {
	// Loop through each event
	foreach ($events['events'] as $event) {
		// Reply only when message sent is in 'text' format
		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
			// Get text sent
			//$text = $event['message']['text'];
			$text = "ขบวนหมายเลข  ".$arr[12].\n."วันที่ออกต้นทาง ".$arr[13]."เวลาออกต้นทาง ".$arr[14];
			// Get replyToken
			$replyToken = $event['replyToken'];
			// Build message to reply back
			$messages = [
				'type' => 'text',
				'text' => $text
			];
			// Make a POST Request to Messaging API to reply to sender
			$url = 'https://api.line.me/v2/bot/message/reply';
			$data = [
				'replyToken' => $replyToken,
				'messages' => [$messages],
				
				
			];
			$post = json_encode($data);
			$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			$result = curl_exec($ch);
			curl_close($ch);
			echo $result . "\r\n";
		}
	}
}
echo "OK";
