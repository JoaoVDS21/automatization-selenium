<?php

    include_once("bd/conexao.php");

    $codigo = "NOVO";
    $nome = "";
    $sobrenome = "";
    $email = "";
    $cidade = "";
    $empresaatual = "";
    $filtrar = "%%";

    if(isset($_POST["txtnome"])){
        $nome = $_POST["txtnome"];
        $sobrenome = $_POST["txtsobrenome"];
        $email = $_POST["txtemail"];
        $cidade = $_POST["txtcidade"];
        $empresaatual = $_POST["txtempresaatual"];
        $id = $_POST["txtcodigo"];
        $sql = "INSERT INTO cliente VALUES(0,:nome, :sobrenome, :email, :cidade, :empresaatual)";
        if(is_numeric($id)){
            $sql = "UPDATE cliente SET nome=:nome, sobrenome=:sobrenome, email=:email, cidade=:cidade, empresaatual=:empresaatual WHERE id=:id";
        }                        
        $comando = $conexao->prepare($sql);
        $comando->bindParam(":nome", $nome);
        $comando->bindParam(":sobrenome", $sobrenome);
        $comando->bindParam(":email", $email);
        $comando->bindParam(":cidade", $cidade);
        $comando->bindParam(":empresaatual", $empresaatual);        
        if(is_numeric($id)){
            $comando->bindParam(":id", $id);
        }
        $comando->execute();
        echo "<script>alert('Salvo com sucesso');window.open('cliente.php', '_top');</script>";
        exit;
    }

    else if(isset($_GET["atualizar"])){
        $id = $_GET["atualizar"];
        $sql = "SELECT * FROM cliente WHERE id=:id";
        $comando = $conexao->prepare($sql);
        $comando->bindParam(":id", $id);
        $comando->execute();
        $dado = $comando->fetch(PDO::FETCH_ASSOC);
        $codigo = $dado["id"];
        $nome = $dado["nome"];
        $sobrenome = $dado["sobrenome"];
        $email = $dado["email"];
        $cidade = $dado["cidade"];
        $empresaatual = $dado["empresaatual"];        
    }

    else if(isset($_GET["excluir"])){
        $id = $_GET["excluir"];
        $sql = "DELETE FROM cliente WHERE id=:id";
        $comando = $conexao->prepare($sql);
        $comando->bindParam(":id", $id);
        $comando->execute();
        echo "<script>alert('Item excluído com sucesso');window.open('cliente.php', '_top');</script>";        
        exit;
    }
    
    if(isset($_GET["filtrar"]))
        $filtrar = "%".$_GET["filtrar"]."%";
    

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Atividade 3 - QTS - Cadastro com Selenium</title>
</head>
<body>    
    <header>
        <img src="imgs/logo.png">
        <h1>Gerenciar Cliente</h1>
    </header>
    <main>   
        <a href="index.php">Voltar para Início</a>             
        <form action="cliente.php" method="post">                        
            <div class="campo">
                <label for="unidadeAtual">Código</label>
                <input type="text" name="txtcodigo" id="txtcodigo" value="<?= htmlentities($codigo) ?>" readonly>
                </select>
            </div>
            <div class="campo">
                <label for="valor">Nome</label>
                <input type="text" name="txtnome" id="txtnome" value="<?= htmlentities($nome) ?>">
            </div>
            <div class="campo">
                <label for="valor">Sobrenome</label>
                <input type="text" name="txtsobrenome" id="txtsobrenome" value="<?= htmlentities($sobrenome) ?>">
            </div>
            <div class="campo">
                <label for="valor">Email</label>
                <input type="text" name="txtemail" id="txtemail" value="<?= htmlentities($email) ?>">
            </div>
            <div class="campo">
                <label for="valor">Cidade</label>
                <input type="text" name="txtcidade" id="txtcidade" value="<?= htmlentities($cidade) ?>">
            </div>
            <div class="campo">
                <label for="valor">Empresa Atual</label>
                <input type="text" name="txtempresaatual" id="txtempresaatual" value="<?= htmlentities($empresaatual) ?>">
            </div>            
            <button id="btnCadastrar">Salvar</button>                   
        </form> 
        <div class="lista">          
            <h1>Lista de Clientes</h1>
            <form action="cliente.php" method="get">
                <div class="campo">
                    <label for="filtrar">Filtrar pelo título: </label>
                    <input type="text" id="filtrar" name="filtrar">
                    <button>Filtrar</button>
                </div>
            </form>
            <table>
                <thead>
                    <th>Código</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Opções</th>
                </thead>
                <tbody>
                <?php
                    $sql = "SELECT id, nome, email FROM cliente WHERE nome LIKE :nome ORDER BY nome";
                    $comandoConsulta = $conexao->prepare($sql);
                    $comandoConsulta->bindParam(":nome", $filtrar);
                    $comandoConsulta->execute();
                    $lista = $comandoConsulta->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($lista as $ed) {
                        echo "<tr><td>".htmlentities($ed["id"])."</td><td>".htmlentities($ed["nome"])."</td><td>".htmlentities($ed["email"])."</td><td><a href='cliente.php?excluir=".htmlentities($ed["id"])."'>Excluir</a><a href='cliente.php?atualizar=".$ed["id"]."'>Editar</a></td></tr>";
                    }
                ?>
                </tbody>
            </table>
        </div>
    </main>
    <footer>
        <span>Etec Sales Gomes</span>
    </footer>
</body>
</html>