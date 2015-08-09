//Autor: Allyson Maciel Guimarães
//url: qual é a url a qual os dados serão enviados; 
//data: os dados que serão enviados para o servidos (no formato Json)
//callback: trata-se da função que será executada quando a requisição for concluída. (Sempre é rotanado algo no callback)
//method: qual é o tipo de transmissão de dados desejada. 


function sendAjax(url, method, data, callback){
	$.ajax({
	  'url'    : url, 
      'method' : method, 
      'data'   : data
	}).done(function(data){
		callback(data); 
	}).fail(function(){
		alertify.error('Ocorreu um erro na transmissão dos dados. Por favor, tente mais tarde.'); 
	}); 
}