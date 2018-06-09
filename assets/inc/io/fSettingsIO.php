<?php
//   
//
// requires
//    $db with sql connect object ($mysqli)
//
function updateSettings ($db,$data) {
  $allDataExists=True;
  $rtn['Status']=90;
  $rtn['Call']=$data;

  $bindparms='';
  if (is_array($data)) {
    if (!array_key_exists('id',$data)) {$allDataExists=False;}
    if (!array_key_exists('column',$data)) {$allDataExists=False;}
    if (!array_key_exists('value',$data)) {$allDataExists=False;}
    if (!array_key_exists('type',$data)) {$allDataExists=False;}
  }

  if ($allDataExists===True) {
    unset($sql);unset($stmt);
    $sql='UPDATE Settings SET '.$data['column'].'=? WHERE StationID=?';
      $bindparms=$data['type'].'s';
      $stmt=$db->prepare($sql);
      $stmt->bind_param($bindparms,$data['value'],$data['id']);
      if ($stmt->execute()) {
        $rtn['Status']=0;
        $stmt->close();
      } else {
        throw new Exception(mysqli_error($db));
      }
    } else {
      $rtn['Status']=80;
    }

  return $rtn;
}
function removeSettings ($db,$data) {
  $allDataExists=True;
  $rtn['Status']=90;
  $rtn['Count']=0;
  $rtn['Call']=$data;

  $bindparms='';
  if (is_array($data)) {
    if (!array_key_exists('StationID',$data)) {$allDataExists=False;}
  }

  if ($allDataExists===True) {
    unset($sql);unset($stmt);
    $sql='DELETE FROM Settings WHERE StationID=?';
      $stmt=$db->prepare($sql);
      $stmt->bind_param('s',$data['StationID']);
      if ($stmt->execute()) {
        $count=$db->affected_rows;
        $rtn['Count']=$count;
        $rtn['Status']=0;
        $stmt->close();
      } else {
        throw new Exception(mysqli_error($db));
      }
    } else {
      $rtn['Status']=80;
    }
  return $rtn;
}
function addSettings ($db,$data) {
  $allDataExists=True;
  $rtn['Status']=90;
  $rtn['Call']=$data;

  if (is_array($data)) {
    if (!array_key_exists('StationID',$data)) {$allDataExists=False;}
    if (!array_key_exists('Status',$data)) {$allDataExists=False;}
    if (!array_key_exists('DisplayDim',$data)) {$allDataExists=False;}
    if (!array_key_exists('DisplayOn',$data)) {$allDataExists=False;}
    if (!array_key_exists('ColdFrameOn',$data)) {$allDataExists=False;}
    if (!array_key_exists('WUUpload',$data)) {$allDataExists=False;}
    if ($allDataExists===True) {
      if (!is_numeric($data['DisplayDim'])) {$allDataExists=False;}
      if (!is_numeric($data['DisplayOn'])) {$allDataExists=False;}
      if (!is_numeric($data['ColdFrameOn'])) {$allDataExists=False;}
      if (!is_numeric($data['WUUpload'])) {$allDataExists=False;}
    }
  } else {
    $allDataExists=False;
  }

  if ($allDataExists===True) {
    unset($sql);unset($stmt);
    $sql="INSERT INTO Settings (StationID,Status,DisplayDim,DisplayOn,ColdFrameOn,WUUpload) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt=$db->prepare($sql);
    $stmt->bind_param('ssiiii',
                      $data["StationID"],
                      $data["Status"],
                      $data["DisplayDim"],
                      $data["DisplayOn"],
                      $data["ColdFrameOn"],
                      $data["WUUpload"]
                    );
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

function getSettings ($db, $data) {
  $rtn=array();
  $rtn['Status']=90;
  $rtn['Call']=$data;
  $rtn['Message']='';

  if (array_key_exists('query',$data)) {
    $sql=$db->prepare($data['query']);

    if ((array_key_exists('parm',$data))
      && (array_key_exists('bind',$data)
      && ($data['bind']!=Null))) {
      $parms=count($data['parm']);
      switch ($parms) {
        case 1:
          $sql->bind_param($data['bind'],$data['parm'][0]);
          break;
        case 2:
          $sql->bind_param($data['bind'],$data['parm'][0],$data['parm'][1]);
          break;
        case 3:
          $sql->bind_param($data['bind'],$data['parm'][0],$data['parm'][1],$data['parm'][2]);
          break;
        case 4:
          $sql->bind_param($data['bind'],$data['parm'][0],$data['parm'][1],$data['parm'][2],$data['parm'][3]);
          break;
        case 5:
          $sql->bind_param($data['bind'],$data['parm'][0],$data['parm'][1],$data['parm'][2],$data['parm'][3],$data['parm'][4]);
          break;
        default:
          break;
      }
    }

    if ($sql->execute()) {
      $sql->store_result();
      $sql->bind_result(
                        $Row["StationID"],
                        $Row["Status"],
                        $Row["DisplayDim"],
                        $Row["DisplayOn"],
                        $Row["ColdFrameOn"],
                        $Row["WUUpload"],
                        $Row["Updated"]
                        );
      $count=$sql->num_rows;
      $rtn['Status']=0;
      $rtn['Count']=$count;
      if ($count>0) {
        while($sql->fetch()){
          $e["StationID"]=$Row["StationID"];
          $e["Status"]=$Row["Status"];
          $e["DisplayDim"]=$Row["DisplayDim"];
          $e["DisplayOn"]=$Row["DisplayOn"];
          $e["ColdFrameOn"]=$Row["ColdFrameOn"];
          $e["WUUpload"]=$Row["WUUpload"];
          $e["Updated"]=$Row["Updated"];
          $entry[$Row["StationID"]]=$e;
        }
        $rtn['Rows']=$entry;
      }
      $sql->close();
    } else {
      throw new Exception(mysqli_error($db));
    }
  }
return $rtn;
}
?>
