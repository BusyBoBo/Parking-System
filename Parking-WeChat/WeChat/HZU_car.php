/*

΢�Ż������� ���ܴ���

*/

<?php
//װ��ģ���ļ�
session_start();
include_once("wx_tpl.php");
include_once("conn.php");

//��ȡ΢�ŷ�������
$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

  //���ػظ�����
if (!empty($postStr))
    
   {

    	//��������
          $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
    	//������Ϣ��ID
          $fromUsername = $postObj->FromUserName;
    	//������Ϣ��ID
          $toUsername = $postObj->ToUserName;
   	 //��Ϣ����
          $form_MsgType = $postObj->MsgType;
          $form_Event=$postObj->Event;
          $the_time=date('y-m-d');   //���ʱ������з��Ӿ͸�����


//����λ��,��������
          if($form_MsgType=="location")
          {
            //��ȡ������Ϣ��Ϣ����γ�ȣ���ͼ���ű�������ַ
             $from_Location_X=$postObj->Location_X;
             $from_Location_Y=$postObj->Location_Y;
       
            //����ץȡ����
              $f = new SaeFetchurl();
            //ץȡ�ٶȵ�ַ����
              $geocoder = $f->fetch($map_api_url.$map_coord_type."&location=".$from_Location_X.",".$from_Location_Y);
              $msgType = "text";
              //          ���е�ak�����ðٶ�api �� ������˵�ak �ܳף�����
              // $x="http://api.map.baidu.com/telematics/v3/distance?waypoints=118.77147503233,32.054128923368;116.3521416286,39.965780080447;116.28215586757,39.965780080447&ak=gscbdbptoWIduB6nSPfOMXdi";
              // ���Ҹ�������� ͣ����
       
              $url="http://api.map.baidu.com/telematics/v3/distance?callback=myCallback&ak=gscbdbptoWIduB6nSPfOMXdi&waypoints=".$from_Location_Y.",".$from_Location_X.";114.415766,23.031780";
              $apistr=file_get_contents($url);
              $apiobj=simplexml_load_string($apistr);
              $distanceobj=$apiobj->results->distance;
              $juli=intval($distanceobj);
     
              $out="ͣ������������ ".$juli." ��Զ,������ɵ�����ͣ����";
    
              $x="http://2.tryagain3.sinaapp.com/car_tip.php?x=".$from_Location_X."&y=".$from_Location_Y;
             
               $resultStr="<xml>\n
              <ToUserName><![CDATA[".$fromUsername."]]></ToUserName>\n
              <FromUserName><![CDATA[".$toUsername."]]></FromUserName>\n
              <CreateTime>".time()."</CreateTime>\n
              <MsgType><![CDATA[news]]></MsgType>\n
              <ArticleCount>1</ArticleCount>\n
              <Articles>\n
              <item>\n
              <Title><![CDATA[���������ͣ����]]></Title> \n
              <Description><![CDATA[$out]]></Description>\n
              <PicUrl><![CDATA[http://dreamwhat-img.stor.sinaapp.com/u=3116266380,2489126012&fm=21&gp=0.jpg]]></PicUrl>\n
              <Url><![CDATA[$x]]></Url>\n
              </item>\n

              </Articles>\n
              <FuncFlag>0</FuncFlag>\n
              </xml>";
              echo $resultStr;
              exit;  
           
             
          }

        
  	//������Ϣ

          if($form_MsgType=="text" )
          {

           //��ȡ�û����͵���������
            $form_Content = trim($postObj->Content);

	      //���������������ݹؼ��ָֻ���Ӧ��Ϣ
 	        if(!empty($form_Content))
            {
            if($form_Content=='��λ' || $form_Content=='5' )
              {
                   
                $fp = fsockopen("tcp://119.146.68.41", 5000, $errno, $errstr);
              
                if (!$fp)
                {
                    $out= "ERROR: $errno - $errstr\n";
                } else
                {
                   fwrite($fp,"WeChat"."search\n".$fromUsername);

                       $out= fread($fp, 8192);
                       $kk= fread($fp, 8192);
                    fclose($fp);
                      
                }   
    
              $out=mb_convert_encoding($out,"utf-8", "GBK"); 
              $kk=mb_convert_encoding($kk,"utf-8", "GBK"); 
              $resultStr="<xml>\n
              <ToUserName><![CDATA[".$fromUsername."]]></ToUserName>\n
              <FromUserName><![CDATA[".$toUsername."]]></FromUserName>\n
              <CreateTime>".time()."</CreateTime>\n
              <MsgType><![CDATA[news]]></MsgType>\n
              <ArticleCount>1</ArticleCount>\n
              <Articles>\n
              <item>\n
              <Title><![CDATA[�������ռ�ó�λ]]></Title> \n
              <Description><![CDATA[��λ�����$out$kk]]></Description>\n
              <PicUrl><![CDATA[http://dreamwhat-img.stor.sinaapp.com/u=3116266380,2489126012&fm=21&gp=0.jpg]]></PicUrl>\n
              <Url><![CDATA[http://2.tryagain3.sinaapp.com/position.php?x=$kk&y=$fromUsername]]></Url>\n
              </item>\n
              </Articles>\n
              <FuncFlag>0</FuncFlag>\n
              </xml>";   
              echo $resultStr;    
              exit;
 		     }
            
                //���û����� ��ѯ��3��ʱ�򣬷����û���ͣ����Ϣ 
            
              if($form_Content=='��ѯ' || $form_Content=='3' )
              {
                   
                $fp = fsockopen("tcp://119.146.68.41", 5000, $errno, $errstr);
                 if (!$fp)
                 {
                    $out= "ERROR: $errno - $errstr\n";
                 }
                 else
                {
                     
                   fwrite($fp,"WeChat"."look\n".$fromUsername);
                   $out= fread($fp, 1024);
                   fclose($fp);
                      
                }   
 
                $out=mb_convert_encoding($out,"utf-8", "GBK"); 
                $msgType = "text";
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $out."[õ��]");
                echo $resultStr;
                exit;
   
 		   }
                  
                
              
                // ���û��� �����û���������Ϣ����������Ա��½����ģʽ
			 if($form_Content=='admin' ||  $form_Content=='xxx' || $form_Content=='7' || $form_Content=='����')
			{
				 $mmc=memcache_init();//��������
	 
                if($form_Content=='admin'  )
                {
                    memcache_set($mmc,$fromUsername."key",$fromUsername.$form_Content,$flag=0,$expire=15);
                    $contentStr="���������Ա����";
                    $msgType = "text";
                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType,  $contentStr."[õ��]");
                    echo $resultStr; 
                    exit;
                }
               else
                    
                {
               
                    $struser= memcache_get($mmc,$fromUsername."key");
                    if($struser==$fromUsername."admin" )
                    {
                       
                        if($form_Content=='xxx')
                        {
                      
                            //����ҳ���룬����һ����ѯ��λ����������λ�������浽���ݿ���
                            
                            $fp = fsockopen("tcp://119.146.68.41", 5000, $errno, $errstr);
              
                if (!$fp)
                {
                    $out= "ERROR: $errno - $errstr\n";
                } else
                {
                   fwrite($fp,"WeChat"."search\n".$fromUsername);

                       $out= fread($fp, 8192);
                       $kk= fread($fp, 8192);
                    fclose($fp);
                      
                }   
    
               $out=mb_convert_encoding($out,"utf-8", "GBK"); 
               $kk=mb_convert_encoding($kk,"utf-8", "GBK");  //��ó�λ��Ϣ
                            
                            //���������Ϣ���д���              
               $string=$kk;
               $an=0;
               $bn=0;
                for($k=0;$k<strlen($string);$k=$k+5)
                        if($string[$k]=="A")
                                  $an++;      
                    $sqla="update car_num set  a_num='{$an}' where openid='admin'";
                            mysql_query($sqla);  //��A��ճ�λ�ñ��浽���ݿ���
                   for($k=0;$k<strlen($string);$k=$k+5)
                        if($string[$k]=="B")
                                  $bn++;      
                    $sqlb="update car_num set  b_num='{$bn}' where openid='admin'";
                            mysql_query($sqlb);  //��B��ճ�λ�ñ��浽���ݿ���
                 $all=$an+$bn;
                  $sqlab="update car_num set  total='{$all}' where openid='admin'";
                 mysql_query($sqlab);  //ͳ�ƿճ�������
                                     
                            $resultStr="<xml>\n
              <ToUserName><![CDATA[".$fromUsername."]]></ToUserName>\n
              <FromUserName><![CDATA[".$toUsername."]]></FromUserName>\n
              <CreateTime>".time()."</CreateTime>\n
              <MsgType><![CDATA[news]]></MsgType>\n
              <ArticleCount>1</ArticleCount>\n
              <Articles>\n
              <item>\n
              <Title><![CDATA[��ӭ�������Ա����]]></Title> \n
              <Description><![CDATA[]]></Description>\n
              <PicUrl><![CDATA[http://tryagain3-photo.stor.sinaapp.com/administrator.jpg]]></PicUrl>\n
              <Url><![CDATA[http://2.tryagain3.sinaapp.com/admin.php]]></Url>\n
              </item>\n

              </Articles>\n
              <FuncFlag>0</FuncFlag>\n
              </xml>";
              echo $resultStr;
                            
              exit; 
                            
                        } 
                        
                  }
               
                    else
                    {
                        $contentStr="�����������Ա�˺�";
                          $msgType = "text";
                  $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType,  $contentStr."[õ��]");
                  echo $resultStr; 
                  exit; 
                    }
               
                           
                  $msgType = "text";
                  $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType,  $contentStr."[õ��]");
                  echo $resultStr; 
                  exit; 
                } 
              }
                
               
                //���û�����󶨻�2 �������󶨽���,���û��ظ��󶨣���ʾ��Ϣ
            
               if($form_Content=='��' || $form_Content=='2' )
              {
   
             
               $sql="select * from wechat where openid='{$fromUsername}'";
               $query=mysql_query($sql);
               $rs=mysql_fetch_array($query);
               // $weiyi=$rs['openid'];
                   $id=$rs['id'];//���Ϊ1 ˵���û�֮ǰ�󶨳ɹ���
               if($id==1)
               {
                   $tip="���Ѿ��󶨹��ˣ������ظ��󶨣�";
                   $msgType = "text";
                   $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $tip."[õ��]");
                   echo $resultStr;
                   exit;
               }
               else
               { 
                   $sql2="insert  into wechat (openid) values ('{$fromUsername}')";
                   mysql_query($sql2);

              $resultStr="<xml>\n
              <ToUserName><![CDATA[".$fromUsername."]]></ToUserName>\n
              <FromUserName><![CDATA[".$toUsername."]]></FromUserName>\n
              <CreateTime>".time()."</CreateTime>\n
              <MsgType><![CDATA[news]]></MsgType>\n
              <ArticleCount>1</ArticleCount>\n
              <Articles>\n
              <item>\n
              <Title><![CDATA[����󶨳�����Ϣ]]></Title> \n
              <Description><![CDATA[����ң�������������]]></Description>\n
              <PicUrl><![CDATA[http://dreamwhat-img.stor.sinaapp.com/ovDrpjmGFPmHQtgqB9CrY6e_bHDk20150401201959.jpg]]></PicUrl>\n
              <Url><![CDATA[http://2.tryagain3.sinaapp.com/car_user.php?x=$fromUsername]]></Url>\n
              </item>\n
              </Articles>\n
              <FuncFlag>0</FuncFlag>\n
              </xml>";
              echo $resultStr;
              exit;
               }
          
             }
              
                           if($form_Content=='��λ' || $form_Content=='1')
               {
               $fp = fsockopen("tcp://119.146.68.41", 5000, $errno, $errstr);
              
                if (!$fp)
                {
                    $out= "ERROR: $errno - $errstr\n";
                } else
                {
                   fwrite($fp,"WeChat"."search\n".$fromUsername);

                       $out= fread($fp, 8192);
                       $kk= fread($fp, 8192);
                    fclose($fp);
                      
                }   
    
              $out=mb_convert_encoding($out,"utf-8", "GBK"); 
              $kk=mb_convert_encoding($kk,"utf-8", "GBK"); 
                                 $string=$kk;
               $an=0;
               $bn=0;
                for($k=0;$k<strlen($string);$k=$k+5)
                        if($string[$k]=="A")
                                  $an++;      
                
                   for($k=0;$k<strlen($string);$k=$k+5)
                        if($string[$k]=="B")
                                  $bn++;      
                 
                 $all=$an+$bn;
              
                                     
              $msgType = "text";
                               $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, "�𾴵��û�[õ��]��Ŀǰʣ����г�λ�������£�\n�ܿ��г�λ��".$all."��\nA�����г�λ��".$an."��\nB�����г�λ��".$bn."��\n"."[���]");  
                echo $resultStr;
                exit;  
 
             }
                
           
             
            if($form_Content=='���' || $form_Content=='6')
                {
                    
                $fp = fsockopen("tcp://119.146.68.41", 5000, $errno, $errstr);
                
                if (!$fp)
                {
                    $out= "ERROR: $errno - $errstr\n";
                } else
                {
                  
                   
                   fwrite($fp,"WeChat"."free\n".$fromUsername);
                   $out= fread($fp, 1024);
                   fclose($fp);
                      
                }   
              
                $out=mb_convert_encoding($out,"utf-8", "GBK"); 
                $msgType = "text";
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $out."[���]");  
                echo $resultStr;
                exit;  
 
               }
            
               $huida=(explode('+', $form_Content, 4));  //���û���������ݷָȻ��ֱ�洢������
               $huida[1]=mb_convert_encoding($huida[1], "GBK","utf-8"); 
            
               if($form_Content=='�޸�' || $form_Content=='4')
               {
                 
              $resultStr="<xml>\n
              <ToUserName><![CDATA[".$fromUsername."]]></ToUserName>\n
              <FromUserName><![CDATA[".$toUsername."]]></FromUserName>\n
              <CreateTime>".time()."</CreateTime>\n
              <MsgType><![CDATA[news]]></MsgType>\n
              <ArticleCount>1</ArticleCount>\n
              <Articles>\n
              <item>\n
              <Title><![CDATA[����޸ĳ�����Ϣ]]></Title> \n
              <Description><![CDATA[����ң�������������]]></Description>\n
              <PicUrl><![CDATA[http://dreamwhat-img.stor.sinaapp.com/u=3116266380,2489126012&fm=21&gp=0.jpg]]></PicUrl>\n
              <Url><![CDATA[http://2.tryagain3.sinaapp.com/update.info.php?$fromUsername]]></Url>\n
              </item>\n

              </Articles>\n
              <FuncFlag>0</FuncFlag>\n
              </xml>";
              echo $resultStr;
              exit; 
         
        }
            
             $wo=iconv('utf-8','gbk', $form_Content);
             $word=substr($wo,0,3);
             if($word=='use')
               {
                                
                 $fp = fsockopen("tcp://119.146.68.41", 5000, $errno, $errstr);
                 if (!$fp)
                 {
                    $out= "ERROR: $errno - $errstr\n";
                 }
                 else
                {
                     
                   fwrite($fp,"WeChat"."use\n".substr($form_Content,3)."\n".$fromUsername);
                   $out= fread($fp, 1024);
                   fclose($fp);
                      
                }   
 
                $out=mb_convert_encoding($out,"utf-8", "GBK"); 
                $msgType = "text";
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $out."[õ��]");
                echo $resultStr;
                exit;
   
             }
                      
   
               
                 $resultStr="<xml>\n
              <ToUserName><![CDATA[".$fromUsername."]]></ToUserName>\n
              <FromUserName><![CDATA[".$toUsername."]]></FromUserName>\n
              <CreateTime>".time()."</CreateTime>\n
              <MsgType><![CDATA[news]]></MsgType>\n
              <ArticleCount>1</ArticleCount>\n
              <Articles>\n
              <item>\n
              <Title><![CDATA[��ӭʹ��@ �������ͣ��ϵͳ ]]></Title> 
              <Description><![CDATA[0--->���� ����λ����Ϣ ������ͣ����\n1--->���͡�1���򡾳�λ���鿴ʣ�೵λ\n2--->���͡�2���򡾰󶨡����ɰ󶨳�����Ϣ\n3--->���͡�3���򡾲�ѯ�����ɲ�ѯ���󶨵ĳ�����Ϣ\n4--->���͡�4�����޸ġ������޸ĳ�����Ϣ\n5--->���͡�5���򡾷������鿴��ѡ����г�λ����������ģʽ\n6--->���͡�6���򡾽�������ɹرշ���ģʽ\n7--->���͡�7���򡾹������ɽ������Աģʽ\n]]></Description>\n
              <PicUrl><![CDATA[http://tryagain3-photo.stor.sinaapp.com/u=2104178393,2703306304&fm=21&gp=0.jpg]]></PicUrl>\n
            
              </item>\n
              </Articles>\n
              <FuncFlag>0</FuncFlag>\n
              </xml>";
              echo $resultStr;
              exit;
            }      
          
          }   
    
    if( $form_Event=="subscribe")
    {
     
                $resultStr="<xml>\n
              <ToUserName><![CDATA[".$fromUsername."]]></ToUserName>\n
              <FromUserName><![CDATA[".$toUsername."]]></FromUserName>\n
              <CreateTime>".time()."</CreateTime>\n
              <MsgType><![CDATA[news]]></MsgType>\n
              <ArticleCount>1</ArticleCount>\n
              <Articles>\n
              <item>\n
              <Title><![CDATA[��ӭʹ��@ �������ͣ��ϵͳ ]]></Title> 
              <Description><![CDATA[0--->���� ����λ����Ϣ ������ͣ����\n1--->���͡�1���򡾳�λ���鿴ʣ�೵λ\n2--->���͡�2���򡾰󶨡����ɰ󶨳�����Ϣ\n3--->���͡�3���򡾲�ѯ�����ɲ�ѯ���󶨵ĳ�����Ϣ\n4--->���͡�4�����޸ġ������޸ĳ�����Ϣ\n5--->���͡�5���򡾷������鿴��ѡ����г�λ����������ģʽ\n6--->���͡�6���򡾽�������ɹرշ���ģʽ\n7--->���͡�7���򡾹������ɽ������Աģʽ\n]]></Description>\n
              <PicUrl><![CDATA[http://tryagain3-photo.stor.sinaapp.com/u=2104178393,2703306304&fm=21&gp=0.jpg]]></PicUrl>\n
            
              </item>\n
              </Articles>\n
              <FuncFlag>0</FuncFlag>\n
              </xml>";
              echo $resultStr;
              exit;
    }
        

  }

?>