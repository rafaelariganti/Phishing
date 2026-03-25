<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    

    $nome       = $_POST['nome'] ?? '';
    $sobrenome  = $_POST['sobrenome'] ?? '';
    $email      = $_POST['email'] ?? '';
    $celular    = $_POST['celular'] ?? '';
    $nascimento = $_POST['nascimento'] ?? '';
    $plano      = $_POST['plano'] ?? '';
    $senha      = $_POST['senha'] ?? '';


    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    try {
        $sql = "INSERT INTO usuarios (nome, sobrenome, email, celular, nascimento, plano, senha) 
                VALUES (:nome, :sobrenome, :email, :celular, :nascimento, :plano, :senha)";
        
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':sobrenome', $sobrenome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':celular', $celular);
        $stmt->bindParam(':nascimento', $nascimento);
        $stmt->bindParam(':plano', $plano);
        $stmt->bindParam(':senha', $senha_hash);


        $stmt->execute();

        echo "<script>alert('Cadastro realizado com sucesso!'); window.location.href='login.php';</script>";
        exit;

    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            echo "<script>alert('Erro: Este e-mail já está cadastrado!'); history.back();</script>";
        } else {
            die("Erro ao cadastrar: " . $e->getMessage());
        }
    }
}
?>