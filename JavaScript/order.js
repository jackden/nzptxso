// 檢查欄位
function CheckFields()
{
	// 檢查『姓名』欄位
	var fieldvalue = document.getElementById("userName").value;
	if (fieldvalue == "") 
	{
		alert("『姓名』欄位不可以是空白!");
		document.getElementById("userName").focus();
		return false;
	}
		
	// 檢查『餐點』欄位
	var checkit = false;
	for (var i=0;i<foodName.length;i++) {
		if (foodName[i].checked) {checkit=true;break;}
	}
	if (!checkit) {
		alert("沒有選擇『餐點』!");
		return false;
	}
	
	// 檢查『數量』欄位
	var fieldvalue2 = document.getElementById("foodCount").value;
	if (fieldvalue2 == "")
	{
		alert("『數量』欄位不可以是空白!");
		document.getElementById("foodCount").focus();
		return false;
	}
	if (fieldvalue2 == 0)
	{
		alert("『數量』欄位不能為0份!");
		document.getElementById("foodCount").focus();
		return false;
	}
	var re = /^[0-9]+$/;
	if (!re.test(fieldvalue2))
	{
		alert("『數量』欄位必須為數字!");
		document.getElementById("foodCount").focus();
		return false;
	}
	

}