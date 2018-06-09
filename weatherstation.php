<?php
//   
//
//
session_start();
require_once("assets/inc/iReporting.php");

require_once("assets/inc/iConnect.php");
require_once("assets/inc/iQueries.php");
// require_once("assets/inc/fFunctions.php");
require_once("assets/inc/iInitialize.php");
require_once("assets/inc/io/fHistoricalWeatherIO.php");
require_once("assets/inc/io/fControlIO.php");
require_once("assets/inc/io/fActionsIO.php");

$pageIndex='weatherstation';
$stationID='6100245999979349';

// initialize
$__Current=True;
$__GoodTemperature=True;

$_DateClass="";
$_TemperatureClass="";
$nowUTC = gmdate("Y-m-d H:i:s");

$coldframechartdata='';

unset($yesterdaysTemperatureData);
unset($todaysTemperatureData);
unset($yesterdaysPressureData);
unset($todaysPressureData);
unset($yesterdaysColdFrameData);
unset($todaysColdFrameData);
unset($yesterdaysHumidityData);
unset($todaysHumidityData);
$yesterdaysTemperatureData='';
$todaysTemperatureData='';
$yesterdaysPressureData='';
$todaysPressureData='';
$yesterdaysColdFrameData='';
$todaysColdFrameData='';
$yesterdaysHumidityData='';
$todaysHumidityData='';

$monthMax='';$monthMin='';$monthLabels='';
$monthCFMax='';$monthCFMin='';
$yearMax='';$yearMin='';$yearLabels='';
$yearCFMax='';
$yearCFMin='';

