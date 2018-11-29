<!--<script type="text/javascript" src="login_view.js"></script>-->
<script type="text/javascript">
 $(function() {      

    $('input#agreement').click(function(){
        $.post( 
            "<?=ROOT_DIRECTORY?>/login/setAgreement", 
            {login: $("#inputLogin").val()},
            function( data ) {
                $data = JSON.parse(data);
                if ($data.status.priority === 'success'){
                    window.location.href = "<?=ROOT_DIRECTORY?>/cabinet";
                }
//                else {
//                    alert($data.status.title+$data.status.message);
//                }
            }
        ); 
    });
    
    $("#loginButton").click(function(){

        $.ajax({
          url: "<?=ROOT_DIRECTORY?>/login/check",
          type: 'POST',
          datatype: "json",
          contentType: "application/x-www-form-urlencoded",
          async: false,
          data:  
            {
                login:           $("#inputLogin").val(),
                password:        $("#inputPassword").val()
            } , 
          success: function (data, status) {
          
              status1 = JSON.parse(data);
              
             
              if (status1.success) {
                                              
                //Проверяем есть ли у пользователя соглашение на хранение данных
                if (status1.agreement === 'N') {
                    $('#agreement').modal('show');
                }
                else {
                  window.location.href = "<?=ROOT_DIRECTORY?>/cabinet";
                }
              } 
              else {
                  $('#alerts').append(
                    '<div class="alert alert-danger alert-dismissible" role="alert">' +
                    '<button type="button" class="close" data-dismiss="alert">' +
                   '&times;</button><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span><strong>Увага</strong> Не знайдено користувача з такими даними.</div>');
              }  
          } 
        })
        .error(function(){
                 $("#output").text("Неможливо з'єднатися з сервером!");
        } ) ;
    });
    $("#enduserButton").click(function(){
       if(isValidEmailAddress($("#byer_email").val())){
           //alert('Email correct');
        
            $.ajax({
                url: "<?=ROOT_DIRECTORY?>/login/generatelink",
                type: 'POST',
                datatype: "json",
                contentType: "application/x-www-form-urlencoded",
                async: false,
                data:  
                    {
                        byer_name:         $("#byer_name").val(),
                        byer_email:        $("#byer_email").val()
                    } , 
                success: function (data, status) {
                    //data = JSON.parse(data);
                    //alert("OK");
                    $('#alerts').append(
                    '<div class="alert alert-success alert-dismissible" role="alert">' +
                    '<button type="button" class="close" data-dismiss="alert">' +
                   '&times;</button></span><strong>Увага</strong> На ваш email вислано лінк для входу на сайт. Перевірте поштову скриньку.</div>');
                    $('#enduserButton').remove();
                    $('input#byer_name').prop('readonly', true);
                    $('input#byer_email').prop('readonly', true);
                    }  
                })
                .error(function(){
                        $.toaster({ title : '<br>'+"Виникла помилка", priority : 'danger',  message : '<br>Неможливо з\'єднатися з сервером' });
                    });
        }
        else{
            $.toaster({ title : '<br>'+"Перевірка форми", priority : 'danger',  message : '<br>Email некорректний' });
        }
    });
});    
</script>
<div class="row ">
    <?php include FULL_PATH.'/application/views/'.$data['url'];?>
</div>

