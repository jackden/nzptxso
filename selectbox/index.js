$(function () {

    // 判斷是否有預設值
    var defaultValue = false;
    if (0 < $.trim($('#fullIdPath').val()).length) {
        $fullIdPath = $('#fullIdPath').val().split(',');
        defaultValue = true;
    }
    
    // 設定預設選項
    if (defaultValue) {
        $('#select1').selectOptions($fullIdPath[0]); 
    }
    
    // 開始產生關聯下拉式選單
    $('#select1').change(function () {
        // 觸發第二階下拉式選單
        $('#select2').removeOption(/.?/).ajaxAddOption(
            'action.php', 
            { 'id': $(this).val(), 'lv': 2 }, 
            false, 
            function () {
                
                // 設定預設選項
                if (defaultValue) {
                    $(this).selectOptions($fullIdPath[1]).trigger('change');
                } else {
                    $(this).selectOptions().trigger('change');
                }
            }
        ).change(function () {
            // 觸發第三階下拉式選單
            $('#select3').removeOption(/.?/).ajaxAddOption(
                'action.php', 
                { 'id': $(this).val(), 'lv': 3 }, 
                false, 
                function () {
                
                    // 設定預設選項
                    if (defaultValue) {
                        $(this).selectOptions($fullIdPath[2]);
                    }
                }
            );
        });
    }).trigger('change');

    // 全部選擇完畢後，顯示所選擇的選項
    $('#select3').change(function () {
        alert('店家：' + $('#select1 option:selected').text() + 
              '／菜單：' + $('#select2 option:selected').text() +
              '／價錢：' + $('#select3 option:selected').text());
    });
});