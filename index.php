<? /*Formulário com dados de curriculos
   Fabiane Balz Gabriel - 27/05/2019*/

header("Pragma: no-cache");
header("Cache: no-cahce");

include( "lib/conexao.php"  );
$acao    = ($_GET[acao])?$_GET[acao]:$_POST[acao];
$dfroid  = ($_GET[dfroid])?$_GET[dfroid]:$_POST[dfroid];

if($acao == "editar"){
    $query  = "select dfrnome,dfremail,dfrexperiencia,dfrformacao,dfrtelefone,dfrusuario,dfrsenha from dados_formulario where dfroid = $dfroid;";
    //echo $query;
    $resultado = pg_query($conexao,$query);
    $arr_res=pg_fetch_array($resultado,0);
    $chave=array_keys($arr_res);
    for ($i = 0; $i < sizeof($arr_res); $i++)
        $_POST[$chave[$i]] = $arr_res[$chave[$i]];
}

if($acao == "excluir"){
	pg_query($conexao,"begin");
    $query  = "update dados_formulario set dfrexclusao = now() where dfroid = $dfroid;";
    //echo $query;
	if(pg_query($conexao,$query)){
		$mensagem = "Registro excluido com sucesso";
		pg_query($conexao,"end");
		unset($_POST);
	}
	else{
		$mensagem= "Não foi possível excluir o registro nesse momento.";
		pg_query($conexao,"rollback");
	}
}

