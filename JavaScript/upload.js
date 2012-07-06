// 檢查欄位
function CheckFields()
{
	// 檢查『店家名稱』欄位
	var fieldvalue = select1.value;
	if (fieldvalue == "0") 
	{
		alert("請選擇『店家名稱』!");
		select1.focus();
		return false;
	}
	
	// 檢查『通知內容』欄位
	var fieldvalue = select2.value;
	if (fieldvalue == "0") 
	{
		alert("請選擇『菜單』!");
		select2.focus();
		return false;
	}

	var fieldvalue = upfile.value;
	if (fieldvalue == "") 
	{
		alert("未選擇檔案");
		upfile.focus();
		return false;
	}
	var re = /\.(jpg|gif|jpeg|png|bmp)$/i;  //允許的圖片副檔名
	if (!re.test(fieldvalue)) 
	{
		alert("只允許上傳JPG、GIF、PNG、BMP影像檔");
		upfile.focus();
		return false;
	}
}