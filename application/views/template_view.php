<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Адмін панель</title>
<style>
       @font-face {
               font-family: WILOPlusFMRegular; /* Имя шрифта */
               src: url("<?=ROOT_DIRECTORY?>/fonts/WILOPlusFMReg.ttf"); /* Путь к файлу со шрифтом */
               }
       @font-face {
               font-family: Glyphicons Halflings;
               src: url("<?=ROOT_DIRECTORY?>/fonts/glyphicons-halflings-regular.eot");
               src: url("<?=ROOT_DIRECTORY?>/fonts/glyphicons-halflings-regular.eot?#iefix") format("embedded-opentype"), url("<?=ROOT_DIRECTORY?>/fonts/glyphicons-halflings-regular.woff2") format("woff2"), url("<?=ROOT_DIRECTORY?>/fonts/glyphicons-halflings-regular.woff") format("woff"), url("<?=ROOT_DIRECTORY?>/fonts/glyphicons-halflings-regular.ttf") format("truetype"), url("<?=ROOT_DIRECTORY?>/fonts/glyphicons-halflings-regular.svg#glyphicons_halflingsregular") format("svg");
               }
</style>
<script language="javascript" type="text/javascript" src="<?=ROOT_DIRECTORY?>/js/jquery-2.1.3.js"></script>
<link rel="stylesheet" href="<?=ROOT_DIRECTORY?>/css/bootstrap.css">
<link href="<?=ROOT_DIRECTORY?>/css/main.css" rel="stylesheet" type="text/css"/>
<script src="<?=ROOT_DIRECTORY?>/js/bootstrap.js" type="text/javascript"></script>
<link href="<?=ROOT_DIRECTORY?>/css/bootstrap-table.css" rel="stylesheet" type="text/css"/>
<link href="<?=ROOT_DIRECTORY?>/css/dragtable.css" rel="stylesheet" type="text/css"/>
<link href="<?=ROOT_DIRECTORY?>/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css"/>
<script src="<?=ROOT_DIRECTORY?>/js/bootstrap-table.js" type="text/javascript"></script>
<script src="<?=ROOT_DIRECTORY?>/js/bootstrap-table-uk-UA.js" type="text/javascript"></script>
<script src="<?=ROOT_DIRECTORY?>/js/jquery.form.js" type="text/javascript"></script>
<script src="<?=ROOT_DIRECTORY?>/js/jquery.toaster.js" type="text/javascript"></script>
<script src="<?=ROOT_DIRECTORY?>/js/jquery.mask.js" type="text/javascript"></script>
<script src="<?=ROOT_DIRECTORY?>/js/extensions/export/bootstrap-table-export.js" type="text/javascript"></script>
<script src="<?=ROOT_DIRECTORY?>/js/tableExport.js" type="text/javascript"></script>
<script src="<?=ROOT_DIRECTORY?>/libs/FileSaver/FileSaver.min.js" type="text/javascript"></script>
<script src="<?=ROOT_DIRECTORY?>/js/extensions/filter-control/bootstrap-table-filter-control.js" type="text/javascript"></script>
<script src="<?=ROOT_DIRECTORY?>/js/extensions/mobile/bootstrap-table-mobile.js" type="text/javascript"></script>
<script src="<?=ROOT_DIRECTORY?>/js/jquery-ui.js" type="text/javascript"></script>
<script src="<?=ROOT_DIRECTORY?>/js/jquery.dragtable.js" type="text/javascript"></script>
<script src="<?=ROOT_DIRECTORY?>/js/extensions/reorder-columns/bootstrap-table-reorder-columns.js" type="text/javascript"></script>
<script src="<?=ROOT_DIRECTORY?>/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?=ROOT_DIRECTORY?>/js/bootstrap-datepicker.uk.min.js" type="text/javascript"></script>

<script type="text/javascript">
$(function() {
    $('.input-daterange').datepicker({
        format: "dd.mm.yyyy",
        language: "uk"
    });
    
    $('.feedback').click(function(){
        $('#feedback').modal('show');
    });

    $('.subscribe').click(function(){
        $('#subscribe').modal('show');
    });

    $('#subscribeSubmitButton').click(function(){
        $.ajax({
            url: "<?=ROOT_DIRECTORY?>/login/subscribe",
            type: 'POST',
            datatype: "json",
            contentType: "application/x-www-form-urlencoded",
            async: false,
            data:  {email: $('#subscribeemail').val()},
            success: function (data, status) {
                data = JSON.parse(data);
                $('#subscribe').modal('hide');
                $.toaster(data.status);
            }
        });
    });

    $('#feedbackSubmitButton').click(function(){
        $.ajax({
            url: "<?=ROOT_DIRECTORY?>/login/feedback",
            type: 'POST',
            datatype: "json",
            contentType: "application/x-www-form-urlencoded",
            async: false,
            data:  {
                    email: $('#feedbackemail').val(),
                    question: $('#text').val(),
                    name: $('#name').val()
                    },
            success: function (data, status) {
                data = JSON.parse(data);
                $('#feedback').modal('hide');
                $.toaster(data.status);
            }
        });
    });
            
    $(".auth").click(function(){
        id = $(this).attr("id");
        $.ajax({
            url: "<?=ROOT_DIRECTORY?>/login",
            type: 'POST',
            datatype: "json",
            contentType: "application/x-www-form-urlencoded",
            async: false,
          data:  {authtype: id},
          success: function (data, status) {
                window.location.href = "<?=ROOT_DIRECTORY?>/login"
                    }
        });
    });
});
        
function getJSONFormData(formData) {
    //            If you are sending a form with JSON you must remove [] in sending the string. 
    //            You can do that with the jQuery function serializeObject():
    formData = JSON.stringify(formData.serializeArray());
    var arr = [];
    formData = JSON.parse(formData);
    for(var index in formData) { 
          arr.push('"'+formData[index].name+'":"'+formData[index].value+'"');
    }    
    var result_str = "{"+arr.join(',').toString()+"}";
    return JSON.parse(result_str);
} 
        
        //This function serialize sub tags e.g. system : {1,2,3}
$.fn.serializeFormJSON = function () {
     var o = {};
     var a = this.serializeArray();
     $.each(a, function () {
         if (o[this.name]) {
             if (!o[this.name].push) {
                 o[this.name] = [o[this.name]];
             }
             o[this.name].push(this.value || '');
         } else {
             o[this.name] = this.value || '';
         }
     });
     return o;
 };
</script>     
</head>
<body>
    <div class="container-fluid">
        <div class="row-fluid">
            <?php include_once FULL_PATH.'/application/views/'.$content_view; ?>
</body>
</html>