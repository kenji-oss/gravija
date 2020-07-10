<?PHP
    $dsn = 'データベース名';
	$user = 'ユーザー名';
	$password = 'パスワード';
	$pdo = new PDO($dsn, $user, $password, 
	array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
	
	$sql = "CREATE TABLE IF NOT EXISTS tbtest_5_1"
	." ("
	. "id INT AUTO_INCREMENT PRIMARY KEY,"
	. "name char(32),"
	. "comment TEXT,"
	. "time TEXT,"
	. "password TEXT"
	.");";
	$stmt = $pdo->query($sql);
	
	if(isset($_POST["name"]) && isset($_POST["comment"])
    && isset($_POST["delete"]) && isset($_POST["edit"])
    && isset($_POST["password"]) && isset($_POST["passdelete"])
    && isset($_POST["passedit"])){
        $name = $_POST["name"];
        $comment = $_POST["comment"];
        $delete = $_POST["delete"];
        $edit = $_POST["edit"];
        $time = date("Y年m月d日 H:i:s");
        $pass = $_POST["password"];
        $passdelete = $_POST["passdelete"];
        $passedit = $_POST["passedit"];
	
	if(strlen($name) && strlen($comment) 
        && strlen($password) && empty($edit) && empty($delete)){
    $sql = $pdo -> prepare("INSERT INTO tbtest_5_1 (name, comment, time, password) 
	VALUES (:name, :comment, :time, :password)");
	$sql -> bindParam(':name', $name, PDO::PARAM_STR);
	$sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
	$sql -> bindParam(':time', $time, PDO::PARAM_STR);
	$sql -> bindParam(':password', $pass, PDO::PARAM_STR);
	$sql -> execute();
        echo "入力完了!<br>";
    }
    

    if(strlen($delete) && strlen($passdelete)){
        $id = $delete;
        $sql = 'SELECT * FROM tbtest_5_1 WHERE id=:id ';
        $stmt = $pdo->prepare($sql);                  // ←差し替えるパラメータを含めて記述したSQLを準備し、
        $stmt->bindParam(':id', $id, PDO::PARAM_INT); // ←その差し替えるパラメータの値を指定してから、
        $stmt->execute();                             // ←SQLを実行する。
        $results = $stmt->fetchAll(); 
	foreach ($results as $row){
		//$rowの中にはテーブルのカラム名が入る
		if($row['password'] == $passdelete){
		    $sql = 'delete from tbtest_5_1 where id=:id';
	        $stmt = $pdo->prepare($sql);
        	$stmt->bindParam(':id', $id, PDO::PARAM_INT);
	        $stmt->execute();
		}
    }
    }
    
    if(strlen($edit) && strlen($name) 
        && strlen($comment) && strlen($passedit) 
        && empty($delete) && empty($passdelete)){
        $id = $edit;
        $sql = 'SELECT * FROM tbtest_5_1 WHERE id=:id ';
        $stmt = $pdo->prepare($sql);                  // ←差し替えるパラメータを含めて記述したSQLを準備し、
        $stmt->bindParam(':id', $id, PDO::PARAM_INT); // ←その差し替えるパラメータの値を指定してから、
        $stmt->execute();                             // ←SQLを実行する。
        $results = $stmt->fetchAll(); 
	foreach ($results as $row){
		//$rowの中にはテーブルのカラム名が入る
		if($row['password'] == $passedit){
	    $sql = 'UPDATE tbtest_5_1 SET name=:name,comment=:comment,time=:time WHERE id=:id';
	    $stmt = $pdo->prepare($sql);
	    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
	    $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
	    $stmt->bindParam(':time', $time, PDO::PARAM_STR);
	    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
	    $stmt->execute();
		}
    }
}
    
    
    $sql = 'SELECT * FROM tbtest_5_1';
	$stmt = $pdo->query($sql);
	$results = $stmt->fetchAll();
	foreach ($results as $row){
		//$rowの中にはテーブルのカラム名が入る
		echo $row['id'].',';
		echo $row['name'].',';
		echo $row['comment'].',';
		echo $row['time'].'<br>';
	echo "<hr>";
	}
    }
?>