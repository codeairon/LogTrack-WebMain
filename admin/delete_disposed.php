<?php
session_start();
require_once('../db_connect.php');

if($_SERVER['REQUEST_METHOD']!=='POST'){ echo json_encode(['ok'=>false]); exit; }

$id = intval($_POST['id']);
$conn->begin_transaction();
try{
  $conn->query("DELETE FROM disposed_equipment        WHERE log_id=$id");
  $conn->query("DELETE FROM disposed_conveyance       WHERE log_id=$id");
  $conn->query("DELETE FROM disposed_forest_products  WHERE log_id=$id");
  $conn->query("DELETE FROM disposed_logs            WHERE id=$id");
  $conn->commit();
  echo json_encode(['ok'=>true]);
}catch(Exception $e){
  $conn->rollback();
  echo json_encode(['ok'=>false,'msg'=>$e->getMessage()]);
}