// set all actions for buttons
$actionButtons='';

 // TODO historicalweatherLastEntryByStation to get current temp, coldframe, pressure, humidity, dewpoint
 $panel='';
 if (isset($_id)) {
  unset($data);
  $data=$querytable['historicalweatherLastEntryByStation'];
  $data['parm']=Array($_id);
  $gc=getHistoricalWeather($mysqli,$data);
  if (($gc['Status']==0) && ($gc['Count']>0)) {
    foreach ($gc['Rows'] as $key => $current) {}
  } else {
    $current['Temperature']=0;
    $current['ColdFrameTemperature']=Null;
    $current['Pressure']=0;
    $current['RelativeHumidity']=0;
    $current['DewPoint']=0;
    $current['Probe']='None';
    $current['StationLocalDate']='0000-00-00';
    $current['StationLocalTime']='00:00:00';
  }
  if (($gc['Status']==0) && ($gc['Count']>0)) {
   //  check currency
    $to_time = strtotime($nowUTC);
    $from_time = strtotime($current['StationUTCDate'].' '.$current['StationUTCTime']);
    $lag=round(abs($to_time - $from_time) / 60,2);
    if ($lag>15) {$__Current=False;$_DateClass="text-danger";}
    //  check probe
    if ($current['Probe']=='SenseHat') {$__GoodTemperature=False;$_TemperatureClass="text-danger";}

    // overnight low
    unset($data);
    $data=$querytable['OvernightLowTemperatureByStation'];
    $data['parm']=Array($_id);
    $gonl=getMinMaxHistoricalWeather($mysqli,$data);
    if (($gonl['Status']==0) && ($gonl['Count']>0)) {
      foreach ($gonl['Rows'] as $key => $overnightlow) {}
    } else {
      $overnightlow['Minimum']=Null;
      $overnightlow['StationUTCTime']='00:00:00';
    }

    // daytime high
    unset($data);
    $data=$querytable['DaytimeHighTemperatureByHourByStation'];
    $data['parm']=Array($_id);
    $gdth=getMinMaxHistoricalWeather($mysqli,$data);
    if (($gdth['Status']==0) && ($gdth['Count']>0)) {
      foreach ($gdth['Rows'] as $key => $daytimehigh) {}
    } else {
      $daytimehigh['Maximum']=Null;
      $daytimehigh['StationUTCTime']='00:00:00';
    }

    // init day array
    for ($i=0; $i < 24 ; $i++) {
      $s=($i<10?'0'.$i:$i);
      $day[$s]=Array();
    }

    // get yesterday's temperature chart data
    $comparativeTemperature=Array();
    unset($data);
    $data=$querytable['YesterdaysTemperatureMinMaxByHourByStation'];
    $data['parm']=Array($_id);
    $ghy=getMinMaxHistoricalWeather($mysqli,$data);
    if (($ghy['Status']==0) && ($ghy['Count']>0)) {
      foreach ($ghy['Rows'] as $key => $ht) {
        $day[substr($ht['StationLocalTime'],0,2)]['YesterdaysTemperature']=$ht['Maximum'];
        // echo 'yesterday=>' . substr($ht['StationLocalTime'],0,2).' max='.$ht['Maximum'].'<br/>';
        $comparativeTemperature['Yesterday'][substr($ht['StationLocalTime'],0,2)]=$ht['Maximum'];
      }
    }

    // get today's temperature chart data
    unset($data);
    $data=$querytable['TodaysTemperatureMinMaxByHourByStation'];
    $data['parm']=Array($_id);
    $ght=getMinMaxHistoricalWeather($mysqli,$data);
    if (($ght['Status']==0) && ($ght['Count']>0)) {
      foreach ($ght['Rows'] as $key => $ht) {
        $day[substr($ht['StationLocalTime'],0,2)]['TodaysTemperature']=$ht['Maximum'];
        $comparativeTemperature['Today'][substr($ht['StationLocalTime'],0,2)]=$ht['Maximum'];
        // echo 'today=>' . substr($ht['StationLocalTime'],0,2).' max='.$ht['Maximum'].'<br/>';
      }
    }

    // get yesterday's pressure data
    $comparativePressure=Array();
    unset($data);
    $data=$querytable['YesterdaysPressureMinMaxByHourByStation'];
    $data['parm']=Array($_id);
    $ghy=getMinMaxHistoricalWeather($mysqli,$data);
    if (($ghy['Status']==0) && ($ghy['Count']>0)) {
      foreach ($ghy['Rows'] as $key => $ht) {
        $day[substr($ht['StationLocalTime'],0,2)]['YesterdaysPressure']=$ht['Maximum'];
        $comparativePressure['Yesterday'][substr($ht['StationLocalTime'],0,2)]=$ht['Maximum'];
      }
    }
    // get today's pressure data
    unset($data);
    $data=$querytable['TodaysPressureMinMaxByHourByStation'];
    $data['parm']=Array($_id);
    $ght=getMinMaxHistoricalWeather($mysqli,$data);
    if (($ght['Status']==0) && ($ght['Count']>0)) {
      foreach ($ght['Rows'] as $key => $ht) {
        $day[substr($ht['StationLocalTime'],0,2)]['TodaysPressure']=$ht['Maximum'];
        $comparativePressure['Today'][substr($ht['StationLocalTime'],0,2)]=$ht['Maximum'];
      }
    }

    // get yesterday's coldframe data
    $comparativeColdFrame=Array();
    unset($data);
    $data=$querytable['YesterdaysColdFrameMinMaxByHourByStation'];
    $data['parm']=Array($_id);
    $ghy=getMinMaxHistoricalWeather($mysqli,$data);
    if (($ghy['Status']==0) && ($ghy['Count']>0)) {
      foreach ($ghy['Rows'] as $key => $ht) {
        $day[substr($ht['StationLocalTime'],0,2)]['YesterdaysColdFrame']=$ht['Maximum'];
        $comparativeColdFrame['Yesterday'][substr($ht['StationLocalTime'],0,2)]=$ht['Maximum'];
      }
    }
    if (!empty($current['ColdFrameTemperature'])) {
      // get today's coldframe data
      unset($data);
      $data=$querytable['TodaysColdFrameMinMaxByHourByStation'];
      $data['parm']=Array($_id);
      $gcf=getMinMaxHistoricalWeather($mysqli,$data);
      if (($gcf['Status']==0) && ($gcf['Count']>0)) {
        foreach ($gcf['Rows'] as $key => $ht) {
          $day[substr($ht['StationLocalTime'],0,2)]['TodaysColdFrame']=$ht['Maximum'];
          $comparativeColdFrame['Today'][substr($ht['StationLocalTime'],0,2)]=$ht['Maximum'];
        }
      }
    }

    // get yesterday's humidity data
    $comparativeHumidity=Array();
    unset($data);
    $data=$querytable['YesterdaysHumidityMinMaxByHourByStation'];
    $data['parm']=Array($_id);
    $ghy=getMinMaxHistoricalWeather($mysqli,$data);
    if (($ghy['Status']==0) && ($ghy['Count']>0)) {
      foreach ($ghy['Rows'] as $key => $ht) {
        $day[substr($ht['StationLocalTime'],0,2)]['YesterdaysHumidity']=$ht['Maximum'];
        $comparativeHumidity['Yesterday'][substr($ht['StationLocalTime'],0,2)]=$ht['Maximum'];
      }
    }
    // get today's humidity data
    unset($data);
    $data=$querytable['TodaysHumidityMinMaxByHourByStation'];
    $data['parm']=Array($_id);
    $ght=getMinMaxHistoricalWeather($mysqli,$data);
    if (($ght['Status']==0) && ($ght['Count']>0)) {
      foreach ($ght['Rows'] as $key => $ht) {
        $day[substr($ht['StationLocalTime'],0,2)]['TodaysHumidity']=$ht['Maximum'];
        $comparativeHumidity['Today'][substr($ht['StationLocalTime'],0,2)]=$ht['Maximum'];
      }
    }

    // build chart data
    $yesterdaysTemperatureData='';
    $todaysTemperatureData='';
    $yesterdaysPressureData='';
    $todaysPressureData='';
    $yesterdaysColdFrameData='';
    $todaysColdFrameData='';
    $yesterdaysHumidityData='';
    $todaysHumidityData='';

    $dataDelimiter='';
    for ($i=0; $i < 24 ; $i++) {
      $s=($i<10?'0'.$i:$i);
      $todaysHumidityData.=$dataDelimiter.(array_key_exists('TodaysHumidity',$day[$s])?$day[$s]['TodaysHumidity']:'');
      $yesterdaysHumidityData.=$dataDelimiter.(array_key_exists('YesterdaysHumidity',$day[$s])?$day[$s]['YesterdaysHumidity']:'');
      $todaysColdFrameData.=$dataDelimiter.(array_key_exists('TodaysColdFrame',$day[$s])?$day[$s]['TodaysColdFrame']:'');
      $yesterdaysColdFrameData.=$dataDelimiter.(array_key_exists('YesterdaysColdFrame',$day[$s])?$day[$s]['YesterdaysColdFrame']:'');
      $todaysPressureData.=$dataDelimiter.(array_key_exists('TodaysPressure',$day[$s])?$day[$s]['TodaysPressure']:'');
      $yesterdaysPressureData.=$dataDelimiter.(array_key_exists('YesterdaysPressure',$day[$s])?$day[$s]['YesterdaysPressure']:'');
      $todaysTemperatureData.=$dataDelimiter.(array_key_exists('TodaysTemperature',$day[$s])?$day[$s]['TodaysTemperature']:'');
      $yesterdaysTemperatureData.=$dataDelimiter.(array_key_exists('YesterdaysTemperature',$day[$s])?$day[$s]['YesterdaysTemperature']:'');
      $dataDelimiter=',';
    }
    if (!empty($current['ColdFrameTemperature'])) {
      $coldframechartdata=', {
          label: "Coldframe",
          fill: false,
          pointRadius: 0,
          backgroundColor: "rgba(0,255,0,1)",
          borderColor: "rgba(0,255,0,1)",
          data: ['.$todaysColdFrameData.']}';
    }

    // get last month's temperature data
    $comparativeMonthTemp=Array();
    $dataDelimiter='';
    unset($data);
    // $data=$querytable['LastMonthTemperatureMinMaxByStation'];
    $data=$querytable['LastMonthTemperatureMinMaxByStation'];
    $data['parm']=Array($_id);
    $gmt=getMinMaxHistoricalWeather($mysqli,$data);
    if (($gmt['Status']==0) && ($gmt['Count']>0)) {
      foreach ($gmt['Rows'] as $key => $mt) {
        $comparativeMonthTemp['Max'][$mt['StationLocalDate']]=$mt['Maximum'];
        $comparativeMonthTemp['Min'][$mt['StationLocalDate']]=$mt['Minimum'];
        $monthMax.=$dataDelimiter.$mt['Maximum'];
        $monthMin.=$dataDelimiter.$mt['Minimum'];
        $monthLabels.=$dataDelimiter.'"'.substr($mt['StationLocalDate'],-2).'"';
        $dataDelimiter=',';
      }
    }
    // get last month's coldframe data
    $comparativeMonthTemp=Array();
    $dataDelimiter='';
    unset($data);
    $data=$querytable['LastMonthColdFrameMinMaxByStation'];
    $data['parm']=Array($_id);
    $gmt=getMinMaxHistoricalWeather($mysqli,$data);
    if (($gmt['Status']==0) && ($gmt['Count']>0)) {
      foreach ($gmt['Rows'] as $key => $mt) {
        $comparativeMonthCFTemp['Max'][$mt['StationLocalDate']]=$mt['Maximum'];
        $comparativeMonthCFTemp['Min'][$mt['StationLocalDate']]=$mt['Minimum'];
        $monthCFMax.=$dataDelimiter.$mt['Maximum'];
        $monthCFMin.=$dataDelimiter.$mt['Minimum'];
        $dataDelimiter=',';
      }
    }

    // get last year's temperature data
    $comparativeYearTemp=Array();
    $dataDelimiter='';
    unset($data);
    $data=$querytable['LastYearTemperatureMinMaxByStation'];
    $data['parm']=Array($_id);
    $gyt=getMinMaxHistoricalWeather($mysqli,$data);
    if (($gyt['Status']==0) && ($gyt['Count']>0)) {
      foreach ($gyt['Rows'] as $key => $yt) {
        $comparativeYearTemp['Max'][$yt['StationLocalDate']]=$yt['Maximum'];
        $comparativeYearTemp['Min'][$yt['StationLocalDate']]=$yt['Minimum'];
        $yearMax.=$dataDelimiter.$yt['Maximum'];
        $yearMin.=$dataDelimiter.$yt['Minimum'];
        $dateObj   = DateTime::createFromFormat('!m', substr($yt['StationLocalDate'],5,2));
        $monthName = $dateObj->format('F');
        $yearLabels.=$dataDelimiter.'"'.$monthName.'"';
        $dataDelimiter=',';
      }
    }
    // get last year's coldframe data
    $comparativeYearTemp=Array();
    $dataDelimiter='';
    unset($data);
    $data=$querytable['LastYearColdFrameMinMaxByStation'];
    $data['parm']=Array($_id);
    $gyc=getMinMaxHistoricalWeather($mysqli,$data);
    if (($gyc['Status']==0) && ($gyc['Count']>0)) {
      foreach ($gyc['Rows'] as $key => $ycf) {
        $comparativeYearCF['Max'][$ycf['StationLocalDate']]=$ycf['Maximum'];
        $comparativeYearCF['Min'][$ycf['StationLocalDate']]=$ycf['Minimum'];
        $yearCFMax.=$dataDelimiter.$ycf['Maximum'];
        $yearCFMin.=$dataDelimiter.$ycf['Minimum'];
        // $yearMax.=$dataDelimiter.$yt['Maximum'];
        // $yearMin.=$dataDelimiter.$yt['Minimum'];
        // $dateObj   = DateTime::createFromFormat('!m', substr($yt['StationLocalDate'],5,2));
        // $monthName = $dateObj->format('F');
        // $yearLabels.=$dataDelimiter.'"'.$monthName.'"';
        $dataDelimiter=',';
      }
    }

    // get last month's pressure data
    $monthMaxPressure='';
    $monthMinPressure='';
    $monthLabelsPressure='';
    $comparativeMonthPressure=Array();
    $dataDelimiter='';
    unset($data);
    $data=$querytable['LastMonthPressureMinMaxByStation'];
    $data['parm']=Array($_id);
    $gmp=getMinMaxHistoricalWeather($mysqli,$data);
    if (($gmp['Status']==0) && ($gmp['Count']>0)) {
      foreach ($gmp['Rows'] as $key => $mp) {
        $comparativeMonthPressure['Max'][$mp['StationLocalDate']]=$mp['Maximum'];
        $comparativeMonthPressure['Min'][$mt['StationLocalDate']]=$mp['Minimum'];
        $monthMaxPressure.=$dataDelimiter.$mp['Maximum'];
        $monthMinPressure.=$dataDelimiter.$mp['Minimum'];
        $monthLabelsPressure.=$dataDelimiter.'"'.substr($mp['StationLocalDate'],-2).'"';
        $dataDelimiter=',';
      }
    }

  }
}

 // TODO get todays low & high
 // TODO graph temperature vs yesterday, last year

