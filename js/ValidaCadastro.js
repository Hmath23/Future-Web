/** Função para criar um objeto XMLHTTPRequest
*/
// function mcep(t, mask){
//     var i = t.value.length;
//     var saida = mask.substring(1,0);
//     var texto = mask.substring(i)
//     if (texto.substring(0,1) != saida){
//     	t.value += texto.substring(0,1);
//     }
// }
// function mtel(t, mask){
//     var i = t.value.length;
//     var saida = mask.substring(1,0);
//     var texto = mask.substring(i)
//     if (texto.substring(0,1) != saida){
//     	t.value += texto.substring(0,1);
//     }
// }

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
    $('#btnCadast').click(function(){
        //alert("Teste");
    	UsuariosIncluir();
    });
});

$(function(){
	//Dialog
	$('#dialogo').dialog({
		autoOpen: false,
		width: 600,
		buttons:{
			"OK":function(){
				$(this).dialog("close");
			},
		}
	});
});

function UsuariosIncluir(){
	var controle = 0;
	var controlebotao = 0;

	var itensform = document.forms['frmCad'];
	var qtditens = itensform.elements.length;

	for (var i = 0; i < qtditens; i++) {
		if (itensform.elements[i].type == 'button' || itensform.elements[i].type == 'reset'){
			controlebotao = 1;
		}
			if(controlebotao == 0){
				if ((itensform.elements[i].type == 'email' || itensform.elements[i].type == 'text' || itensform.elements[i].type == 'password') && itensform.elements[i].value == "") {
					controle += 1;
					itensform.elements[i].style.background = '#29157E';
					itensform.elements[i].style.color = '#E5E0FA';
				}
				else {
					itensform.elements[i].style.background = '#E5E0FA';
					itensform.elements[i].style.color = '#29157E';
				}
			}
		controlebotao = 0;
	}

	if (controle > 0) {
		$('#dialogo').dialog('open');
			msgHtml = "Favor preencher os campos em destaque";	
		$('#mensagem').html(msgHtml);
	}

	else {
		var strusuario = $('input[id=txtNomeUsuario]').val();
		var stremail = $('input[name=txtEmailUsuario]').val();
		var strsenha = $('input[name=txtSenhaUsuario]').val();

		var url = "../controllers/ControleUsuarios.php";

		var xmlreq = CriaRequest();

		xmlreq.open('POST',url,true);

		xmlreq.setRequestHeader("Content-type","application/x-www-form-urlencoded");

		xmlreq.onreadystatechange = function(){
			if(xmlreq.readyState == 4){
				if(xmlreq.status == 200){
					// alert(xmlreq.responseText);
					confirmarCadastro(JSON.parse(xmlreq.responseText));
				}
			}
		};
		xmlreq.send("page_key=Incluir"+"&txtNomeUsuario="+strusuario+"&txtEmailUsuario="+stremail+"&txtSenhaUsuario="+strsenha+"&HTTP_ACCEPT=application/json");
			
		document.getElementById('frmCad').reset();
	}
}

function confirmarCadastro(obj){
	if(obj.RetornoDados.sucesso == '1'){
		$("#dialogo").dialog('open');
			msgHtml = "Seu cadastro foi realizado com sucesso!"
		$("#mensagem").html(msgHtml);
	}
	else{
		$("#dialogo").dialog('open');
			msgHtml = "Houve um erro com seu cadastro por favor procure o suporte."
		$("#mensagem").html(msgHtml);
	}
}
