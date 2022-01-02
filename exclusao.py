from selenium import webdriver
import json 
import time

navegador = webdriver.Chrome(r"C:\driver\chromedriver.exe")
endereco_cad = "http://trabalhos/DSIII/Cadastro%20com%20Selenium/site/cliente.php"

navegador.get(endereco_cad)
links = navegador.find_elements_by_css_selector('tbody tr td:nth-child(1)')

arrIds = []

for link in links:
    arrIds.append(link.get_attribute('innerText'))

def excluir(id):
    navegador.get(endereco_cad)
    btnExcluir = navegador.find_element_by_link_text('Excluir')
    btnExcluir.click()


for id in arrIds:
    excluir(id)
    time.sleep(0.5)
    alert = navegador.switch_to_alert()
    alert.accept()