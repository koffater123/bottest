<?php
 include('simple_html_dom.php');
 $html = file_get_html('http://tts.railway.co.th/srttts/view');
 foreach($html->find('table tr td') as $e){
    $arr[] = trim($e->innertext);
  }
  foreach($html->find('font[color="blue"]') as $e){
    $number[] = trim($e->innertext);
  }
  foreach($html->find('font[color="#3d475b"]') as $e){
    $now[] = trim($e->innertext);
  }
  foreach($html->find('font[color="red"],font[color="green"]') as $e){
    $late[] = trim($e->innertext);
  }
  $car=102;
  $numcar=0;
  $foundcar=0;
  $i2=0;
  $i3=0;
  $i4=0;
  for ($i=12;$i<sizeof($arr)-9;$i+=9)
  {
	  $arr[$i] = $number[$i2];
	  $arr[$i+5] = substr($now[$i3],27,-3);
	  $arr[$i+8] = substr($late[$i4],0,-36);
	  if ($i2<sizeof($number)-1) $i2++;
	  if ($i3<sizeof($now)-1) $i3++;
	  if ($i4<sizeof($late)-1) $i4++;
  }
 for ($i=12;$i<sizeof($arr)-9;$i+=9)
  {
	 if ($arr[$i]==$car)
	 {
		 $numcar=$i;
		 $foundcar =1;
		 break;
	 }
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
			//$text = "หมายเลขขบวน ".$arr[12]."\nวันที่ออกต้นทาง ".$arr[13]."\nเวลาออกต้นทาง ".$arr[14]."\nสถานีต้นทาง-ปลายทาง ".$arr[15]."\nเวลาถึงปลายทาง ".$arr[16]."\nถึงสถานี ".$arr[17]."\nเวลาถึง ".$arr[18]."\nเวลาออก ".$arr[19]."\nช้า(นาที) ".$arr[20];
			if ($foundcar==1) {
				$text = "\nขบวนหมายเลข  ".$arr[$numcar]."\nวันที่ออกต้นทาง ".$arr[$numcar+1]."เวลาออกต้นทาง ".$arr[$numcar+2]."สถานีต้นทาง-ปลายทาง".$arr[$numcar+3]."เวลาถึงปลายทาง".$arr[$numcar+4]."ถึงสถานี".$arr[$numcar+5]."เวลาถึง".$arr[$numcar+6]."เวลาออก".$arr[$numcar+7]."ช้า(นาที)".$arr[$numcar+8];
			}
  			else if ($foundcar==0) $text = "ไม่พบขบวนรถ";
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
