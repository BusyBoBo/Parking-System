package serverReply;

import java.io.DataOutputStream;
import java.io.IOException;
import java.sql.ResultSet;
import java.sql.SQLException;

import dataBaseDrive.DataDrive;

class CarFunctionality {
	static final CarFunctionality s=new CarFunctionality();
	//collect all the functionality of client-side program. 
	//to simply the process of creating special kind of client-side program
	public void userAdd(DataDrive dbms,String s, DataOutputStream out) throws IOException{
		System.out.println("s="+s);
		String[] values=s.split("\n");
		int i=values.length;
		System.out.println(i);
		if(values[i-1].indexOf("_")!=-1){
			values[i-1]=values[i-1].replace('_','a');
		}
		if(values[i-1].indexOf("-")!=-1){
			values[i-1]=values[i-1].replace('-','s');
		}
		boolean success=dbms.insert("client", "WechatName,userName,carNum,telephone","\'"+values[i-1]+"\',\'"+values[i-4]
				+"\',\'"+values[i-2]+"\',\'"+values[i-3]+'\'');
		if(success){
			out.write("�󶨳ɹ�".getBytes());
		}else{
			out.write("��ʧ��".getBytes()); 
		}
//		System.out.println(vaules[i-1]+","+vaules[i-4]
//				+","+vaules[i-3]+","+vaules[i-2]);
	}
	
	public void informationUp(DataDrive dbms,String s, DataOutputStream out) throws IOException{
		String[] values=s.split("\n");
		System.out.println(s);
//		int i=vaules.length;
		boolean success=false;
		if(values[4].indexOf("_")!=-1){
			values[4]=values[4].replace('_','a');
		}
		if(values[4].indexOf("-")!=-1){
			values[4]=values[4].replace('-','s');
		}
//		for(int j=i;j>=0;j--){
			
		    success=dbms.update("client","userName=\'"+values[1]
		    		+"\',telephone=\'"+values[2]+"\'"
		    		+ ",carNum=\'"+values[3]+'\'',"WechatName=\'"+values[4]+'\'');
			
//		}
		if(success){
			out.write("���³ɹ�".getBytes());
		}
		
	}
	
	public void searchFree(DataDrive dbms,String s, DataOutputStream out) throws SQLException, IOException{
		ResultSet result=null;
		result=dbms.search("count(��λ��)","carState","��λ״̬=0");
		if(result.next()){
				if(result.getInt(1)>0){
					
					out.write(("��"+result.getInt(1)+"�����г�λ\n").getBytes());
					result=dbms.search("��λ��", "carState", "��λ״̬=0");
					
					while(result.next()){
						out.write((result.getString(1)+" ").getBytes());
						
//					System.out.println("result");
					}
				}
				else{
					out.write("��λ����".getBytes());
				}
		}
		result.close();
	}
	
	
	public void positionUsed(DataDrive dbms,String s, DataOutputStream out) throws SQLException, IOException{
//		System.err.print(s);
		String[] values=s.split("\n");
		ResultSet result=dbms.search("*", "position", "��λ��=\'"+values[1]+"\'");
//		System.err.print("��λ��=\'"+values[1]+'\'');
		if(!result.next()){
			
			//if(result.getString(1).equals("1")&&result.getString(2).equals("0")){
				s=values[1];
				System.out.println(values[2]);
				
				//WeChat name process
				if(values[2].indexOf("_")!=-1){
					values[2]=values[2].replace('_','a');
					
				}
				
				if(values[2].indexOf("-")!=-1){
					values[2]=values[2].replace('-','s');
				}
//				Values=values[2].split("_");
				if(dbms.insert("position", "WechatName,��λ��","\'"+values[2]+"\',"+"\'"+s+"\'")
//				   &&dbms.update("carState","����ģʽ=1","��λ��=\'"+s+'\'')
//						&&dbms.update("carState","��λ״̬=1","��λ��=\'"+s+'\'')
				   ){
					out.write("��λռ�óɹ�,����ģʽ�ѿ���".getBytes());
//					System.err.println("s="+s);
				}
				else{
					out.write("����δ����ó�λ".getBytes());
				}
//				System.err.print("\'"+values[0]+values[1]+"\',"+"\'"+s+"\'"+"��λ��=\'"+s+'\'');
		}
		else{
			out.write("�ó�λ�ѱ�����ʹ��".getBytes());
		}
		result.close();
	}
	
	
	public void positionFree(DataDrive dbms,String s, DataOutputStream out) throws SQLException, IOException{
		String[] values=s.split("\n");
		
		if(values[1].indexOf("_")!=-1){
			
			values[1]=values[1].replace('_', 'a');
		}
		if(values[1].indexOf("-")!=-1){
			values[1]=values[1].replace('-', 's');
		}
//		values=values[1].split("_");
//		Values[1]=values[0]+values[1];
		ResultSet result=dbms.search("��λ��", "position", "WeChatName=\'"+values[1]+"\'");
		
		if(result.next()){
			s=result.getString(1);
			if(//dbms.update("carState", "����ģʽ=0", "��λ��=\'"+s+"\'and ����ģʽ=1")
			   dbms.delete("position", " ", "WeChatName=\'"+values[1]+"\'")
				){
				out.write("����ģʽ�ر�".getBytes());
				
			}
			else{
				out.write("����ģʽ�ر��쳣".getBytes());
			}
			
		}
		else{
			out.write("��δʹ����һ��λ".getBytes());
		}
		result.close();
	}
	public void userCheck(DataDrive dbms,String s, DataOutputStream out) throws IOException{
		String[] values=s.split("\n");
		if(values[1].indexOf("_")!=-1){
			
			values[1]=values[1].replace('_', 'a');
		}
		if(values[1].indexOf("-")!=-1){
			values[1]=values[1].replace('-', 's');
		}
		try {
//			System.err.print(values[1]+"client.WechatName=\'"+values[1]+"\' and position.WechatName=client.WechatName");
			
			ResultSet result=dbms.search("userName,telephone,carNum","client", "WechatName=\'"+values[1]+"\'");
		
			if(result.next()){
				s="����:"+result.getString(1)+"\n�绰:"+result.getString(2)+"\n���ƺ�:"+result.getString(3);
				result=dbms.search("��λ��","position", "WechatName=\'"+values[1]+"\'");
				if(result.next()){
					s+="\n��λ��:"+result.getString(1);
				}
				else{
					s+="\n��δʹ�ó�λ";
				}
				out.write(s.getBytes());
			}
			else {
				out.write("��δע��".getBytes());
			}
			result.close();
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		
	}
	
}
