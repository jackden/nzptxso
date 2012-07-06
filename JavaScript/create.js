// 檢查欄位
function CheckFields()
{	
	// 檢查『主揪姓名』欄位
	var fieldvalue = document.getElementById("primaryName").value;
	if (fieldvalue == "") 
	{
		alert("『主揪姓名』欄位不可以是空白!");
		document.getElementById("primaryName").focus();
		return false;
	}
		
	// 檢查『店家』欄位
	var checkit = false;
	for (var i=0;i<shopName.length;i++) {
		if (shopName[i].checked) {checkit=true;break;}
	}
	if (!checkit) {alert("沒有選擇『店家』!");return false;} 
}