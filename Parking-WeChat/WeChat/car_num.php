
<!--����ѡ��λ�Ϳ�������ģʽ�󣬽��շ�������������Ϣ-->

 <meta name="viewport" content="width=device-width, initial-scale=1">
<head>        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> </head>

<?php

    $imfo=$_GET['x'];
    $user=$_GET['y'];
   

    
                  $fp = fsockopen("tcp://119.146.68.41", 5000, $errno, $errstr);
                if (!$fp)
                {
                    $out= "ERROR: $errno - $errstr\n";
                } 
                else
                {
                   fwrite($fp,"WeChat"."use\n". $imfo."\n".$user);
                   $out= fread($fp, 1024);
                   fclose($fp);
                      
                }   
 
                $out=mb_convert_encoding($out,"utf-8", "GBK"); 
 
     echo "<center><br><h1><font color='green'>ͣ����Ϣ���£�<br><br> <font color='blue'>".$out."</font><br><br></font><br></center>";
 
 



?>