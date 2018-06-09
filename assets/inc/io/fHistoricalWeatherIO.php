<?php
//   
//
// requires
//    $db with sql connect object ($mysqli)
//
function markHistoricalWeather ($db,$data) {
  $allDataExists=True;
  $rtn['Status']=90;
  $rtn['Count']=0;
  $rtn['Call']=$data;

  $bindparms='';
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
      $stmt->close();
    } else {
      throw new Exception(mysqli_error($db));
    }
  } else {
    $rtn['Status']=80;
  }
  return $rtn;
}
function removeMarkedHistoricalWeather ($db,$data) {
  $allDataExists=True;
  $rtn['Status']=90;
  $rtn['Count']=0;
  $rtn['Call']=$data;

  $bindparms='';
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
      $stmt->close();
    } else {
      throw new Exception(mysqli_error($db));
    }
  } else {
    $rtn['Status']=80;
  }
  return $rtn;
}
function updateHistoricalWeather ($db,$data) {
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
    $sql='UPDATE HistoricalWeather SET '.$data['column'].'=? WHERE HistoricalWeatherID=?';
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
function removeHistoricalWeather ($db,$data) {
  $allDataExists=True;
  $rtn['Status']=90;
  $rtn['Count']=0;
  $rtn['Call']=$data;

  $bindparms='';
  if (is_array($data)) {
    if (!array_key_exists('HistoricalWeatherID',$data)) {$allDataExists=False;}
  }

  if ($allDataExists===True) {
    unset($sql);unset($stmt);
    $sql='DELETE FROM HistoricalWeather WHERE HistoricalWeatherID=?';
      $stmt=$db->prepare($sql);
      $stmt->bind_param('i',$data['HistoricalWeatherID']);
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
function addHistoricalWeather ($db,$data) {
  $allDataExists=True;
  $rtn['Status']=90;
  $rtn['Call']=$data;

  if (is_array($data)) {
    if (!array_key_exists('StationID',$data)) {$allDataExists=False;}

    if (!array_key_exists('Temperature',$data)) {$data['Temperature']=Null;}
    if (!array_key_exists('ColdFrameTemperature',$data)) {$data['ColdFrameTemperature']=Null;}
    if (!array_key_exists('Pressure',$data)) {$data['Pressure']=Null;}
    if (!array_key_exists('RelativeHumidity',$data)) {$data['RelativeHumidity']=Null;}
    if (!array_key_exists('DewPoint',$data)) {$data['DewPoint']=Null;}
    if (!array_key_exists('WindSpeed',$data)) {$data['WindSpeed']=Null;}
    if (!array_key_exists('WindDirectionDegrees',$data)) {$data['WindDirectionDegrees']=Null;}
    if (!array_key_exists('WindDirectionEmpirical',$data)) {$data['WindDirectionEmpirical']='';}
    if (!array_key_exists('Luminousity',$data)) {$data['Luminousity']=Null;}
    if (!array_key_exists('UVIndex',$data)) {$data['UVIndex']=Null;}
    if (!array_key_exists('DayPeriod',$data)) {$data['DayPeriod']='Unknown';}
    if (!array_key_exists('Probe',$data)) {$data['Probe']='Unknown';}
    if (!array_key_exists('ColdFrameProbe',$data)) {$data['ColdFrameProbe']='Unknown';}
    if (!array_key_exists('StationLocalDate',$data)) {$data['StationLocalDate']='0000-00-00';}
    if (!array_key_exists('StationLocalTime',$data)) {$data['StationLocalTime']='00:00:00';}
    if (!array_key_exists('StationTimeZone',$data)) {$data['StationTimeZone']='Unknown';}
    if (!array_key_exists('StationUTCDate',$data)) {$data['StationUTCDate']='0000-00-00';}
    if (!array_key_exists('StationUTCTime',$data)) {$data['StationUTCTime']='00:00:00';}

    if ((is_numeric($data['ColdFrameTemperature'])) && ($data['ColdFrameTemperature']==-99)) {$data['ColdFrameTemperature']=Null;}

    if ((!is_numeric($data['Temperature'])) && ($data['Temperature']!=Null)) {$allDataExists=False;}
    if ((!is_numeric($data['ColdFrameTemperature'])) && ($data['ColdFrameTemperature']!=Null)) {$allDataExists=False;}
    if ((!is_numeric($data['Pressure'])) && ($data['Pressure']!=Null)) {$allDataExists=False;}
    if ((!is_numeric($data['RelativeHumidity'])) && ($data['RelativeHumidity']!=Null)) {$allDataExists=False;}
    if ((!is_numeric($data['DewPoint'])) && ($data['DewPoint']!=Null)) {$allDataExists=False;}
    if ((!is_numeric($data['WindSpeed'])) && ($data['WindSpeed']!=Null)) {$allDataExists=False;}
    if ((!is_numeric($data['WindDirectionDegrees'])) && ($data['WindDirectionDegrees']!=Null)) {$allDataExists=False;}
    if ((!is_numeric($data['Luminousity'])) && ($data['Luminousity']!=Null)) {$allDataExists=False;}
    if ((!is_numeric($data['UVIndex'])) && ($data['UVIndex']!=Null)) {$allDataExists=False;}

  } else {
    $allDataExists=False;
  }

  if ($allDataExists===True) {
    unset($sql);unset($stmt);
    $sql="INSERT INTO HistoricalWeather (Temperature,ColdFrameTemperature,Pressure,RelativeHumidity,DewPoint,WindSpeed,WindDirectionDegrees,WindDirectionEmpirical,Luminousity,UVIndex,DayPeriod,Probe,ColdFrameProbe,StationID,StationLocalDate,StationLocalTime,StationTimeZone,StationUTCDate,StationUTCTime) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt=$db->prepare($sql);
    $stmt->bind_param('dddddiisidsssssssss',
                      $data["Temperature"],
                      $data["ColdFrameTemperature"],
                      $data["Pressure"],
                      $data["RelativeHumidity"],
                      $data["DewPoint"],
                      $data["WindSpeed"],
                      $data["WindDirectionDegrees"],
                      $data["WindDirectionEmpirical"],
                      $data["Luminousity"],
                      $data["UVIndex"],
                      $data["DayPeriod"],
                      $data["Probe"],
                      $data["ColdFrameProbe"],
                      $data["StationID"],
                      $data["StationLocalDate"],
                      $data["StationLocalTime"],
                      $data["StationTimeZone"],
                      $data["StationUTCDate"],
                      $data["StationUTCTime"]
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

function getHistoricalWeather ($db, $data) {
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
                        $Row["HistoricalWeatherID"],
                        $Row["Temperature"],
                        $Row["ColdFrameTemperature"],
                        $Row["Pressure"],
                        $Row["RelativeHumidity"],
                        $Row["DewPoint"],
                        $Row["WindSpeed"],
                        $Row["WindDirectionDegrees"],
                        $Row["WindDirectionEmpirical"],
                        $Row["Luminousity"],
                        $Row["UVIndex"],
                        $Row["DayPeriod"],
                        $Row["Probe"],
                        $Row["ColdFrameProbe"],
                        $Row["StationID"],
                        $Row["StationLocalDate"],
                        $Row["StationLocalTime"],
                        $Row["StationTimeZone"],
                        $Row["StationUTCDate"],
                        $Row["StationUTCTime"],
                        $Row["Added"]
                              );
      $count=$sql->num_rows;
      $rtn['Status']=0;
      $rtn['Count']=$count;
      if ($count>0) {
        while($sql->fetch()){
          $e["HistoricalWeatherID"]=$Row["HistoricalWeatherID"];
          $e["Temperature"]=$Row["Temperature"];
          $e["ColdFrameTemperature"]=$Row["ColdFrameTemperature"];
          $e["Pressure"]=$Row["Pressure"];
          $e["RelativeHumidity"]=$Row["RelativeHumidity"];
          $e["DewPoint"]=$Row["DewPoint"];
          $e["WindSpeed"]=$Row["WindSpeed"];
          $e["WindDirectionDegrees"]=$Row["WindDirectionDegrees"];
          $e["WindDirectionEmpirical"]=$Row["WindDirectionEmpirical"];
          $e["Luminousity"]=$Row["Luminousity"];
          $e["UVIndex"]=$Row["UVIndex"];
          $e["DayPeriod"]=$Row["DayPeriod"];
          $e["Probe"]=$Row["Probe"];
          $e["ColdFrameProbe"]=$Row["ColdFrameProbe"];
          $e["StationID"]=$Row["StationID"];
          $e["StationLocalDate"]=$Row["StationLocalDate"];
          $e["StationLocalTime"]=$Row["StationLocalTime"];
          $e["StationTimeZone"]=$Row["StationTimeZone"];
          $e["StationUTCDate"]=$Row["StationUTCDate"];
          $e["StationUTCTime"]=$Row["StationUTCTime"];
          $e["Added"]=$Row["Added"];
          $entry[$Row["HistoricalWeatherID"]]=$e;        }
        $rtn['Rows']=$entry;
      }
      $sql->close();
    } else {
      throw new Exception(mysqli_error($db));
    }
  }
return $rtn;
}
function getMinMaxHistoricalWeather ($db, $data) {
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
                        $Row["HistoricalWeatherID"],
                        $Row["Minimum"],
                        $Row["Maximum"],
                        $Row["StationLocalDate"],
                        $Row["StationLocalTime"]
                              );
      $count=$sql->num_rows;
      $rtn['Status']=0;
      $rtn['Count']=$count;
      if ($count>0) {
        while($sql->fetch()){
          $e["HistoricalWeatherID"]=$Row["HistoricalWeatherID"];
          $e["Minimum"]=$Row["Minimum"];
          $e["Maximum"]=$Row["Maximum"];
          $e["StationLocalDate"]=$Row["StationLocalDate"];
          $e["StationLocalTime"]=$Row["StationLocalTime"];
          $entry[$Row["HistoricalWeatherID"]]=$e;        }
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
