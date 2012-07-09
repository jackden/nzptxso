// 檢查欄位
function CheckFields()
{
	// 檢查『店家名稱』欄位
	var fieldvalue = document.getElementById("select1");
	if (fieldvalue.value == "0") 
	{
		alert("請選擇『店家名稱』!");
		fieldvalue.focus();
		return false;
	}
	
	// 檢查『通知內容』欄位
	var fieldvalue = document.getElementById("select2");
	if (fieldvalue.value == "0") 
	{
		alert("請選擇『菜單』!");
		fieldvalue.focus();
		return false;
	}

	var fieldvalue = document.getElementById("upfile");
	if (fieldvalue.value == "") 
	{
		alert("未選擇檔案");
		fieldvalue.focus();
		return false;
	}
	var re = /\.(jpg|gif|jpeg|png|bmp)$/i;  //允許的圖片副檔名
	if (!re.test(fieldvalue.value)) 
	{
		alert("只允許上傳JPG、GIF、PNG、BMP影像檔");
		fieldvalue.focus();
		return false;
	}
}