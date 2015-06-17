//Função para enviar informações para o servidor; 
function sendAjax(relativeUrl,data,confirmMsg){

  if(confirmMsg != null){
    var execute = confirm(confirmMsg);
    if(!execute){
      $('#info').append('<div data-alert class="alert-box alert radius">Operação cancelada.<a href="#"class="close">x</a></div>'); 
      $(document).foundation();
      return; 
    } 
  }

  $('#load').removeClass('hide'); 
  $.ajax({
      url : relativeUrl, 
      method : "post", 
      data : data 
   }).done(function(data){
      console.log(data);
      data = JSON.parse(data); 
      console.log(data); 
      if( data['status'] == false ){
        $('#info').append('<div data-alert class="alert-box alert radius">'+prepareLogError(data)+'<a href="#"class="close">x</a></div>'); 
      }
      else{
        $('#info').append('<div data-alert class="alert-box success radius">Operação feita com sucesso.<a href="#"class="close">x</a></div>'); 
        clearFieldsInput(); 
      }

      
      
    }).fail(function(){
      console.log('falhou');
      $('#info').append('<div data-alert class="alert-box alert radius">Houve uma falha ao enviar os dados. Tente novamente.<a href="#"class="close">x</a></div>'); 

    }).always(function(){
      $('#load').addClass('hide'); 
      $(document).foundation();
    }); 
}

function clearFieldsInput(){
  $(':input').each(function(){
    $(this).val(''); 
  });
}

function prepareLogError(data){
  var msg ="Alerta de incosistências: <br />"; 
  var x = new Array();

  for( var key in data)
    x.push(key); 

  console.log(x.length,x); 

  for(var a = 0 ; a < x.length ; a++){
    var temp = data[x[a]]; 

    if(!Array.isArray(temp)) continue; 
    msg += x[a]+":<br />";

    for(var b = 0; b < temp.length ; b++){
      msg += "<small>"+temp[b] +"</small><br />";
    }
  }
  return msg; 
}