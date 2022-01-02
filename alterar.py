#importando selenium
from selenium import webdriver
#importando biblioteca json
import json
#importando biblioteca time -> para usar o Sleep
import time

ENDERECO_ADMIN = "http://pw2/GuarnieriStore/admin/"
ENDERECO_CATEGORIA = "http://pw2/GuarnieriStore/admin/categoria.php"
ENDERECO_JSON_CATEGORIA = "JSON/lista_categorias.json"
EMAIL_ADMIN = "gfguarnieri@hotmail.com"
SENHA_ADMIN = "123456"

NAVEGADOR = webdriver.Chrome(r"c:\driver\chromedriver.exe")

def logar():
    #Acessando o endereço do painel admin
    NAVEGADOR.get(ENDERECO_ADMIN)
    #Pegando os campos da tela de login
    inputEmail = NAVEGADOR.find_element_by_id("email")
    inputSenha = NAVEGADOR.find_element_by_id("senha")
    btnLogar = NAVEGADOR.find_element_by_css_selector("input[type=submit]")

    #Passando os valores para os campos
    inputEmail.send_keys(EMAIL_ADMIN)
    inputSenha.send_keys(SENHA_ADMIN)    

    #Clicando no btnLogar
    btnLogar.click()

def cadastrarCategoria(nomeCategoria, descricaoCategoria):
    NAVEGADOR.get(ENDERECO_CATEGORIA)  
    #Pegando elementos necessários da página de cadastro
    btnAbrirForm = NAVEGADOR.find_element_by_css_selector("#btndados")
    txtNome = NAVEGADOR.find_element_by_css_selector("#txtnome")
    txtDescricao = NAVEGADOR.find_element_by_css_selector("#txtdescricao")
    btnCadastrar = NAVEGADOR.find_element_by_css_selector("#btncadastrar")
    #Abrindo formulário
    btnAbrirForm.click()
    time.sleep(0.5)
    #Mandando texto para os campos de texto
    txtNome.send_keys(nomeCategoria)
    txtDescricao.send_keys(descricaoCategoria)
    #clicando no botão cadastrar
    btnCadastrar.click()

def excluirCategoria(idCategoria):
    NAVEGADOR.get(ENDERECO_CATEGORIA)
    NAVEGADOR.execute_script("confirmacao("+str(idCategoria)+")")
    btnConfirmar = NAVEGADOR.find_element_by_id("linkexclusao")
    time.sleep(0.5)
    btnConfirmar.click()
    time.sleep(0.5)

def pegarIDsCategoria():
    NAVEGADOR.get(ENDERECO_CATEGORIA)
    todosIDs = NAVEGADOR.find_elements_by_css_selector("tbody tr td:nth-child(1)")
    # Criando array que armazenará os IDs das categorias identificadas
    listaID = []
    for elementoID in todosIDs:
        #pegando o conteúdo interno da celula - no caso, o ID
        IDCat = elementoID.get_attribute("innerText")
        #adicionando IDCat ao array
        listaID.append(IDCat)
    return listaID

def alterarCategoria(idCategoria):
    NAVEGADOR.get(ENDERECO_CATEGORIA+"?id="+str(idCategoria))
    txtNome = NAVEGADOR.find_element_by_css_selector("#txtnome")
    txtDescricao = NAVEGADOR.find_element_by_css_selector("#txtdescricao")
    nomeMa =  txtNome.get_attribute("value").upper()
    descricaoMa = txtDescricao.get_attribute("value").upper()    
    time.sleep(0.5)
    txtNome.clear()
    txtDescricao.clear()
    txtNome.send_keys(nomeMa)
    txtDescricao.send_keys(descricaoMa)    
    btnSalvar = NAVEGADOR.find_element_by_css_selector("#btncadastrar")
    btnSalvar.click()
    time.sleep(1)

#Chamando função LOGAR
logar()

listaID = pegarIDsCategoria()

# Alterando categorias
for ID in listaID:
    alterarCategoria(ID)
    time.sleep(0.5)



# EXCLUSÃO DE CATEGORIA -----------------------------------
# listaID = pegarIDsCategoria()
# #Com o array completo, executando estrutura de repetição de exclusão
# for ID in listaID:
#     excluirCategoria(ID)


# CADASTRO DE CATEGORIA -----------------------------------
#Ler arquivo JSON
# ARQUIVO_CATEGORIA = open(ENDERECO_JSON_CATEGORIA, encoding='utf-8')
# JSON_CATEGORIA = json.load(ARQUIVO_CATEGORIA)

# for cat in JSON_CATEGORIA:    
#     #Chamando função cadastrar Categoria
#     cadastrarCategoria(cat["nome"], cat["descricao"])