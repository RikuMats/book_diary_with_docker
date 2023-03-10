<?php
// $data = [
//   array( 
//     "isbn" => "9784198942304",
//     "title" => "アキラとあきら",
//     "author" => "池井戸潤",
//     "img_url" => "http://books.google.com/books/content?id=jo75swEACAAJ&printsec=frontcover&img=1&zoom=1&source=gbs_api",
//     "impression" => "that's interesting"
//   ),
//   array(
//     "isbn" => "9784167110116",
//     "title" => "手紙",
//     "author" => "東野圭吾",
//     "img_url" => "http://books.google.com/books/content?id=_XH4PgAACAAJ&printsec=frontcover&img=1&zoom=1&source=gbs_api",
//     "impression" => "that's fun"
//   )  
// ];
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
header("Content-type: application/json; charset=UTF-8");

require_once("utils.php");

$pdo = connect_db();
$sql = "SELECT t2.isbn, t2.title, t2.author, t2.img_url,t1.impression, t1.updated_date FROM history AS t1
JOIN book_master as t2
ON t1.isbn=t2.isbn AND t1.is_red=TRUE
ORDER BY t1.updated_date";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$result = $stmt->fetchall();

$data = [];
foreach($result as $history) {
  $data[] = array(
    "isbn" => $history["isbn"],
    "title" => $history["title"],
    "author" => $history["author"],
    "img_url" => $history["img_url"],
    "impression" => $history["impression"]
  );
}
$data = json_encode($data);
if(json_last_error() == JSON_ERROR_NONE){
    echo $data;
}
else{
    http_response_code(500);
}

?>