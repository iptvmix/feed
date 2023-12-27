
<?php

 $kaynak = file_get_contents("http://showmax.com.tr/canliyayin");

 preg_match('#ht_stream_m3u8":"(.*?)"#', $kaynak,$m3ual); 
 echo stripslashes($m3ual[1]); 
?>



