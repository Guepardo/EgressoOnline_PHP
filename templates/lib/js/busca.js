$(document).ready(function(){

	$("#search_btn").click(function(){
		var value = $("#search_value").val(); 
		redirect('index.php?uc=buscar&a=buscaView&arg='+value,null,'GET'); 
	}); 
}); 