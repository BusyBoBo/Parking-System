
<!--��ȡͣ����Ϣ��ѡ�г�λ �����ť ���� ��λռ�úͿ�������ģʽ -->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
 <meta name="viewport" content="width=device-width, initial-scale=1">
       <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
<title>��������ѡ��</title> 
<style> 
    body{ margin:0 auto; padding:0; font-size:12px;text-align:center;background-color:#8FBC8F;} 
a{text-decoration:none;} 
.top_menu{ width:100px; height:30px; line-height:30px;font-size:14px; color:#0000FF; font-weight:bold;background:#C0C0C0; display:block; cursor:pointer;} 
.sub_meuu{width:100px; height:auto; line-height:24px;} 
.sub_meuu a{font-size:12px; color:#00C; display:block; clear:both;} 
    #fan{
        height;60px;
        width:120px;
      
    }
     #fans{
        height;120px;
        width:180px;
        margin:5px 5px;
    }
    #nihao{
        font-size:15px;
    }
     
</style> 
    <img src="http://tryagain3-photo.stor.sinaapp.com/11365395.jpg" height="120px" width=100%>
    <center><h1>��ӭʹ�ö��ͣ��ϵͳ</h1></center><hr />
    <center><h2>ʹ��ָ�ϣ�����ͣ�ó��󣬵��<font color='green' >��ť</font>ѡ����λ����������ģʽ</h2></center>
    <hr />
<script language="javascript"> 
tempj=2; 
function showed(tempi) 
{ 
if(document.getElementById("show"+tempj.toString()).style.display==''&&tempi!=tempj) 
{ 
document.getElementById("show"+tempj.toString()).style.display='none'; 
} 
if(document.getElementById("show"+tempi.toString()).style.display=='none') 
{ 
document.getElementById("show"+tempi.toString()).style.display=''; 
} 
else 
{ 
document.getElementById("show"+tempi.toString()).style.display='none'; 
} 
tempj=tempi; 
} 
</script> 
</head>
    <center>
        <button id='fans'onclick="javascript:showed(1);"><span id='nihao'>A����ѡ��λ</span></button><br>
<div  id="show1" style="display:none;">
    <?php
include("conn.php");
     $str=$_GET[x];   
$user=$_GET[y];
$an=0;
$bn=0;
$string=urldecode($str);  //��URL ������ֵ���н���
for($k=0;$k<strlen($string);$k=$k+5)
{
   
       echo "<input type='hidden' name='fromuser' value='".$user."'>"; //�������α�����΢���û���openid
        $w=$string[$k].$string[$k+1].$string[$k+2].$string[$k+3];   
        if($string[$k]=="A")
            
      { 
            $an++;
         echo "<button id='fan'><span id='nihao'> <a href='car_num.php?x=".$w."&y=".$user."'>";
         echo $w;
       echo "</a></span></button>";}
  
   
}

    ?>
</div> 
       
        <button id='fans' onclick="javascript:showed(2);"><span id='nihao'>B����ѡ��λ</span></button> 
<div  id="show2" style="display:none;">
    <?php

      $str=$_GET[x];   
      $user=$_GET[y];

$string=urldecode($str);  //��URL ������ֵ���н���
for($k=0;$k<strlen($string);$k=$k+5)
{
  
   echo "<input type='hidden' name='fromuser' value='".$user."'>"; //�������α�����΢���û���openid
        $w=$string[$k].$string[$k+1].$string[$k+2].$string[$k+3];   
        if($string[$k]=="B")
            
        {  
            echo "<button id='fan'><span id='nihao'><a href='car_num.php?x=".$w."&y=".$user."'>";
         echo $w;
         echo "</a></span></button>";}
     
   
   
}

    ?></div> 
    </center>


</html> </td>
	  </tr>
	</table>