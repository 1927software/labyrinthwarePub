<?php
  require_once(dirname(__FILE__)."/code/base.php");
  require_once(dirname(__FILE__)."/code/regInfoDb.php");

// header statements below are for cross domain issues. Since we are now
// using a script injection technique this is not necessary.
//  header("Access-Control-Allow-Origin: *");
//  header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
//  header("Access-Control-Allow-Headers: *");

  $riJson = $_GET["ri"];

  // Our ruby layer wants to emit '/"' for '"' which we can't handle here.
  $riJson = str_replace('\"', '"', $riJson);
  //printf('riJson=%s', $riJson);

  $ri = json_decode($riJson, true);

  if (!isset($ri)) {
    die("");
  }

  $id = $ri['id'];

  // If we are not given a properly formatted ri then we exit
  if (!isset($id)) {
    $id = '';
  }
  //printf(" id=%s ", $id);

  //echo $riJson;
  $regInfo = new RegInfo();
  $row = null;

  if ($id != '') {
    $row = $regInfo->getRow($id);
  }

  if ($row) {
    $regInfo->updateRowAccess($row);
  } else {
    $row = $regInfo->addRow($id);
    //echo '{"id":' . $id . ', "wc":64}';
  }
  if ($row) {
    $featureCtl = 0xff;
    // Note: can add something like, "msg":"hi from svr!" to popup msg on client
    // Note2: because of cross domain issues in IE we now have to emit a
    // script type of statement (we are being accessed as script injection)
    // Note3: no longer emitting js statement
    //printf ('__qcutlist_ri = {"id":"%s","lv":"0.20001","fc":%d,"nci":0};', $row->id, $featureCtl);
    printf ('{"id":"%s","lv":"0.30001","fc":%d,"nci":0}', $row->id, $featureCtl);
  }
  //echo 'Current PHP version: ' . phpversion();
?>
