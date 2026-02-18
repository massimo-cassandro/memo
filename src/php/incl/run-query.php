<?php

function runQuery() {
  global $db, $isLocalEnv;

  if(!$isLocalEnv and $_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("HTTP/1.1 500 Internal Server Error");
    die('err-q1');
  }

  $end = isset($_POST['l'])? $_POST['l'] : 10; // limit
  $start = isset($_POST['p'])? $_POST['p'] * $end : 0; // pagina

  $where = [];
  $join = [];



  // var_dump($_POST); echo '<br><br><br>';

  if(!empty($_POST['q'])) {
    $where[] = "(memo.title LIKE :q COLLATE NOACCENTS COLLATE NOCASE
      or memo.content LIKE :q COLLATE NOACCENTS COLLATE NOCASE
      or tags.tag LIKE :q COLLATE NOACCENTS COLLATE NOCASE)";

    $join[] = "LEFT JOIN memo_tags as nt ON ( nt.memo_id  = memo.id)";
    $join[] = "LEFT JOIN tags ON ( tags.id = nt.tag_id )";
  }

  // if(!empty($_POST['tagId'])) {
  //   $join[] = "LEFT JOIN tags as t ON ( nt.memo_id = memo.id AND nt.tag_id in (".
  //     implode(',', $_POST['tagId']) . ") )";
  // }

  // if(!isset($_POST['archived'])) {
  //   $where[] = "memo.archived = 0";
  // }



  $where[] = 'memo.archived = 0 AND memo.trash = 0';

  $q = "select distinct
    memo.id, memo.title, memo.updated, memo.content, memo.favourite, memo.archived, memo.trash,

    (SELECT json_group_array(json_object('id', tags.id, 'tag', tags.tag))
      FROM (tags, memo_tags as nt)
      WHERE nt.memo_id = memo.id AND nt.tag_id = tags.id) as tags,

    (SELECT json_group_array(json_object(
      'id', id,
      'filename', filename,
      'display_name', display_name,
      'caption', caption,
      'mime', mime,
      'width', width,
      'height', height,
      'size', size
    ))
      FROM (attachments as a)
      WHERE a.memo_id = memo.id) as attachments

    FROM (memo)

    " . (count($join)?  join(' ', $join)  : '') . "

    " . (count($where)? " WHERE " . join(' AND ', $where) . " " : '') . "

    ORDER BY memo.favourite DESC, memo.title COLLATE NOACCENTS COLLATE NOCASE ASC
    LIMIT {$start}, {$end}
  ";

  // var_dump($q); echo '<br><br><br>'; exit;

  $statement = $db->prepare($q);

  if(!empty($_POST['q'])) {
    // $str = iconv('UTF-8', 'ASCII//TRANSLIT', $_POST['q']);
    $statement->bindValue(':q', "%" . str_replace(' ', '%', $_POST['q']) . "%", SQLITE3_TEXT);
  }

  // if(!empty($_POST['tagId'])) {
  //   $statement->bindValue(':t', array_values($_POST['tagId']), SQLITE3_INTEGER );
  // }

  // var_dump($statement->getSQL(true)); exit;

  $result = $statement->execute();


  $list = [];


  while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
    $list[] = $row;
  }

  // var_dump($list); exit;


  header("Content-Type: application/json; charset=utf-8");
  echo json_encode($list); //  JSON_PRETTY_PRINT | JSON_NUMERIC_CHECK
  exit();

}

