/** Função para criar um objeto XMLHTTPRequest
*/

function CriaRequest() {
	try{
		request = new XMLHttpRequest();        
	}
	catch (IEAtual){
		try{
			request = new ActiveXObject("Msxml2.XMLHTTP");       
		}
		catch(IEAntigo){
			try{
				request = new ActiveXObject("Microsoft.XMLHTTP");          
			}
			catch(falha){
				request = false;
			}
		}
	}
	if (!request){ 
		alert("Seu Navegador não suporta Ajax!");
	}
	else{
		return request;
	}
}

$(document).ready(function(){
    $('#btnListar').click(function(){
    //    alert("Teste");
    ContatosConsultar();
    });
});

function ContatosConsultar(){
    //alert("Teste Método");
    var strnome = $('input[id=txtNome]').val();
    var url ="";
}