if($acao == "confirmar"){
	pg_query($conexao,"begin");
    $dfrnome        = $_POST['dfrnome'];
    $dfremail       = $_POST['dfremail'];
    $dfrexperiencia = $_POST['dfrexperiencia'];
    $dfrformacao    = $_POST['dfrformacao'];
    $dfrtelefone    = $_POST['dfrtelefone'];
    $dfrusuario     = $_POST['dfrusuario'];
    $dfrsenha       = $_POST['dfrsenha'];

    if($dfroid > 0){
    	$query = "update dados_formulario set dfrnome        = '$dfrnome',
    	                                      dfremail       = '$dfremail',
    	                                      dfrexperiencia = '$dfrexperiencia',
    	                                      dfrformacao    = '$dfrformacao',
    	                                      dfrtelefone    = '$dfrtelefone',
    	                                      dfrusuario     = '$dfrusuario',
    	                                      dfrsenha       = '$dfrsenha'
    	          where dfroid = $dfroid;";
		//echo $query;
		if(pg_query($conexao,$query)){
			$mensagem = "Dados alterados com sucesso!";
			pg_query($conexao,"end");
			unset($_POST);
		}
		else{
			$mensagem= "Não foi possível aterar os dados nesse momento.";
			pg_query($conexao,"rollback");
		}
    }
    else{
		$query = "insert into dados_formulario(dfrnome,dfremail,dfrexperiencia,dfrformacao,dfrtelefone,dfrusuario,dfrsenha,dfrcadastro)
		                                values('$dfrnome', '$dfremail','$dfrexperiencia','$dfrformacao', '$dfrtelefone', '$dfrusuario', '$dfrsenha', now()) RETURNING dfroid;";
		//echo $query;
		$resultado = pg_query($conexao,$query);
		if($resultado){
			$_POST[dfroid] = $dfroid = pg_fetch_result($resultado,0,0);
			$mensagem= "Dados inseridos com sucesso!";
			pg_query($conexao,"end");
			unset($_POST);
		}
		else{
			$mensagem= "Não foi possível incluir os dados nesse momento.";
			pg_query($conexao,"rollback");
		}
	}
}?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br" lang="pt-br">
  <head>
    <title>Teste - Formulário de Dados</title>
    <meta charset="utf-8">
    <link href="css/style_site.css" rel="stylesheet" type="text/css">
	<script language="JavaScript">
		function editar(id){
			if(confirm('Deseja efetuar a edição do Cadastro selecionado?')){
				document.form.dfroid.value = id;
				document.form.acao.value  = 'editar';
				document.form.submit();
			}
		}

		function excluir(id){
			if(confirm('Deseja efetuar a exclusao do Cadastro selecionado?')){
				document.form.dfroid.value = id;
				document.form.acao.value  = 'excluir';
				document.form.submit();
			}
		}

		function escreve_div( nome, str ) {
		    eval( "objTemp = document.getElementById('" + nome + "');" );
		    if (typeof objTemp != "undefined" ) {
		        objTemp.innerHTML=str;
		    }
		}

		function limpa_texto(texto,uppercase,acentos){
		    if(uppercase==1){
		        texto=texto.toUpperCase();
		    }
		    if(acentos==1){
		        texto=texto.replace("Ã","A");texto=texto.replace("Â","A");texto=texto.replace("Á","A");
		        texto=texto.replace("À","A");texto=texto.replace("Ä","A");texto=texto.replace("Ê","E");
		        texto=texto.replace("É","E");texto=texto.replace("È","E");texto=texto.replace("Ë","E");
		        texto=texto.replace("Î","I");texto=texto.replace("Í","I");texto=texto.replace("Ì","I");
		        texto=texto.replace("Ï","I");texto=texto.replace("Õ","O");texto=texto.replace("Ô","O");
		        texto=texto.replace("Ó","O");texto=texto.replace("Ò","O");texto=texto.replace("Ö","O");
		        texto=texto.replace("Ú","U");texto=texto.replace("Ù","U");texto=texto.replace("Û","U");
		        texto=texto.replace("Ü","U");texto=texto.replace("Ç","C");
		        texto=texto.replace("ã","a");texto=texto.replace("â","a");texto=texto.replace("á","a");
		        texto=texto.replace("à","a");texto=texto.replace("ä","a");texto=texto.replace("ê","e");
		        texto=texto.replace("é","e");texto=texto.replace("è","e");texto=texto.replace("ë","e");
		        texto=texto.replace("î","i");texto=texto.replace("í","i");texto=texto.replace("ì","i");
		        texto=texto.replace("ï","i");texto=texto.replace("õ","o");texto=texto.replace("ô","o");
		        texto=texto.replace("ó","o");texto=texto.replace("ò","o");texto=texto.replace("ö","o");
		        texto=texto.replace("ú","u");texto=texto.replace("ù","u");texto=texto.replace("û","u");
		        texto=texto.replace("ü","u");texto=texto.replace("ç","c");
		        texto=texto.replace("`","");
		        texto=texto.replace("^","");texto=texto.replace("~","");texto=texto.replace("!","");
		        texto=texto.replace("@","");texto=texto.replace("#","");texto=texto.replace("$","");
		        texto=texto.replace("%","");texto=texto.replace("+","");texto=texto.replace("=","");
		        texto=texto.replace("§","");texto=texto.replace("£","");texto=texto.replace("¢","");
		        texto=texto.replace("Ñ","N");texto=texto.replace("Ñ","N");
		        //texto=texto.replace("\\","");texto=texto.replace("/","");
		        texto=texto.replace("<","");texto=texto.replace(">","");texto=texto.replace("?","");
		        texto=texto.replace(";","");texto=texto.replace("{","");texto=texto.replace("}","");
		    }
		    texto=texto.replace("'","");
		    texto=texto.replace(/"/,"");

		    return texto;
		}

		function formatar_fone(src){
		    ddd = "";
		    len = src.value.length;
		    //alert(len);
		    fone = src.value;
		    fone = fone.toString().replace( "-", "" );
		    fone = fone.toString().replace( "-", "" );
		    fone = fone.toString().replace( ".", "" );
		    fone = fone.toString().replace( ".", "" );
		    fone = fone.toString().replace( "/", "" );
		    fone = fone.toString().replace( "/", "" );
		    fone = fone.toString().replace( "(", "" );
		    fone = fone.toString().replace( "(", "" );
		    fone = fone.toString().replace( ")", "" );
		    fone = fone.toString().replace( ")", "" );
		    fone = fone.toString().replace( " ", "" );
		    fone = fone.toString().replace( " ", "" );
		    if (fone.substr(0,4) != '0800' && fone.substr(0,4) != '0300'){
		      ddd = '('+fone.substr(0,2)+')';
		      if(len <= 10){
		          fone = fone.substr(2,4)+'-'+fone.substr(6);
		      }else{
		         if(len > 10){
		             fone = fone.substr(2,5)+'-'+fone.substr(7);
		         }
		      }
		    }
		    src.value = ddd+fone;
		}

		function numero(evtKeyPress,virgula,menos,ponto){
		    var nTecla = 0;
		    if (document.all) {
		        nTecla = evtKeyPress.keyCode;
		    }else{
		        nTecla = evtKeyPress.which;
		    }

		    if((nTecla> 47 && nTecla <58) || nTecla == 8 || nTecla == 127 || nTecla == 0 || nTecla == 9  || nTecla == 13 || (nTecla == 44 && virgula) || (nTecla == 45 && menos) || (nTecla == 46 && ponto)){
		        return true;
		    }else{
		        return false;
		    }
		}

		function set_acao(){
		    /*atribuindo obrigatoriedade nos campos de email e fone*/
			if(document.form.dfrtelefone.value == ""){
				document.getElementById('dfremail').setAttribute("obrigatorio",1);
			}
			else{
				document.getElementById('dfremail').setAttribute("obrigatorio",0);
			}

			if(document.form.dfremail.value == ""){
				document.getElementById('dfrtelefone').setAttribute("obrigatorio",1);
			}
			else{
				document.getElementById('dfrtelefone').setAttribute("obrigatorio",0);
			}


   			/*iniciando validação de obrigatoriedade dos campos*/
			pode_enviar  = true;
	        txt_mensagem = "";

	    	for ( var i = 0; i < document.form.elements.length; i++ ){
	        	obj = document.form.elements[ i ];
	        	obj.className = "";

	        	nome_campo = obj.name;
	            obr = obj.getAttribute("obrigatorio");
	            obj.className = "form_field";
	            if (obr!=1)
	            	obr=0;
	        	else if(obj.value == ""){
	            	obj.className = "form_field_error";
	            	pode_enviar   = false;
	            	txt_mensagem  = "<font color=\"0000FF\">Mensagem:</font> <font color=\"FF0000\"> Os campos destacados são obrigatórios!</font>";
	        	}
	    	}
	    	if(pode_enviar){
	    	    /*Confere se senha e confere senha esta correta*/
			    var nova_senha  = document.form.dfrsenha.value;
			    var confirmacao = document.form.usuconfsenha.value;
   	            if (nova_senha != confirmacao){
   	                pode_enviar   = false;
   	                txt_mensagem  = "<font color=\"0000FF\">Mensagem:</font> <font color=\"FF0000\">Atenção! A  Senha deve ser igual a Confirmação da Senha. Verifique!</font>";
   	                document.form.usuconfsenha.value = "";
				}
	    	    if(pode_enviar){
		      		document.form.acao.value = 'confirmar';
		      		document.form.submit();
	      		}
	      		else{
		        	escreve_div("mensagem",txt_mensagem);
		        	document.location='<?$PHP_SELF?>#top';
	    		}
	    	}
	    	else{
	        	escreve_div("mensagem",txt_mensagem);
	        	document.location='<?$PHP_SELF?>#top';
	    	}
		}
    </script>
  </head>
  <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
    <form name="form" enctype="multipart/form-data" method="post" action="index.php">
      <input type="hidden" name="acao" value="<?=$acao?>">
      <input type="hidden" name="dfroid" value="<?=$dfroid?>">
      <br>
	  <table width="80%" class="padrao" align="center" cellpadding="0" cellspacing="2" border="0">
		<tr>
			<td><span class="titulo_paginterna">NOS ENVIE SEU CURRICULUM</span></td>
		</tr>
		<tr height="20px"><td colspan="2">&nbsp;&nbsp;</td></tr>
		<tr>
			<td class="textarial10cinza" colspan="2">
				<div name="mensagem" id="mensagem" class="msg"></div>
			</td>
		</tr>
		<?if($mensagem){?>
			<tr>
				<td width="100%" class="textarial10cinza" colspan="2">
					<span class="msgE_error">Mensagem:</span><span class="msg_error"><?=$mensagem?></span>
				</td>
			</tr>
		<?}?>
		<tr> <td class="form_titulo">Dados Pessoais</td></tr>
		<tr>
			<td height="35" class="titulo_noticia" align="right" nowrap>* Nome Completo:</td>
			<td>
				<input name="dfrnome"  id="dfrnome" type="text" class="form" style="width:400px"  value="<?=$_POST[dfrnome]?>" obrigatorio="1" onblur="this.value=limpa_texto(this.value,1,1);">
			</td>
		</tr>
		<tr>
			<td height="35" class="titulo_noticia" align="right" nowrap>* E-mail:</td>
			<td>
				<input name="dfremail" id="dfremail" type="text" class="form" style="width:400px" onblur="seta_obrigatorio(email);"  value="<?=$_POST[dfremail]?>" obrigatorio="0">
			</td>
		</tr>
		<tr>
			<td height="35" class="titulo_noticia" align="right" nowrap>* Telefone:</td>
			<td>
				<input name="dfrtelefone" id="dfrtelefone" type="text" class="form" style="width:150px"   onblur="seta_obrigatorio(fone);" value="<?=$_POST[dfrtelefone]?>"  obrigatorio="0" onBlur="formatar_fone(this);" onkeypress="return numero(event);">
			</td>
		</tr>
		<tr height="20px"><td colspan="2">&nbsp;&nbsp;</td></tr>
		<tr> <td class="form_titulo">Dados Profissionais</td></tr>
		<tr>
			<td height="35" class="titulo_noticia" align="right" nowrap>Experiência:</td>
			<td>
				<textarea name="dfrexperiencia"  id="dfrexperiencia" class="form_field" style="width:400px" rows="3"><?=htmlspecialchars_decode($_POST['dfrexperiencia'])?></textarea>
			</td>
		</tr>
		<tr>
			<td height="35" class="titulo_noticia" align="right" nowrap>Formação:</td>
			<td>
				<textarea name="dfrformacao"  id="dfrformacao" class="form_field" style="width:400px" rows="3"><?=htmlspecialchars_decode($_POST['dfrformacao'])?></textarea>
			</td>
		</tr>
		<tr height="20px"><td colspan="2">&nbsp;&nbsp;</td></tr>
		<tr> <td class="form_titulo">Dados de Acesso</td></tr>
		<tr>
			<td height="35" class="titulo_noticia" align="right" nowrap>Usuário:</td>
			<td>
				<input name="dfrusuario"  id="dfrusuario" type="text" class="form" style="width:200px"  value="<?=$_POST[dfrusuario]?>" obrigatorio="1">
			</td>
		</tr>
		<tr>
			<td height="35" class="titulo_noticia" align="right" nowrap>Senha:</td>
			<td>
				<input name="dfrsenha"  id="dfrsenha" type="password" class="form" style="width:200px"  value="<?=$_POST[dfrsenha]?>" obrigatorio="1">
			</td>
		</tr>
		<tr>
			<td height="35" class="titulo_noticia" align="right" nowrap>Confirme sua Senha:</td>
			<td>
				<input name="usuconfsenha"  id="usuconfsenha" type="password" class="form" style="width:200px"  value="<?=$_POST[usuconfsenha]?>" obrigatorio="1">
			</td>
		</tr>
		<tr height="15px"><td>&nbsp;&nbsp;</td></tr>
		<tr>
			<td colspan="2" align="center">
				<div id="botaoeviar">
					<input class="botaoform" type="button" name="confirmar" value="Confirmar" onclick="javascript:set_acao('confirmar');">
				</div>
			</td>
		</tr>
	  </table>

      <!-- PESQUISA DE CURRICULOS CADASTRADOS --> <?
      $query  = "select dfroid,dfrnome,dfremail,dfrtelefone,dfrusuario,to_char(dfrcadastro,'dd/mm/yyyy') as dfrcadastro
                 from dados_formulario where dfrexclusao is null order by dfrnome;";
     //echo $query;
     $resultado_pesquisa = pg_query($conexao,$query);
	 if (pg_num_rows($resultado_pesquisa)>0){ ?>
            <br><br>
            <table width="80%" class="padrao" align="center" cellpadding="0" cellspacing="2" border="0">
			  <tr>
                <td class="titulo_paginterna" colspan="8">LISTAGEM DE CURRICULOS CADASTRADOS</td>
              </tr>
              <tr>
                <td class="form_titulo">NOME</td>
                <td width="12%" class="form_titulo" align="center">E-MAIL</td>
                <td width="8%" class="form_titulo" align="center">TELEFONE</td>
                <td width="8%" class="form_titulo" align="center">USUARIO</td>
                <td width="15%" class="form_titulo" align="center">CADASTRO</td>
                <td width="10%" class="form_titulo" align="center" nowrap>AÇÕES</td>
              </tr><?
              $cor = "#F6F6F6";
              for ($i = 0; $i < pg_num_rows($resultado_pesquisa);$i++){
                $arr_res =pg_fetch_array($resultado_pesquisa,$i); ?>
                <tr bgcolor="<?=$cor?>">
                  <td class='form_label' align="left" nowrap><span class="resumo_noticia"><?=$arr_res["dfrnome"];?></font></td>
                  <td class='form_label' align="right" nowrap><span class="resumo_noticia"><?=$arr_res["dfremail"];?></font></td>
                  <td class='form_label' align="right" nowrap><span class="resumo_noticia"><?=$arr_res["dfrtelefone"];?></font></td>
                  <td class='form_label' align="right" nowrap><span class="resumo_noticia"><?=$arr_res["dfrusuario"];?></font></td>
                  <td class='form_label' align="right" nowrap><span class="resumo_noticia"><?=$arr_res["dfrcadastro"];?></font></td>
                  <td class='form_label' align="center"><span class="resumo_noticia">
                      <a href="javascript:editar('<?=$arr_res[dfroid];?>');" title="Editar Dados"><img src="imgs/spellcheck.gif" border="0"></a>  |
                      <a href="javascript:excluir('<?=$arr_res[dfroid];?>');" title="Excluir Cadastro"><img src="imgs/pt_errado.gif" border="0"></a>
                  </td>
                </tr><?
                if($cor == "#FFFFFF")
                    $cor = "#F6F6F6";
                else
                    $cor = "#FFFFFF";
              }?>
              <tr height="8px"><td>&nbsp;&nbsp;</td></tr>
             <tr class="form_titulo">
              <td colspan="15" class="form_titulo"><center><?=$i?> registro(s) encontrado(s)</center> </td>
             </tr>
             <tr height="15px"><td>&nbsp;&nbsp;</td></tr>
            </table>
            <br><?
     }?>
    </form>
  </body>
</html>