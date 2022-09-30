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
  // Delete company (area_admin.php, com_admin.php)
} elseif ($_POST['ajax'] == 2) {
  $id = $_POST['id'];
  $company = '';
  if (isset($_POST['company'])) {
    $company = $_POST['company'];
    try {
      $pdo = new PDO(DSN, DB_USER, DB_PASS);
      $stmt = $pdo->prepare('DELETE FROM company WHERE com_name = :company');
      $stmt->bindParam(':company', $company, PDO::PARAM_INT);
      $stmt->execute();
    } catch (PDOException $e) {
    }
  } else {
    try {
      $pdo = new PDO(DSN, DB_USER, DB_PASS);
      $stmt = $pdo->prepare('SELECT com_name FROM company WHERE id = :id');
      $stmt->bindParam(':id', $id, PDO::PARAM_INT);
      $stmt->execute();
      foreach ($stmt as $row) {
        $company = $row['com_name'];
      }
    } catch (PDOException $e) {
    }
  }
  try {
    $pdo = new PDO(DSN, DB_USER, DB_PASS);
    $stmt = $pdo->prepare('DELETE FROM company WHERE id = :id');
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
  } catch (PDOException $e) {
  }
  try {
    $pdo = new PDO(DSN, DB_USER, DB_PASS);
    $stmt = $pdo->prepare('DELETE FROM user WHERE company = :company');
    $stmt->bindParam(':company', $company, PDO::PARAM_STR);
    $stmt->execute();
  } catch (PDOException $e) {
  }
  try {
    $pdo = new PDO(DSN, DB_USER, DB_PASS);
    $stmt = $pdo->prepare('DELETE FROM activity WHERE company = :company');
    $stmt->bindParam(':company', $company, PDO::PARAM_STR);
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
  } catch (PDOException $e) {
    echo json_encode('fail');
  }
  try {
    $pdo = new PDO(DSN, DB_USER, DB_PASS);
    $stmt = $pdo->prepare('DELETE FROM user WHERE area = :area_name');
    $stmt->bindParam(':area_name', $area_name, PDO::PARAM_STR);
    $stmt->execute();
  } catch (PDOException $e) {
    echo json_encode('fail');
  }
  try {
    $pdo = new PDO(DSN, DB_USER, DB_PASS);
    $stmt = $pdo->prepare('DELETE FROM activity WHERE area = :area_name');
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
  // Getting all activities (remove_activity.php)
} elseif ($_POST['ajax'] == 8) {
  $return_data = '';
  $area = $_POST['area'];
  $company = $_POST['company'];
  if ($company == '') {
    try {
      $pdo = new PDO(DSN, DB_USER, DB_PASS);
      $stmt = $pdo->prepare('SELECT id, name, start, end, details, pdf_path FROM activity WHERE area = :area ORDER BY start DESC');
      $stmt->bindParam(':area', $area, PDO::PARAM_STR);
      $stmt->execute();
      foreach ($stmt as $row) {
        $delete_button = '<button id="' . $row['id'] . '" class="remove_activity">削除</button>';
        $return_data = $return_data . '<ul class="activity_container"><li class="activity_name">' . $row['name'] . '</li><li class="activity_start">開始：' . $row['start'] . '</li><li class="activity_end">終了：' . $row['end'] . '</li><li class="activity_details">概要：' . $row['details'] . '</li><li class="activity_end"><a href="' . $row['pdf_path'] . '">PDF</a></li>' . $delete_button;
      }
      echo json_encode($return_data);
    } catch (PDOException $e) {
    }
  } else {
    try {
      $pdo = new PDO(DSN, DB_USER, DB_PASS);
      $stmt = $pdo->prepare('SELECT id, name, start, end, details, pdf_path FROM activity WHERE area = :area AND company = :company ORDER BY start DESC');
      $stmt->bindParam(':area', $area, PDO::PARAM_STR);
      $stmt->bindParam(':company', $company, PDO::PARAM_STR);
      $stmt->execute();
      foreach ($stmt as $row) {
        $delete_button = '<button id="' . $row['id'] . '" class="remove_activity">削除</button>';
        $return_data = $return_data . '<ul class="activity_container"><li class="activity_name">' . $row['name'] . '</li><li class="activity_start">開始：' . $row['start'] . '</li><li class="activity_end">終了：' . $row['end'] . '</li><li class="activity_details">概要：' . $row['details'] . '</li><li class="activity_end"><a href="' . $row['pdf_path'] . '">PDF</a></li></ul>' . $delete_button;
      }
      echo json_encode($return_data);
    } catch (PDOException $e) {
    }
  }
  // Remove activity (manage_activity.php)
} elseif ($_POST['ajax'] == 9) {
  $id = $_POST['id'];
  try {
    $pdo = new PDO(DSN, DB_USER, DB_PASS);
    $stmt = $pdo->prepare('DELETE FROM activity WHERE id = :id');
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    echo json_encode('success');
  } catch (PDOException $e) {
  }
  // Get all participated activities (manage_participation.php)
} elseif ($_POST['ajax'] == 10) {
  $return_data;
  $area = $_POST['area'];
  $company = $_POST['company'];
  $name = $_POST['name'];
  try {
    $pdo = new PDO(DSN, DB_USER, DB_PASS);
    $stmt = $pdo->prepare('SELECT history FROM user WHERE area = :area AND company = :company AND name = :name');
    $stmt->bindParam(':area', $area, PDO::PARAM_STR);
    $stmt->bindParam(':company', $company, PDO::PARAM_STR);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->execute();
    foreach ($stmt as $row) {
      $return_data = $row['history'];
      $return_data = explode(',', $return_data);
    }
    echo json_encode($return_data);
  } catch (PDOException $e) {
  }
  // Get all activity data (manage_participation.php)
} elseif ($_POST['ajax'] == 11) {
  $ids = $_POST['ids'];
  $return_data = '';
  foreach ($ids as $id) {
    try {
      $pdo = new PDO(DSN, DB_USER, DB_PASS);
      $stmt = $pdo->prepare('SELECT id, name, start, end, details, pdf_path FROM activity WHERE id = :id ORDER BY start DESC');
      $stmt->bindParam(':id', $id, PDO::PARAM_STR);
      $stmt->execute();
      foreach ($stmt as $row) {
        $cancel_button = '<button id="' . $row['id'] . '" class="cancel_activity">キャンセル</button>';
        $return_data = $return_data . '<ul class="activity_container"><li class="activity_name">' . $row['name'] . '</li><li class="activity_start">開始：' . $row['start'] . '</li><li class="activity_end">終了：' . $row['end'] . '</li><li class="activity_details">概要：' . $row['details'] . '</li><li class="activity_end"><a href="' . $row['pdf_path'] . '">PDF</a></li></ul>' . $cancel_button;
      }
    } catch (PDOException $e) {
    }
  }
  echo json_encode($return_data);
  // Cancel participated activity (manage_participation.php)
} elseif ($_POST['ajax'] == 12) {
  $id;
  $participated;
  $area = $_POST['area'];
  $company = $_POST['company'];
  $name = $_POST['name'];
  $cancel = $_POST['cancel'];
  try {
    $pdo = new PDO(DSN, DB_USER, DB_PASS);
    $stmt = $pdo->prepare('SELECT id, history FROM user WHERE area = :area AND company = :company AND name = :name');
    $stmt->bindParam(':area', $area, PDO::PARAM_STR);
    $stmt->bindParam(':company', $company, PDO::PARAM_STR);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->execute();
    foreach ($stmt as $row) {
      $participated = $row['history'];
      $id = $row['id'];
      $participated = explode(',', $participated);
    }
  } catch (PDOException $e) {
  }
  $participated = array_diff($participated, array($cancel));
  $participated = array_values($participated);
  $participated = implode(',', $participated);
  try {
    $pdo = new PDO(DSN, DB_USER, DB_PASS);
    $stmt = $pdo->prepare('UPDATE user SET history = :participated WHERE id = :id');
    $stmt->bindParam(':participated', $participated, PDO::PARAM_STR);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    echo json_encode($participated);
  } catch (PDOException $e) {
  }
}
