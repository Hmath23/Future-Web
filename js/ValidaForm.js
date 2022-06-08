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
        // alert("Teste");
    ContatosConsultar();
    });
});

function ContatosConsultar(){
    // alert("Teste Método");
    var strnome = $('input[id=txtNome]').val();
	//Definir a url
    var url = "../controllers/ControleContatos.php?page_key=Consultar"+"&txtNome="+strnome+"&HTTP_ACCEPT=application/json";

	//Instanciar o método
	var xmlreq = CriaRequest();
	//Iniciar uma requisição
	xmlreq.open('GET',url,true);

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
	// xmlreq.send("page_key=Consultar"+"&txtNome="+strnome+"&HTTP_ACCEPT=application/json");
	xmlreq.send(null);
}

function MostrarContatos(obj){
	var strTabela = "<table border=1><thead><th>Nome</th><th>Email</th><th>Telefone</th><th>CEP</th><th>Endereço</th><th>Bairro</th><th>Cidade</th><th>UF</th></thead>";
	result = document.getElementById('Resultado');
	if(obj.RetornoDados.length > 1){
		for (var i=0;i < obj.RetornoDados.length;i++){
			strTabela += "<tbody><tr><td>" +
			obj.RetornoDados[i].nomedoContato + '</td><td>' +
			obj.RetornoDados[i].emailContato + '</td><td>' +
			obj.RetornoDados[i].telefoneContato + '</td><td>' +
			obj.RetornoDados[i].cep + '</td><td>' +
			obj.RetornoDados[i].enderecoContato + '</td><td>' +
			obj.RetornoDados[i].bairro + '</td><td>' +
			obj.RetornoDados[i].cidade + '</td><td>' +
			obj.RetornoDados[i].uf + '</td></tr>'
		}
		strTabela += "</tbody></table>";
		result.innerHTML = strTabela;
	}
	else{
		$('input[name=txtNome]').val(obj.RetornoDados[i].nomedoContato);
		$('input[name=txtMail]').val(obj.RetornoDados[i].emailContato);
		$('input[name=txtPhone]').val(obj.RetornoDados[i].telefoneContato);
		$('input[name=txtCEP]').val(obj.RetornoDados[i].cep);
		$('input[name=txtEndereco]').val(obj.RetornoDados[i].enderecoContato);
		$('input[name=txtBairro]').val(obj.RetornoDados[i].bairro);
		$('input[name=txtCidade]').val(obj.RetornoDados[i].cidade);
		$('input[name=txtUF]').val(obj.RetornoDados[i].uf);
	}
}

