<?
$filename=$_GET['filename'];

 $dbnum=mysql_connect("localhost","sysop","sysop");
 //�����Ʈw
 mysql_select_db("lunch");
 //�զX�d�ߦr��
 $SQLSTR="select image,filetype from menu where filename='$filename'";
 //
 $cur=mysql_query($SQLSTR);
 //���X���
 $data=mysql_fetch_array( $cur );

//�]�w������Ʈ榡
header("Content-Type: $data[1]");

// ��X�Ϥ����
$img1 = base64_decode($data[0]);

echo $img1;

?>