
<!--���û��޸ĵ���Ϣ�ύ��������-->

<?php
//��������Ϣ�޸ĺ� �������ݱ��浽���ݿ�

header("Content-type: text/html; charset=utf8"); 

   $na=$_POST["username"];
    $na=mb_convert_encoding($na, "GBK","utf-8"); 
    $ph=$_POST["phone"];
    $no=$_POST["number"];
    $no=mb_convert_encoding($no, "GBK","utf-8"); 
    $wid=$_POST['wechatid'];


       $fp = fsockopen("tcp://119.146.68.41", 5000, $errno, $errstr);
              
                if (!$fp)
                {
                    $out= "ERROR: $errno - $errstr\n";
                } else
                {
                  
             
                    fwrite($fp,"WeChat"."update"."\n".$na."\n".$ph."\n".$no."\n".$wid);
                
                        $out= fread($fp, 1024);
                        $kk= fread($fp, 1024);
                    fclose($fp);
                      
                }   
               
              
                $out=mb_convert_encoding($out,"utf-8", "GBK"); 
                $kk=mb_convert_encoding($kk,"utf-8", "GBK"); 
 echo "<center><br><br><br><h2><font color='green'>".$out.$kk."<br>������Ͻǹرս��档</font></h2></center>";              
?>
<meta name="viewport" content="width=device-width, initial-scale=1">
