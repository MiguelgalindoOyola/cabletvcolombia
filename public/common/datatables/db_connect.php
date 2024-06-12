<?php 
    define ('DB_HOST','localhost'); // ip PC que tiene base de datos 
    define ('DB_USER','root'); // usuario base de datos 
    define ('DB_PASS','admin'); // contrase�a base de datos 
    define ('DB_NAME','sicefaoo'); // nombre base de datos 

//$conn = pg_connect("user=".DB_USER." port=".DB_PORT." password=".DB_PASS." dbname=".DB_NAME." host=".DB_HOST); 

function execute_query ($sql){ 
    $conn = mysql_connect(DB_HOST, DB_USER, DB_PASS);
    mysql_select_db(DB_NAME, $conn) ;

    if (!$conn) { 
           echo 'Error while connecting to the database'; 
    } 
       $result = mysql_query($sql,$conn); 
       if (!$result) { 
              echo "No se puede ejecutar el query: ".$sql; 
       } 
       else { 
              //nada, todo bien 
       } 
       return $result; 
} 
?>