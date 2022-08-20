<?php
require_once('./config.php');
// Get company data (area_admin.php)
if ($_POST['ajax'] == 1) {
  $area_name = $_POST['area'];
  $return_data = '';
  try {
    $pdo = new PDO(DSN, DB_USER, DB_PASS);
    $stmt = $pdo->prepare('SELECT id, com_name FROM company WHERE area = :area_name');
    $stmt->bindParam(':area_name', $area_name, PDO::PARAM_STR);
    $stmt->execute();
    foreach ($stmt as $row) {
      $delete_button = '<button id="' . $row['id'] . '" class="remove_company">削除</button>';
      $return_data = $return_data . '<li class="company">' . $row['com_name'] . '</li>' . $delete_button;
    }
    echo json_encode($return_data);
  } catch (PDOException $e) {
  }
} elseif ($_POST['ajax'] == 2) {
  $id = $_POST['id'];
  try {
    $pdo = new PDO(DSN, DB_USER, DB_PASS);
    $stmt = $pdo->prepare('DELETE FROM company WHERE id = :id');
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    echo json_encode('success');
  } catch (PDOException $e) {
  }
}
