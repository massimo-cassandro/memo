<?php
require_once './incl/init.php';

/*

attachments (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    note_id INTEGER REFERENCES memo (id) ON DELETE CASCADE NOT NULL,
    filename TEXT NOT NULL,
    display_name TEXT,
    caption TEXT,
    mime TEXT NOT NULL,
    width NUMERIC(5),
    height NUMERIC(5),
    size NUMERIC
  );
*/

if(!empty($_GET['id'])) {
  $id = $_GET['id'];
  $stmt = $db->prepare('SELECT * FROM attachments WHERE id = :id');
  $stmt->bindValue(':id', $id, SQLITE3_INTEGER);

  $result = $stmt->execute();
  $row = $result->fetchArray(SQLITE3_ASSOC);


  if($row) {
    $attachment = $attachments_dir . '/' . $row['filename'];

    header('Content-Type: ' . $row['mime']);
    header('Content-Length: ' . filesize($attachment));
    header('Content-Disposition: inline; filename="'. ($row['display_name']? $row['display_name'] : $row['filename']) .'"');
    readfile($attachment);

  } else {
    header("HTTP/1.1 404 Not Found");
    die('err-f1');
  }
} else {
  header("HTTP/1.1 500 Internal Server Error");
  die('err-f2');
}
