// 檢查欄位
function CheckFields()
{
	// 檢查『店家名稱』欄位
	var fieldvalue = document.getElementById("shopName").value;
	if (fieldvalue == "") 
	{
		alert("『店家名稱』欄位不可以是空白!");
		document.getElementById("shopName").focus();
		return false;
	}
	
	// 檢查『店家電話』欄位
	var fieldvalue = document.getElementById("shopPhone").value;
	if (fieldvalue == "") 
	{
		alert("『店家電話』欄位不可以是空白!");
		document.getElementById("shopPhone").focus();
		return false;
	}
}