?>
    <!DOCTYPE html>
    <html lang="en">
      <head>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());
          gtag('config', 'UA-113446504-1');
        </script>
        <!-- Required meta tags -->
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
        <!-- <meta http-equiv="refresh" content="5" > -->
        <title>
          Pi Weather Station
        </title>
        <!-- Bootstrap CSS -->
        <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous"/> -->
        <link rel="stylesheet" href="assets/css/bootstrap.css"/>
        <link rel="stylesheet" href="assets/css/scrollhalf.css"/>
      </head>
      <body>
        <?php // require_once("assets/inc/iNavbar.php");?>
        <div class="container-fluid pushdown">
        <?php require_once("assets/inc/iM.php");?>
          <div class="row">

            <!-- main block -->
            <div class="col-md-9 col-sm-12">
              <div class="row mt-4">
                <div class="col-sm-6 col-md-3 text-right">
                  <div class=""><h5 class="<?php echo $_TemperatureClass;?>">Current</h2></div>
                    <div class="">
                      <h2 class="display-4"><?php echo $current['Temperature']; ?> C</h2>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 text-right">
                  <div class=""><h5 class="">Overnight Low</h2></div>
                    <div class="">
                      <h3 class="display-4"><?php echo $overnightlow['Minimum']; ?> C</h3>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 text-right">
                  <div class=""><h5 class="">Daytime High</h2></div>
                    <div class="">
                      <h2 class="display-4"><?php echo $daytimehigh['Maximum']; ?> C</h2>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 text-right">
                  <div class=""><h5 class=""><?php echo (!empty($current['ColdFrameTemperature'])?'ColdFrame':''); ?></h2></div>
                    <div class="">
                      <h2 class="display-4"><?php echo (!empty($current['ColdFrameTemperature'])?$current['ColdFrameTemperature'].' C':''); ?></h2>
                    </div>
                </div>
              </div>

              <div class="row justify-content-center mt-4">
                <div class="col-md-12 col-sm-12 text-center">
                  <h3 class="display-4">Today</h3>
                  <canvas style="height:400px" id="todaystemperature"></canvas>
                </div>
              </div>
              <div class="row justify-content-center mt-4">
                <div class="col-md-12 col-sm-12 text-center">
                  <h3 class="display-4">30 Days</h3>
                  <canvas style="height:400px" id="monthstemperature"></canvas>
                </div>
              </div>
              <div class="row justify-content-center mt-4">
                <div class="col-md-12 col-sm-12 text-center">
                  <h3 class="display-4">12 Months</h3>
                  <canvas style="height:400px" id="yearstemperature"></canvas>
                </div>
              </div>
              <div class="row justify-content-center mt-4">
                <div class="col-md-12 col-sm-12 text-center">
                  <h3 class="display-4">Barometric Pressure</h3>
                  <canvas style="height:400px" id="monthpressure"></canvas>
                </div>
              </div>
            </div>

            <!-- right sidebar -->
            <div style="background:#404040;color:white;" class="col-md-3 col-sm-12">
              <div class="row mt-4">
                <div class="col-6 mt-4">
                  <div class="col text-right"><h5 class="">Dew Point</h2></div>
                </div>
                <div class="col-6 mt-4">
                  <div class="col text-right"><h5 class="">Humidity</h2></div>
                </div>
              </div>
              <div class="row">
                <div class="col-6">
                  <div class="col text-right"><h2 class="display-5"><?php echo $current['DewPoint']; ?> C</h2></div>
                </div>
                <div class="col-6">
                  <div class="col text-right"><h2 class="display-5"><?php echo $current['RelativeHumidity']; ?>%</h2></div>
                </div>
              </div>
              <div class="row">
                <div class="col-12 mt-4">
                  <canvas style="height:400px" id="todayshumidity"></canvas>
                </div>
              </div>

              <div class="row mt-4">
                <div class="col-12 mt-4">
                  <div class="col text-right"><h5 class="">Pressure</h2></div>
                </div>
                <div class="col-12">
                  <div class="col text-right"><h2 class="display-5"><?php echo $current['Pressure']; ?>mB</h2></div>
                </div>
                <div class="col-12 mt-4">
                  <canvas style="height:400px" id="todayspressure"></canvas>
                </div>


                <div class="col-12">
                  <div class="col text-right mt-4"><h6 class="<?php echo $_DateClass;?>">Local <?php echo $current['StationLocalDate'].' '.$current['StationLocalTime']; ?></h6></div>
                </div>
              </div>
            </div>
          </div>

          <div class="row mb-4">
            <div class="col-12 ml-2 mr-2">

              <!-- <p>
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#multiCollapseExample1" aria-expanded="false" aria-controls="multiCollapseExample2">Controls</button>
              </p> -->
              <div class="collapse multi-collapse" id="multiCollapseExample1">
                <div class="row">
                  <?php echo $actionButtons;?>
                </div>
              </div>

            </div>
          </div>

        </div>
        <!-- jQuery first, then Tether, then Bootstrap JS. -->
        <script src="assets/js/jquery-3.1.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
        <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script> -->
        <script src="assets/js/bootstrap.js"></script>
        <script src="assets/js/Chart.bundle.js"></script>
        <script type="text/javascript">
        $(window).resize(function() {
            $("#width").html($(window).width());
            $("#height").html($(window).height());
        }).resize();
        </script>
        <script>
        $(document).ready(function(){
          var tar='<?php echo $stationID;?>'
          var request = $.ajax({
            url: "assets/ajax/aSummarize.php",
            type: "POST",
            data: {"_sid": tar},
            dataType: "json",
            cache: false
          });
          request.done(function(result) {
            if (result['Status']==0) {
              if (("Message" in result)) {
                $("#messagespace").html(result["Message"]);
              }
            }
          });
          request.fail(function(jqXHR, textStatus) {
            // notifyError("Something went wrong. Request failed: " + textStatus + " <b>Please retry later.</b>");
            console.log( "Summarization failed: " + textStatus);
          });
          request.always(function(jqXHR, textStatus) {
            $("#busyindicator").removeClass("fa-refresh");
            // busy('done');
          });
        });
        </script>
        <script>
          function actionControl(tar) {
            $("#busyindicator").addClass("fa-refresh");
            $("#btn"+tar).addClass("btn-outline-danger").removeClass("btn-outline-success");
            // var id=$("#core_page").attr("data-ID");
            var request = $.ajax({
              url: "assets/ajax/aActionToControl.php",
              type: "POST",
              data: {"_id": tar},
              dataType: "json",
              cache: false
            });
            request.done(function(result) {
              if (result['Status']==0) {
                if (("Message" in result)) {
                  $("#messagespace").html(result["Message"]);
                }
                // $("#help_"+tar).html('');
                // $("#fg"+tar).removeClass("has-danger").addClass("has-success");
                // $("#"+tar).removeClass("form-control-danger").addClass("form-control-success");
              }
            });
            request.fail(function(jqXHR, textStatus) {
              // notifyError("Something went wrong. Request failed: " + textStatus + " <b>Please retry later.</b>");
              console.log( "Update Control failed: " + textStatus);
            });
            request.always(function(jqXHR, textStatus) {
              $("#busyindicator").removeClass("fa-refresh");
              // busy('done');
            });
          }
        </script>
        <script>
        // var MONTHS = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        var configtodaystemperature = {
            type: 'line',
            data: {
                labels: ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23"],
                datasets: [{
                    label: "Yesterday",
                    pointRadius: 0,
                    spanGaps: true,
                    backgroundColor: 'rgba(0,0,255,1)',
                    borderColor: 'rgba(0,0,255,1)',
                    data: [<?php echo $yesterdaysTemperatureData;?>],
                    fill: false,
                }, {
                    label: "Today",
                    fill: false,
                    pointRadius: 0,
                    backgroundColor: 'rgba(255,0,0,1)',
                    borderColor: 'rgba(255,0,0,1)',
                    data: [<?php echo $todaysTemperatureData;?>],
                }<?php echo $coldframechartdata;?>]
            },
            options: {
                responsive: true,
                title:{
                    display:false,
                    text:'Current Temperature'
                },
                tooltips: {
                    mode: 'index',
                    intersect: false,
                },
                hover: {
                    mode: 'nearest',
                    intersect: true
                },
                scales: {
                    xAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Hour'
                        }
                    }],
                    yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'C'
                        }
                    }]
                }
            }
        };
        var configtodayspressure = {
            type: 'line',
            data: {
                labels: ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23"],
                datasets: [{
                    label: "Yesterday",
                    pointRadius: 0,
                    spanGaps: true,
                    backgroundColor: 'rgba(0,0,255,1)',
                    borderColor: 'rgba(0,0,255,1)',
                    data: [<?php echo $yesterdaysPressureData;?>],
                    fill: false,
                }, {
                    label: "Today",
                    fill: false,
                    pointRadius: 0,
                    backgroundColor: 'rgba(255,0,0,1)',
                    borderColor: 'rgba(255,0,0,1)',
                    data: [<?php echo $todaysPressureData;?>],
                }]
            },
            options: {
                responsive: true,
                title:{
                    display:false,
                    text:'Current Pressure In Millibars'
                },
                tooltips: {
                    mode: 'index',
                    intersect: false,
                },
                hover: {
                    mode: 'nearest',
                    intersect: true
                },
                scales: {
                    xAxes: [{
                        display: false,
                        scaleLabel: {
                            display: true,
                            labelString: 'Hour'
                        }
                    }],
                    yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'mB'
                        }
                    }]
                }
            }
        };
        var configtodayshumidity = {
            type: 'line',
            data: {
                labels: ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23"],
                datasets: [{
                    label: "Yesterday",
                    pointRadius: 0,
                    spanGaps: true,
                    backgroundColor: 'rgba(0,0,255,1)',
                    borderColor: 'rgba(0,0,255,1)',
                    data: [<?php echo $yesterdaysHumidityData;?>],
                    fill: false,
                }, {
                    label: "Today",
                    fill: false,
                    pointRadius: 0,
                    backgroundColor: 'rgba(255,0,0,1)',
                    borderColor: 'rgba(255,0,0,1)',
                    data: [<?php echo $todaysHumidityData;?>],
                }]
            },
            options: {
                responsive: true,
                title:{
                    display:false,
                    text:'Current Humidity'
                },
                tooltips: {
                    mode: 'index',
                    intersect: false,
                },
                hover: {
                    mode: 'nearest',
                    intersect: true
                },
                scales: {
                    xAxes: [{
                        display: false,
                        scaleLabel: {
                            display: true,
                            labelString: 'Hour'
                        }
                    }],
                    yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: '%'
                        }
                    }]
                }
            }
        };
        // last month
        var configmonthstemperature = {
            type: 'line',
            data: {
              // labels: ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23"],
              labels: [<?php echo $monthLabels;?>],
                datasets: [{
                    label: "Low",
                    pointRadius: 0,
                    spanGaps: true,
                    backgroundColor: 'rgba(0,0,255,1)',
                    borderColor: 'rgba(0,0,255,1)',
                    data: [<?php echo $monthMin;?>],
                    fill: false,
                }, {
                    label: "High",
                    fill: false,
                    pointRadius: 0,
                    spanGaps: true,
                    backgroundColor: 'rgba(255,0,0,1)',
                    borderColor: 'rgba(255,0,0,1)',
                    data: [<?php echo $monthMax;?>],
                }, {
                    label: "CF Low",
                    fill: false,
                    pointRadius: 0,
                    spanGaps: true,
                    backgroundColor: 'rgba(0,153,0,1)',
                    borderColor: 'rgba(0,153,0,1)',
                    data: [<?php echo $monthCFMin;?>],
                }, {
                    label: "CF High",
                    fill: 2,
                    pointRadius: 0,
                    spanGaps: true,
                    backgroundColor: 'rgba(0,153,0,1)',
                    borderColor: 'rgba(0,153,0,1)',
                    data: [<?php echo $monthCFMax;?>],
                }]
            },
            options: {
                responsive: true,
                title:{
                    display:false,
                    text:'Last 30 Days'
                },
                tooltips: {
                    mode: 'index',
                    intersect: false,
                },
                hover: {
                    mode: 'nearest',
                    intersect: true
                },
                scales: {
                    xAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Day Of The Month'
                        }
                    }],
                    yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'C'
                        }
                    }]
                }
            }
        };
        // last year
        var configyearstemperature = {
            type: 'line',
            data: {
                labels: [<?php echo $yearLabels;?>],
                datasets: [{
                    label: "Low",
                    pointRadius: 0,
                    spanGaps: true,
                    backgroundColor: 'rgba(0,0,255,1)',
                    borderColor: 'rgba(0,0,255,1)',
                    data: [<?php echo $yearMin;?>],
                    fill: false,
                }, {
                    label: "High",
                    fill: false,
                    pointRadius: 0,
                    spanGaps: true,
                    backgroundColor: 'rgba(255,0,0,1)',
                    borderColor: 'rgba(255,0,0,1)',
                    data: [<?php echo $yearMax;?>],
                },
                {
                    label: "CF Low",
                    pointRadius: 0,
                    spanGaps: true,
                    backgroundColor: 'rgba(0,153,0,1)',
                    borderColor: 'rgba(0,153,0,1)',
                    data: [<?php echo $yearCFMin;?>],
                    fill: false,
                }, {
                    label: "CF High",
                    fill: false,
                    pointRadius: 0,
                    spanGaps: true,
                    backgroundColor: 'rgba(0,153,0,1)',
                    borderColor: 'rgba(0,153,0,1)',
                    data: [<?php echo $yearCFMax;?>],
                    fill: 2,
                }
              ]
            },
            options: {
                responsive: true,
                title:{
                    display:false,
                    text:'Last Year'
                },
                tooltips: {
                    mode: 'index',
                    intersect: false,
                },
                hover: {
                    mode: 'nearest',
                    intersect: true
                },
                scales: {
                    xAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Month'
                        }
                    }],
                    yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'C'
                        }
                    }]
                }
            }
        };
        // {
        //     label: "CF Low",
        //     pointRadius: 0,
        //     spanGaps: true,
        //     backgroundColor: 'rgba(0,153,0,1)',
        //     borderColor: 'rgba(0,153,0,1)',
        //     data: [<?php// echo $yearCFMin;?>],
        //     fill: false,
        // }, {
        //     label: "CF High",
        //     fill: false,
        //     pointRadius: 0,
        //     spanGaps: true,
        //     backgroundColor: 'rgba(0,153,0,1)',
        //     borderColor: 'rgba(0,153,0,1)',
        //     data: [<?php// echo $yearCFMax;?>],
        //     fill: 2,
        // }
        // last year
        var configmonthpressure = {
            type: 'line',
            data: {
                labels: [<?php echo $monthLabelsPressure;?>],
                datasets: [{
                    label: "Low",
                    pointRadius: 0,
                    spanGaps: true,
                    backgroundColor: 'rgba(0,0,255,1)',
                    borderColor: 'rgba(0,0,255,1)',
                    data: [<?php echo $monthMinPressure;?>],
                    fill: false,
                }, {
                    label: "High",
                    fill: false,
                    pointRadius: 0,
                    spanGaps: true,
                    backgroundColor: 'rgba(255,0,0,1)',
                    borderColor: 'rgba(255,0,0,1)',
                    data: [<?php echo $monthMaxPressure;?>],
                }
              ]
            },
            options: {
                responsive: true,
                title:{
                    display:false,
                    text:'Pressure'
                },
                tooltips: {
                    mode: 'index',
                    intersect: false,
                },
                hover: {
                    mode: 'nearest',
                    intersect: true
                },
                scales: {
                    xAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Month'
                        }
                    }],
                    yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'mB'
                        }
                    }]
                }
            }
        };

        // make graphs
        window.onload = function() {
            var ctxtodaystemperature = document.getElementById("todaystemperature").getContext("2d");
            window.myLine = new Chart(ctxtodaystemperature, configtodaystemperature);
            var ctxtodayspressure = document.getElementById("todayspressure").getContext("2d");
            window.myLine = new Chart(ctxtodayspressure, configtodayspressure);
            var ctxtodayshumidity = document.getElementById("todayshumidity").getContext("2d");
            window.myLine = new Chart(ctxtodayshumidity, configtodayshumidity);
            var ctxmonthstemperature = document.getElementById("monthstemperature").getContext("2d");
            window.myLine = new Chart(ctxmonthstemperature, configmonthstemperature);
            var ctxyearstemperature = document.getElementById("yearstemperature").getContext("2d");
            window.myLine = new Chart(ctxyearstemperature, configyearstemperature);
            var ctxmonthpressure = document.getElementById("monthpressure").getContext("2d");
            window.myLine = new Chart(ctxmonthpressure, configmonthpressure);
        };

        </script>
      </body>
    </html>
