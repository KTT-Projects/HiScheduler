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
  // Delete company (area_admin.php)
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
  // Delete area (area_admin.php)
} elseif ($_POST['ajax'] == 3) {
  $area_name = $_POST['area'];
  try {
    $pdo = new PDO(DSN, DB_USER, DB_PASS);
    $stmt = $pdo->prepare('DELETE FROM area WHERE area_name = :area_name');
    $stmt->bindParam(':area_name', $area_name, PDO::PARAM_STR);
    $stmt->execute();
  } catch (PDOException $e) {
    echo json_encode('fail');
  }
  try {
    $pdo = new PDO(DSN, DB_USER, DB_PASS);
    $stmt = $pdo->prepare('DELETE FROM company WHERE area = :area_name');
    $stmt->bindParam(':area_name', $area_name, PDO::PARAM_STR);
    $stmt->execute();
    echo json_encode('success');
  } catch (PDOException $e) {
    echo json_encode('fail');
  }
  try {
    $pdo = new PDO(DSN, DB_USER, DB_PASS);
    $stmt = $pdo->prepare('DELETE FROM user WHERE area = :area_name');
    $stmt->bindParam(':area_name', $area_name, PDO::PARAM_STR);
    $stmt->execute();
    echo json_encode('success');
  } catch (PDOException $e) {
    echo json_encode('fail');
  }
  // Get all users (com_admin.php)
} elseif ($_POST['ajax'] == 4) {
  $area = $_POST['area'];
  $company = $_POST['company'];
  try {
    $pdo = new PDO(DSN, DB_USER, DB_PASS);
    $stmt = $pdo->prepare('SELECT id, name, permission FROM user WHERE area = :area AND company = :company');
    $stmt->bindParam(':area', $area, PDO::PARAM_STR);
    $stmt->bindParam(':company', $company, PDO::PARAM_STR);
    $stmt->execute();
    foreach ($stmt as $row) {
      $delete_button = '<button id="' . $row['id'] . '" class="remove_user">削除</button>';
      if ($row['permission'] == 0) {
        $permission_button = '<button id="' . $row['id'] . '" class="permission_user">組織アカウント権限を与える</button>';
      } else {
        $permission_button = '<button id="' . $row['id'] . '" class="unpermission_user">組織アカウント権限を剥奪する</button>';
      }
      $return_data = $return_data . '<li class="user">' . $row['name'] . '</li>' . $delete_button . $permission_button;
    }
    echo json_encode($return_data);
  } catch (PDOException $e) {
  }
  // Delete normal user
} elseif ($_POST['ajax'] == 5) {
  $id = $_POST['id'];
  try {
    $pdo = new PDO(DSN, DB_USER, DB_PASS);
    $stmt = $pdo->prepare('DELETE FROM user WHERE id = :id');
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    echo json_encode('success');
  } catch (PDOException $e) {
  }
  // Giving permission to user
} elseif ($_POST['ajax'] == 6) {
  $id = $_POST['id'];
  try {
    $pdo = new PDO(DSN, DB_USER, DB_PASS);
    $stmt = $pdo->prepare('UPDATE user SET permission = 1 WHERE id = :id');
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    echo json_encode('success');
  } catch (PDOException $e) {
  }
  // Taking permission from user
} elseif ($_POST['ajax'] == 7) {
  $id = $_POST['id'];
  try {
    $pdo = new PDO(DSN, DB_USER, DB_PASS);
    $stmt = $pdo->prepare('UPDATE user SET permission = 0 WHERE id = :id');
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    echo json_encode('success');
  } catch (PDOException $e) {
  }
}
