
/* �����ֶ�ģʽ��  ���ƣ���صƵ���Ϣ��������  */

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
$im=$_GET['x'];
$fp = fsockopen("tcp://119.146.68.41", 5000, $errno, $errstr);
              
                if (!$fp)
                {
                    $out= "ERROR: $errno - $errstr\n";
                } else
                {
                     fwrite($fp,"WeChat"."admin"."\n"."xxx"."MANUAL");
                  
                       $out= fread($fp, 256);
                    echo $out;
                   
                    fclose($fp);   

                }
$fp = fsockopen("tcp://119.146.68.41", 5000, $errno, $errstr);
              
                if (!$fp)
                {
                    $out= "ERROR: $errno - $errstr\n";
                } else
                {
                     fwrite($fp,"WeChat"."admin"."\n"."xxx".$im);
                  
                       $out= fread($fp, 256);
                    echo $out;
                    fclose($fp);   

                }
echo '<script language="javascript">
alert("�ύ�ɹ�");
window.history.back(-1);
</script> ';


?>