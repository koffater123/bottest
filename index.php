<?php
$text = file_get_contents('http://tts.railway.co.th/srttts/view');
echo (stristr ($text, 'กรุงเทพ')) ? 'found' : 'not found';
?>
