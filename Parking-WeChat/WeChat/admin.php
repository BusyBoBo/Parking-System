 <!--����Աģʽ��飬ʵ��ͣ�������г�λ�鿴���ƹ����-->

 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <meta name="viewport" content="width=device-width, initial-scale=1">


<?php

 $fp = fsockopen("tcp://119.146.68.41", 5000, $errno, $errstr);
              
                if (!$fp)
                {
                    $out= "ERROR: $errno - $errstr\n";
                } else
                {
                   fwrite($fp,"WeChat"."admin"."\n"."xxx");

                       $out= fread($fp,8192 );
                        $kk= fread($fp, 8192);
                     $dd= fread($fp, 8192);
                    fclose($fp);
                    // echo "���ͳɹ���";
                    $out=mb_convert_encoding($out,"utf-8", "GBK"); 
                     $kk=mb_convert_encoding($kk,"utf-8", "GBK"); 
                      $dd=mb_convert_encoding($dd,"utf-8", "GBK"); 
                    //  echo "�յ�����ϢΪ:".$out.$kk.$dd;

                }

                
//$out.$kk="LIGHT00006LX,Status:1";

$data=$out.$kk.$dd;
//$data="A001101010B010101110110101LIGHT00006LX,Status:1";
$pos= strpos($data,'L');
$new=substr($data,$pos,21);
$liangdu= substr($new,5,5);
$t=substr($new,20,1);
if($t=='1')
$two='����';
else
$two='�ر�';

               
?>
<head>        
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
     <script>
         function aa(osel)
         {
             if(osel.options[osel.selectedIndex].value=='1')
              document.getElementById("co").innerHTML="<button id='u'>����</button> <button id='u'>�ص�</button>";
            
            
             if(osel.options[osel.selectedIndex].value=='0')
             { document.getElementById("co").innerHTML="<button id='u'><a href='light.php?x=LIGHTON'><span id='s'>����</span></a></button> <button  id='u'><a href='light.php?x=LIGHTOFF'><span id='s'>�ص�</span></a></button>";
              }
              
                 
         }
  </script>
   
<style>
    #u{
        color:#C0C0C0;
        height:30px;
        width:60px;
        
        
    }
  
     #s{
        color:blue;   
        
    }
    #ui
    {color:white;
    }
  
    body{
background-color:#87CEFA;
}
    </style>
    
</head>
<body>
<div id='ui'>
<center>
<center><h2>��ӭʹ�ù���Աģʽ��</h2></center>
    <hr />
<h3>�ƹ����ģʽѡ��:<h3>
    <form method="POST" >
    <select name="xuan" onchange="aa(this)">
    <option  selected="selected" value="1">�Զ�ģʽ</option>
    <option  value="0">�ֶ�ģʽ</option>
    </select>
    </form>
    
    <div id='co'><button id='u'>����</button> <button id='u'>�ص�</button></div>
  
   <br>
  

<span>������״̬��</span><input style="width:70px" type="text" value="<?php echo $two;?>"><br>
    <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;����ֵ��</span><input style="width:70px" type="text" value="<?php echo $liangdu.' LX';?>">
    <hr />
    <h3>���г�λ״��</h3>
    
   &nbsp;&nbsp;&nbsp;�ܿ��г�λ��: <input type="text"  style="width:60px" value="<?php include('conn.php');$all='select * from car_num ';
$query=mysql_query($all);
$row=mysql_fetch_array($query);
echo $row['total'];
?>"><br>
    A�����г�λ��: <input type="text" style="width:60px" value="<?php  include('conn.php'); $all='select * from car_num ';
$query=mysql_query($all);
$row=mysql_fetch_array($query);
echo $row['a_num']; ?>"><br>
    B�����г�λ��: <input type="text" style="width:60px" value="<?php  include('conn.php'); $all='select * from car_num ';
$query=mysql_query($all);
$row=mysql_fetch_array($query);
echo $row['b_num']; ?>"><br>
    </hr />    
    </center>
    </div>
    </body>

