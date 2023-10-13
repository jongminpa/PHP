<?php

function db_connects()
{
    $host = 'localhost';
    $port = '3306';
    $dbname = 'php_notice_board';
    $username = 'root';
    $charset = 'utf8';
    $db_pw = 'Q1w2e3r4!';
    $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=$charset";
    $pdo = new PDO($dsn, $username, $db_pw);
    return $pdo;
    
}

function db_insert($query,$param = array())
{
    $pdo = db_connects();
    try{
        $stmt = $pdo->prepare($query);
        $stmt->execute($param);
        $pdo = null;
        return true;
    }catch(PDOException $e){
        return false;
    } finally{
        $pdo=null;
    }
}

function db_select($query,$param = array())
{
    $pdo = db_connects();
    try{
        $stmt = $pdo->prepare($query);
        $stmt->execute($param);
        $result =$stmt->fetchAll(PDO::FETCH_ASSOC);
        $pdo = null;
        return $result;
    }catch(PDOException $e){
        return false;
    } finally{
        $pdo=null;
    }
}
function db_update_delete($query,$param = array())
{
    $pdo = db_connects();
    try{
        $stmt = $pdo->prepare($query);
        $stmt->execute($param);
        $result =$stmt->fetchAll(PDO::FETCH_ASSOC);
        $pdo = null;
        return $result;
    }catch(PDOException $e){
        return false;
    } finally{
        $pdo=null;
    }
}

function db_insert_id($query,$param = array())
{
    $pdo = db_connects();
    try{
        $stmt = $pdo->prepare($query);
        $stmt->execute($param);
        $result =$pdo->lastInsertId();
        $pdo = null;
        return $result;
    }catch(PDOException $e){  
        return false;
    }finally{
        $pdo = null;
    }
}