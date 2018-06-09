<?php
//   
//
// requires
//    $db with sql connect object ($mysqli)
//
function updateActions ($db,$data) {
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
    $sql='UPDATE Actions SET '.$data['column'].'=? WHERE ActionID=?';
      $bindparms=$data['type'].'i';
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
function removeActions ($db,$data) {
  $allDataExists=True;
  $rtn['Status']=90;
  $rtn['Count']=0;
  $rtn['Call']=$data;

  $bindparms='';
  if (is_array($data)) {
    if (!array_key_exists('ActionID',$data)) {$allDataExists=False;}
  }

  if ($allDataExists===True) {
    unset($sql);unset($stmt);
    $sql='DELETE FROM Actions WHERE ActionID=?';
      $stmt=$db->prepare($sql);
      $stmt->bind_param('i',$data['ActionID']);
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
function addActions ($db,$data) {
  $allDataExists=True;
  $rtn['Status']=90;
  $rtn['Call']=$data;

  if (is_array($data)) {
    if (!array_key_exists('Action',$data)) {$allDataExists=False;}
    if (!array_key_exists('ControlID',$data)) {$allDataExists=False;}
    if (!array_key_exists('ParameterType',$data)) {$allDataExists=False;}

    if (($data['ParameterType']=='I') or ($data['ParameterType']=='C')) {}
    else {$allDataExists=False;}

    if (!array_key_exists('ParameterInt',$data)) {$data['ParameterInt']=0;}
    if (!array_key_exists('ParameterChar',$data)) {$data['ParameterChar']='';}

    if (!is_numeric($data['ParameterInt'])) {$allDataExists=False;}

  } else {
    $allDataExists=False;
  }

  if ($allDataExists===True) {
    unset($sql);unset($stmt);
    $sql="INSERT INTO Actions (Action,ControlID,ParameterType,ParameterInt,ParameterChar) VALUES (?, ?, ?, ?, ?)";
    $stmt=$db->prepare($sql);
    $stmt->bind_param('sssis',
                      $data["Action"],
                      $data["ControlID"],
                      $data["ParameterType"],
                      $data["ParameterInt"],
                      $data["ParameterChar"]
                    );
    if ($stmt->execute()) {
      $id=$db->insert_id;
      $rtn['ID']=$id;
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

function getActions ($db, $data) {
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
                        $Row["ActionID"],
                        $Row["Action"],
                        $Row["ControlID"],
                        $Row["ParameterType"],
                        $Row["ParameterInt"],
                        $Row["ParameterChar"],
                        $Row["Updated"]
                        );
      $count=$sql->num_rows;
      $rtn['Status']=0;
      $rtn['Count']=$count;
      if ($count>0) {
        while($sql->fetch()){
          $e["ActionID"]=$Row["ActionID"];
          $e["Action"]=$Row["Action"];
          $e["ControlID"]=$Row["ControlID"];
          $e["ParameterType"]=$Row["ParameterType"];
          $e["ParameterInt"]=$Row["ParameterInt"];
          $e["ParameterChar"]=$Row["ParameterChar"];
          $e["Updated"]=$Row["Updated"];
          $entry[$Row["ActionID"]]=$e;
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
