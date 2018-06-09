<?php
//   
//
// requires
//    $db with sql connect object ($mysqli)
//
function insertDailyWeather ($db,$data) {
  $allDataExists=True;
  $rtn['Status']=90;
  $rtn['Call']=$data;

  if (is_array($data)) {
    if (!array_key_exists('query',$data)) {$allDataExists=False;}
  } else {
    $allDataExists=False;
  }

  if ($allDataExists===True) {
    unset($sql);unset($stmt);
    $sql=$data['query'];
    $stmt=$db->prepare($sql);
    if ($stmt->execute()) {
      $count=$db->affected_rows;
      $rtn['Count']=$count;
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

function getDailyWeather ($db, $data) {
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
                        $Row["DailyWeatherID"],
                        $Row["StationID"],
                        $Row["StationUTCDate"],
                        $Row["StationLocalDate"],
                        $Row["TemperatureMin"],
                        $Row["TemperatureMax"],
                        $Row["ColdFrameTemperatureMin"],
                        $Row["ColdFrameTemperatureMax"],
                        $Row["PressureMin"],
                        $Row["PressureMax"],
                        $Row["RelativeHumidityMin"],
                        $Row["RelativeHumidityMax"],
                        $Row["Probe"],
                        $Row["ColdFrameProbe"]
                        );
      $count=$sql->num_rows;
      $rtn['Status']=0;
      $rtn['Count']=$count;
      if ($count>0) {
        while($sql->fetch()){
          $e["DailyWeatherID"]=$Row["DailyWeatherID"];
          $e["StationID"]=$Row["StationID"];
          $e["StationUTCDate"]=$Row["StationUTCDate"];
          $e["StationLocalDate"]=$Row["StationLocalDate"];
          $e["TemperatureMin"]=$Row["TemperatureMin"];
          $e["TemperatureMax"]=$Row["TemperatureMax"];
          $e["ColdFrameTemperatureMin"]=$Row["ColdFrameTemperatureMin"];
          $e["ColdFrameTemperatureMax"]=$Row["ColdFrameTemperatureMax"];
          $e["PressureMin"]=$Row["PressureMin"];
          $e["PressureMax"]=$Row["PressureMax"];
          $e["RelativeHumidityMin"]=$Row["RelativeHumidityMin"];
          $e["RelativeHumidityMax"]=$Row["RelativeHumidityMax"];
          $e["Probe"]=$Row["Probe"];
          $e["ColdFrameProbe"]=$Row["ColdFrameProbe"];
          $entry[$Row["DailyWeatherID"]]=$e;
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
