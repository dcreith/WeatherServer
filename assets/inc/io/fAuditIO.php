<?php
//   
//
// requires
//    $db with sql connect object ($mysqli)
//
function addAudit ($db,$data) {
  $allDataExists=True;
  $rtn['Status']=90;
  $rtn['Call']=$data;

  if (is_array($data)) {
    if (!array_key_exists('Audit',$data)) {$allDataExists=False;}
  } else {
    $allDataExists=False;
  }

  if ($allDataExists===True) {
    unset($sql);unset($stmt);
    $sql="INSERT INTO Audit (Data) VALUES (?)";
    $stmt=$db->prepare($sql);
    $stmt->bind_param('s',$data["Data"]);
    if ($stmt->execute()) {
      $rtn['Status']=0;
    } elseif ($db->errno == 1062) {
      $rtn['Status']=1062;
    } else {
      throw new Exception(mysqli_error($db));
    }
    $stmt->close();
  } else {
    $rtn['Status']=80;
  }
  return $rtn;
}
?>
