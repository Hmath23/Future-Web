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
	$('#txtCEP').mask('00000-000');
	$('#txtPhone').mask('(00)00000-0000');
    $('#btnListar').click(function(){
        // alert("Teste");
    	ContatosConsultar();
    });
	$('#btnEnviar').click(function(){
    	ContatosIncluir();
    });
	$('#link_cep').click(function(){
    	BuscaCep();
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

function BuscaCep(){
    var strcep = $('input[id=txtCEP]').val();
    var url = "http://viacep.com.br/ws/"+strcep+"/json";
	//Instanciar o método
	var xmlreq = CriaRequest();
	//Iniciar uma requisição
	xmlreq.open('GET',url,true);
	//Verificar a situação da conexão com o servidor
	xmlreq.onreadystatechange = function(){
		if(xmlreq.readyState == 4){
			if(xmlreq.status == 200){
				preencherCampos(JSON.parse(xmlreq.responseText));
			}
		}
	};
	xmlreq.send(null);
}

function preencherCampos(obj){
	if(obj.erro == "true"){
		$("#dialogo").dialog('open');
			msgHtml = "Cep Inválido"
		$("#mensagem").html(msgHtml);
		$('input[id=txtCEP').val('');
	}
	else{
		$('input[name=txtCEP]').val(obj.cep);
		$('input[name=txtEndereco]').val(obj.logradouro);
		$('input[name=txtBairro]').val(obj.bairro);
		$('input[name=txtCidade]').val(obj.localidade);
		$('input[name=txtUF]').val(obj.uf);
	}
}

function ContatosConsultar(){
    // alert("Teste Método");
    var strnome = $('input[id=txtNome]').val();
	//Definir a url
	var url = "../controllers/ControleContatos.php";
    // var url = "../controllers/ControleContatos.php?page_key=Consultar"+"&txtNome="+strnome+"&HTTP_ACCEPT=application/json";
	//Instanciar o método
	var xmlreq = CriaRequest();
	//Iniciar uma requisição
	xmlreq.open('POST',url,true);
	//Cabeçalho de Envio
	xmlreq.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	//Verificar a situação da conexão com o servidor
	xmlreq.onreadystatechange = function(){
		//Verificar se foi concluído com sucesso e se a conexão não foi fechada (readyState=4)
		if(xmlreq.readyState == 4){
			//Verificar se o status da conexão é 200
			if(xmlreq.status == 200){
				// alert(xmlreq.responseText);
				MostrarContatos(JSON.parse(xmlreq.responseText));
			}
		}
	};
	//Envio dos parâmetros
	xmlreq.send("page_key=Consultar"+"&txtNome="+strnome+"&HTTP_ACCEPT=application/json");
	// xmlreq.send(null);
}

function MostrarContatos(obj){
	var strTabela = "<table><thead><th>Nome</th><th>Email</th><th>Telefone</th><th>CEP</th><th>UF</th></thead>";
	result = document.getElementById('Resultado');
	if(obj.RetornoDados.length > 1){
		for (var i=0;i < obj.RetornoDados.length;i++){
			strTabela += "<tbody><tr><td> " +
			obj.RetornoDados[i].nomedoContato + '</td><td>' +
			obj.RetornoDados[i].emailContato + '</td><td>' +
			obj.RetornoDados[i].telefoneContato + '</td><td>' +
			obj.RetornoDados[i].cep + '</td><td>' +
			obj.RetornoDados[i].uf + '</td></tr>'
		}
		strTabela += "</tbody></table>";
		result.innerHTML = strTabela;
		document.getElementById('formulario').style.display = "none";
		document.getElementById('Resultado').style.display = "block"; 
		//$("#Listagem").modal();
	}
	else{
		$('input[name=txtNome]').val(obj.RetornoDados[0].nomedoContato);
		$('input[name=txtMail]').val(obj.RetornoDados[0].emailContato);
		$('input[name=txtPhone]').val(obj.RetornoDados[0].telefoneContato);
		$('input[name=txtCEP]').val(obj.RetornoDados[0].cep);
		$('input[name=txtEndereco]').val(obj.RetornoDados[0].enderecoContato);
		$('input[name=txtBairro]').val(obj.RetornoDados[0].bairro);
		$('input[name=txtCidade]').val(obj.RetornoDados[0].cidade);
		$('input[name=txtUF]').val(obj.RetornoDados[0].uf);
	}
}

function ContatosIncluir(){
	var controle = 0;
	var controlebotao = 0;

	var itensform = document.forms['frmContatos'];
	var qtditens = itensform.elements.length;

	for (var i = 0; i < qtditens; i++) {
		if (itensform.elements[i].type == 'button' || itensform.elements[i].type == 'reset'){
			controlebotao = 1;
		}
			if(controlebotao == 0){
				if ((itensform.elements[i].type == 'email' || itensform.elements[i].type == 'text') && itensform.elements[i].value == "") {
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
		var strnome = $('input[id=txtNome]').val();
		var stremail = $('input[name=txtMail]').val();
		var strfone = $('input[name=txtPhone]').val().replace(/[^\d]+/g,'');
		var strcep = $('input[name=txtCEP]').val().replace(/[^\d]+/g,'');
		var strendereco = $('input[id=txtEndereco]').val();
		var strbairro =	$('input[name=txtBairro]').val();
		var strcidade = $('input[name=txtCidade]').val();
		var struf =	$('input[name=txtUF]').val();

		var url = "../controllers/ControleContatos.php";

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
		xmlreq.send("page_key=Incluir"+"&txtNome="+strnome+"&txtMail="+stremail+"&txtPhone="+strfone+"&txtCEP="+strcep+"&txtEndereco="+strendereco+"&txtBairro="+strbairro+"&txtCidade="+strcidade+"&txtUF="+struf+"&HTTP_ACCEPT=application/json");
			
		document.getElementById('frmContatos').reset();
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
