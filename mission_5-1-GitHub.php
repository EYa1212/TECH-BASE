<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>mission_5-1</title>
    </head>
    <body>
        <?php
        
        $dsn='データベース名';
        $user='ユーザー名';
        $pass='パスワード';
        $pdo=new PDO($dsn, $user, $pass, array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_WARNING));

        $sql="CREATE TABLE IF NOT EXISTS tb1"
        ."("
        ."id INT AUTO_INCREMENT PRIMARY KEY,"
        ."name char(32),"
        ."comment TEXT,"
        ."password TEXT,"
        ."date DATETIME"
        .");";
        $stmt=$pdo->query($sql);

        if(!empty($_POST["na"]) && !empty($_POST["com"]) && !empty($_POST["pass"])){
            if(empty($_POST["edinum"])){ 
                $sql=$pdo->prepare("INSERT INTO tb1(name,comment,password,date) VALUES(:name,:comment,:password,:date)");
                $sql->bindParam(':name',$name,PDO::PARAM_STR);
                $sql->bindParam(':comment',$com,PDO::PARAM_STR);
                $sql->bindParam(':password',$pass,PDO::PARAM_STR);
                $sql->bindParam(':date',$date,PDO::PARAM_STR);
                $name=$_POST["na"];
                $com=$_POST["com"];
                $pass=$_POST["pass"];
                $date=date("Y-m-d H:i:s");
                $sql->execute();

            }else{
                $sql='SELECT*FROM tb1';
                $stmt=$pdo->query($sql);
                $results=$stmt->fetchAll();
                foreach($results as $row){
                    if($row['id']==$_POST["edinum"]){
                        $id=$_POST["edinum"];
                        $name=$_POST["na"];
                        $com=$_POST["com"];
                        $pass=$_POST["pass"];
                        $date=date("Y-m-d H:i:s");
                        $sql='UPDATE tb1 SET name=:name,comment=:comment,password=:password,date=:date WHERE id=:id';
                        $stmt=$pdo->prepare($sql);
                        $stmt->bindParam(':name',$name,PDO::PARAM_STR);
                        $stmt->bindParam(':comment',$com,PDO::PARAM_STR);
                        $stmt->bindParam(':password',$pass,PDO::PARAM_STR);
                        $stmt->bindParam(':date',$date,PDO::PARAM_STR);
                        $stmt->bindParam(':id',$id,PDO::PARAM_INT);
                        $stmt->execute();
                    }
                }
            }
        }

        if(!empty($_POST["delNo"])&&!empty($_POST["delPass"])){
            $sql='SELECT*FROM tb1';
            $stmt=$pdo->query($sql);
            $results=$stmt->fetchAll();
            foreach($results as $row){
                if($row['id']==$_POST["delNo"] && $row['password']=$_POST["delPass"]){
                    $id=$_POST["delNo"];
                    $sql='delete from tb1 where id=:id';
                    $stmt=$pdo->prepare($sql);
                    $stmt->bindParam(':id',$id,PDO::PARAM_INT);
                    $stmt->execute();
                }
            }
        }

        if(!empty($_POST["ediNo"]) && !empty($_POST["ediPass"])){
            $sql='SELECT*FROM tb1';
            $stmt=$pdo->query($sql);
            $results=$stmt->fetchAll();
            foreach($results as $row){
                if($row['id']==$_POST["ediNo"] && $row['password']==$_POST["ediPass"]){
                    $ediNum=$row['id'];
                    $ediNa=$row['name'];
                    $ediCom=$row['comment'];
                    $ediPass=$row['password'];
                }
            }
        }

        ?>

        <h3>好きなものはなんですか。</h3>

        <form action="" method="post">
            <input type="text" name="na" placeholder="名前" value=<?php if(isset($ediNa)){echo $ediNa;}?>>
            <input type="text" name="com" placeholder="コメント" value=<?php if(isset($ediCom)){echo $ediCom;}?>>
            <input type="hidden" name="edinum" value=<?php if(!empty($ediNum)){echo $ediNum;}?>>
            <input type="password" name="pass" placeholder="パスワード" value=<?php if(isset($ediPass)){echo $ediPass;}?>>
            <input type="submit" value="投稿">
            <br><br>
            <input type="number" name="delNo" placeholder="削除対象番号">
            <input type="password" name="delPass" placeholder="パスワード">
            <input type="submit" value="削除">
            <br><br>
            <input type="number" name="ediNo" placeholder="編集対象番号">
            <input type="password" name="ediPass" placeholder="パスワード">
            <input type="submit" value="編集">
            <br><br>
        </form>

        <?php
        $sql='SELECT*FROM tb1';
        $stmt=$pdo->query($sql);
        $results=$stmt->fetchAll();
        foreach($results as $row){
            echo $row['id'].',';
            echo $row['name'].',';
            echo $row['comment'].',';
            echo $row['date'].'<br>';
        }
        echo "<hr>";

        ?>
    </body>
</html>