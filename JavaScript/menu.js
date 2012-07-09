// 檢查欄位
function CheckFields()
{		
	// 檢查『菜單筆數』欄位
	var fieldvalue = document.getElementById("menuCount").value;
	if (fieldvalue == "") 
	{
		alert("『菜單筆數』欄位不可以是空白!");
		document.getElementById("menuCount").focus();
		return false;
	}
	if (fieldvalue == 0)
	{
		alert("『菜單筆數』欄位不能為0份!");
		document.getElementById("menuCount").focus();
		return false;
	}
	var re = /^[0-9]+$/;
	if (!re.test(fieldvalue))
	{
		alert("『菜單筆數』欄位必須為數字!");
		document.getElementById("menuCount").focus();
		return false;
	}
}

// 檢查欄位
function CheckFields1()
{		
	// 檢查『名稱』欄位
	var fieldvalue = document.getElementsByName('foodName[]');
	for (var i=0;i<fieldvalue.length;i++) {
		if (fieldvalue[i].value == "") 
		{
			alert("『名稱』欄位不可以是空白!");
			fieldvalue[i].focus();
			return false;
		}
	}
	
	// 檢查『價格』欄位
	var fieldvalue = document.getElementsByName('foodPrice[]');
	for (var i=0;i<fieldvalue.length;i++) {
		if (fieldvalue[i].value == "") 
		{
			alert("『價格』欄位不可以是空白!");
			fieldvalue[i].focus();
			return false;
		}
		var re = /^[0-9]+$/;
		if (!re.test(fieldvalue[i].value))
		{
			alert("『價格』欄位必須為數字!");
			fieldvalue[i].focus();
			return false;
		}
	}
}