<?php

class RegInfo {
  var $mysqli;

  function __destruct() {
    $this->close();
  }

  public function open() {
//    if (g_db_host != 'localhost') {
//      echo "g_db_host != 'localhost'";
//    }
//    if (g_db_user != 'labyrio7_brenton') {
//      echo "g_db_user != 'labyrio7_brenton";
//    }
//    if (g_db_pass != 'NevaNumb0-') {
//      echo "g_db_pass != Password'";
//    }
//    if (g_db_general != 'labyrio7_general') {
//      echo "g_db_general != 'labyrio7_general'";
//    }
//    echo "done tests";

    if (!$this->mysqli) {
      $this->mysqli = new mysqli(g_db_host, g_db_user, g_db_pass, g_db_general, 3306);
      if ($this->mysqli->connect_errno) {
//        echo "Could not connect: " . $this->mysqli->connect_error . "errno={$this->mysqli->connect_errno}.";
        $errno = $this->mysqli->connect_errno;
        $this->mysqli = null;
        die("Error {$errno}.");
        //return false;
      }
    }
    return true;
  }

  public function close() {
    if ($this->mysqli) {
      $this->mysqli->close();
      $this->mysqli = null;
    }
  }

  public function getRow($id) {

    $this->open();

    //$id = intval($id);

    $row = null;
    if ($result = $this->mysqli->query("SELECT * FROM `reg_info` WHERE `id` = '$id'")) {
      $row = $result->fetch_object();
      //printf ("%s", $row->level);
      $result->close();
    }
    return $row;
  }

  function AddRow($id, $user_name=NULL, $email=NULL, $level=99) {

    $this->open();
    if ($id == null || $id == '') {
      $id = 'NULL';
    }

    $row = null;
    $ip_addr = $this->getIpAddr();
    $sql = "INSERT INTO `reg_info` (`id`, `user_name`, `email`, `stamp_created`, `stamp_updated`, `ip_addr`, `reg_id`, `level`) VALUES ($id, '$user_name', '$email', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, '$ip_addr', NULL, $level);";
    //echo $sql;
    if ($result = $this->mysqli->query($sql)) {
      $row = $this->getRow($this->mysqli->insert_id);
    } else {
      printf("Error: %s", $this->mysqli->error);
    }
    return $row;

  }

  public function updateRowAccess($row) {

    $this->open();
    $rc = true;

    $row->access_count += 1;
    $ip_addr = $this->getIpAddr();
    $sql = "UPDATE `reg_info` SET `stamp_updated`=CURRENT_TIMESTAMP, `access_count`=$row->access_count,`ip_addr`='$ip_addr' WHERE `id`='$row->id';";
    //echo $sql;
    if (!$result = $this->mysqli->query($sql)) {
      printf("Error: %s", $this->mysqli->error);
      $rc = false;
    }
    return $rc;

  }

  protected function getIpAddr() {
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARTDED_FOR'] != '') {
      $ip_addr = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
      $ip_addr = $_SERVER['REMOTE_ADDR'];
    }

    $ip_addr = $this->mysqli->real_escape_string($ip_addr);

    return $ip_addr;
  }




}


?>