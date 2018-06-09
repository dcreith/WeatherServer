<?php
//
//
// requires
//
// $options=Array('Status'=>Array('Open'=>'Open',
//                                 'Active'=>'Active',
//                                 'Shipped'=>'Shipped',
//                                 'Received'=>'Received',
//                                 'Hopeless'=>'Hopeless',
//                                 'Cancelled'=>'Cancelled'),
//                 'Include'=>Array('Yes'=>'Yes','No'=>'No')
//               );

// column definitions
$definitions=Array('HistoricalWeatherID'=>Array('short'=>'hwi','required'=>'no','bind'=>'i','default'=>'','heading'=>'HistoricalWeatherID','label'=>'HistoricalWeatherID','align'=>'right','tip'=>''),
                  'Temperature'=>Array('short'=>'t','required'=>'yes','bind'=>'d','default'=>0,'heading'=>'Temperature','label'=>'Temperature','align'=>'right','tip'=>''),
                  'ColdFrameTemperature'=>Array('short'=>'cf','required'=>'no','bind'=>'d','default'=>0,'heading'=>'Cold Frame','label'=>'Cold Frame','align'=>'right','tip'=>''),
                  'Pressure'=>Array('short'=>'p','required'=>'no','bind'=>'d','default'=>0.00,'heading'=>'Pressure','label'=>'Pressure','align'=>'right','tip'=>''),
                  'RelativeHumidity'=>Array('short'=>'rh','required'=>'no','bind'=>'d','default'=>0,'heading'=>'RelativeHumidity','label'=>'RelativeHumidity','align'=>'right','tip'=>''),
                  'DewPoint'=>Array('short'=>'dp','required'=>'no','bind'=>'d','default'=>0,'heading'=>'DewPoint','label'=>'DewPoint','align'=>'right','tip'=>''),
                  'WindSpeed'=>Array('short'=>'ws','required'=>'no','bind'=>'i','default'=>0,'heading'=>'WindSpeed','label'=>'WindSpeed','align'=>'right','tip'=>''),
                  'WindDirectionDegrees'=>Array('short'=>'wdd','required'=>'no','bind'=>'i','default'=>0,'heading'=>'WindDirectionDegrees','label'=>'WindDirectionDegrees','align'=>'right','tip'=>''),
                  'WindDirectionEmpirical'=>Array('short'=>'wde','required'=>'no','bind'=>'s','default'=>'','heading'=>'WindDirectionEmpirical','label'=>'WindDirectionEmpirical','align'=>'left','tip'=>''),
                  'Luminousity'=>Array('short'=>'l','required'=>'no','bind'=>'i','default'=>0,'heading'=>'Luminousity','label'=>'Luminousity','align'=>'right','tip'=>''),
                  'UVIndex'=>Array('short'=>'uv','required'=>'no','bind'=>'d','default'=>0.00,'heading'=>'UV Index','label'=>'UV Index','align'=>'right','tip'=>''),
                  'DayPeriod'=>Array('short'=>'per','required'=>'no','bind'=>'s','default'=>'','heading'=>'DayPeriod','label'=>'DayPeriod','align'=>'left','tip'=>''),
                  'Probe'=>Array('short'=>'pid','required'=>'no','bind'=>'s','default'=>'','heading'=>'Probe','label'=>'Probe','align'=>'left','tip'=>''),
                  'ColdFrameProbe'=>Array('short'=>'cid','required'=>'no','bind'=>'s','default'=>'','heading'=>'CF Probe','label'=>'CF Probe','align'=>'left','tip'=>''),
                  'StationID'=>Array('short'=>'si','required'=>'yes','bind'=>'s','default'=>'','heading'=>'StationID','label'=>'StationID','align'=>'left','tip'=>''),
                  'StationLocalDate'=>Array('short'=>'sld','required'=>'yes','bind'=>'s','default'=>'0000-00-00','heading'=>'StationLocalDate','label'=>'StationLocalDate','align'=>'center','tip'=>''),
                  'StationLocalTime'=>Array('short'=>'slt','required'=>'yes','bind'=>'s','default'=>'00:00:00','heading'=>'StationLocalTime','label'=>'StationLocalTime','align'=>'left','tip'=>''),
                  'StationTimeZone'=>Array('short'=>'stz','required'=>'yes','bind'=>'s','default'=>'Unknown','heading'=>'StationTimeZone','label'=>'StationTimeZone','align'=>'left','tip'=>''),
                  'StationUTCDate'=>Array('short'=>'sud','required'=>'yes','bind'=>'s','default'=>'0000-00-00','heading'=>'StationUTCDate','label'=>'StationUTCDate','align'=>'center','tip'=>''),
                  'StationUTCTime'=>Array('short'=>'sut','required'=>'yes','bind'=>'s','default'=>'00:00:00','heading'=>'StationUTCTime','label'=>'StationUTCTime','align'=>'left','tip'=>''),
                  'Added'=>Array('short'=>'ad','required'=>'no','bind'=>'s','default'=>'0000-00-00 00:00:00','heading'=>'Added','label'=>'Added','align'=>'center','tip'=>''),
                  'Status'=>Array('short'=>'st','required'=>'yes','bind'=>'s','default'=>'None','heading'=>'Status','label'=>'Status','align'=>'left','tip'=>''),
                  'DisplayDim'=>Array('short'=>'dd','required'=>'yes','bind'=>'i','default'=>0,'heading'=>'DisplayDim','label'=>'DisplayDim','align'=>'right','tip'=>''),
                  'DisplayOn'=>Array('short'=>'do','required'=>'yes','bind'=>'i','default'=>0,'heading'=>'DisplayOn','label'=>'DisplayOn','align'=>'right','tip'=>''),
                  'ColdFrameOn'=>Array('short'=>'co','required'=>'yes','bind'=>'i','default'=>0,'heading'=>'ColdFrameOn','label'=>'ColdFrameOn','align'=>'right','tip'=>''),
                  'WUUpload'=>Array('short'=>'wu','required'=>'yes','bind'=>'i','default'=>0,'heading'=>'WUUpload','label'=>'WUUpload','align'=>'right','tip'=>''),
                  'ControlID'=>Array('short'=>'ci','required'=>'yes','bind'=>'s','default'=>'','heading'=>'ControlID','label'=>'ControlID','align'=>'left','tip'=>''),
                  'ParameterType'=>Array('short'=>'pt','required'=>'yes','bind'=>'s','default'=>'I','heading'=>'ParameterType','label'=>'ParameterType','align'=>'left','tip'=>''),
                  'ParameterInt'=>Array('short'=>'pi','required'=>'no','bind'=>'i','default'=>0,'heading'=>'ParameterInt','label'=>'ParameterInt','align'=>'right','tip'=>''),
                  'ParameterChar'=>Array('short'=>'pc','required'=>'no','bind'=>'s','default'=>'','heading'=>'ParameterChar','label'=>'ParameterChar','align'=>'left','tip'=>''),
                  'Updated'=>Array('short'=>'u','required'=>'no','bind'=>'s','default'=>'0000-00-00 00:00:00','heading'=>'Updated','label'=>'Updated','align'=>'center','tip'=>''),
                  'ActionID'=>Array('short'=>'ai','required'=>'no','bind'=>'i','default'=>0,'heading'=>'ActionID','label'=>'ActionID','align'=>'right','tip'=>''),
                  'Action'=>Array('short'=>'a','required'=>'yes','bind'=>'s','default'=>'Unknown','heading'=>'Action','label'=>'Action','align'=>'left','tip'=>'')
              );

// HistoricalWeather
$tableDef=Array('HistoricalWeatherID',
                'Temperature',
                'ColdFrameTemperature',
                'Pressure',
                'RelativeHumidity',
                'DewPoint',
                'WindSpeed',
                'WindDirectionDegrees',
                'WindDirectionEmpirical',
                'Luminousity',
                'UVIndex',
                'DayPeriod',
                'Probe',
                'ColdFrameProbe',
                'StationID',
                'StationLocalDate',
                'StationLocalTime',
                'StationTimeZone',
                'StationUTCDate',
                'StationUTCTime',
                'Added');
$tableDefinitions['HistoricalWeather']=$tableDef;

unset($tableDef);
$tableDef=Array('ControlID',
                'ParameterType',
                'ParameterInt',
                'ParameterChar',
                'StationID',
                'Updated');
$tableDefinitions['Control']=$tableDef;

unset($tableDef);
$tableDef=Array('ActionID',
                'Action',
                'ControlID',
                'ParameterType',
                'ParameterInt',
                'ParameterChar',
                'Updated');
$tableDefinitions['Actions']=$tableDef;

unset($tableDef);
$tableDef=Array('StationID',
                'Status',
                'DisplayDim',
                'DisplayOn',
                'ColdFrameOn',
                'WUUpload',
                'Updated');
$tableDefinitions['Settings']=$tableDef;

$querytable=Array();

// Historical Weather
$historicalweatherquery="SELECT h.HistoricalWeatherID,
                h.Temperature,h.ColdFrameTemperature,h.Pressure,h.RelativeHumidity,h.DewPoint,
                h.WindSpeed,h.WindDirectionDegrees,h.WindDirectionEmpirical,
                h.Luminousity,h.UVIndex,h.DayPeriod,h.Probe,h.ColdFrameProbe,
                h.StationID,h.StationLocalDate,h.StationLocalTime,h.StationTimeZone,
                h.StationUTCDate,h.StationUTCTime,
                h.Added
              FROM HistoricalWeather h";

unset($query);
$query['bind']="i";
$query['query']=$historicalweatherquery." WHERE HistoricalWeatherID=?";
$querytable['historicalweatherByID']=$query;

unset($query);
$query['bind']="";
$query['query']=$historicalweatherquery." WHERE 1";
$querytable['historicalweatherByAll']=$query;

unset($query);
$query['bind']="s";
$query['query']=$historicalweatherquery." WHERE StationID=? ORDER BY HistoricalWeatherID DESC LIMIT 1";
$querytable['historicalweatherLastEntryByStation']=$query;

# unusual weather
unset($query);
$query['bind']="s";
$query['query']=$historicalweatherquery." WHERE StationID=? ORDER BY Temperature DESC LIMIT 1";
$querytable['historicalweatherTemperatureHigh']=$query;

unset($query);
$query['bind']="s";
$query['query']=$historicalweatherquery." WHERE StationID=? ORDER BY Temperature ASC LIMIT 1";
$querytable['historicalweatherTemperatureLow']=$query;

unset($query);
$query['bind']="s";
$query['query']=$historicalweatherquery." WHERE StationID=? ORDER BY ColdFrameTemperature DESC LIMIT 1";
$querytable['historicalweatherColdFrameHigh']=$query;

unset($query);
$query['bind']="s";
$query['query']=$historicalweatherquery." WHERE StationID=? ORDER BY ColdFrameTemperature ASC LIMIT 1";
$querytable['historicalweatherColdFrameLow']=$query;

unset($query);
$query['bind']="s";
$query['query']=$historicalweatherquery." WHERE StationID=? ORDER BY Pressure DESC LIMIT 1";
$querytable['historicalweatherPressureHigh']=$query;

unset($query);
$query['bind']="s";
$query['query']=$historicalweatherquery." WHERE StationID=? ORDER BY Pressure ASC LIMIT 1";
$querytable['historicalweatherPressureLow']=$query;

unset($query);
$query['bind']="s";
$query['query']=$historicalweatherquery." WHERE StationID=? and RelativeHumidity>0 ORDER BY RelativeHumidity DESC LIMIT 1";
$querytable['historicalweatherHumidityHigh']=$query;

unset($query);
$query['bind']="s";
$query['query']=$historicalweatherquery." WHERE StationID=? and RelativeHumidity>0  ORDER BY RelativeHumidity ASC LIMIT 1";
$querytable['historicalweatherHumidityLow']=$query;

// Historical Temperature Min/Max
$minmaxtemperaturequery="SELECT h.HistoricalWeatherID,
                                Min(h.Temperature) as MinV, Max(h.Temperature) as MaxV,
                                h.StationLocalDate, h.StationLocalTime
                          From HistoricalWeather h";

unset($query);
$query['bind']="s";
$query['query']=$minmaxtemperaturequery." WHERE ((DATE(h.StationLocalDate) = DATE(NOW())) AND (h.StationID=?)) GROUP BY HOUR(h.StationLocalTime) ORDER BY h.StationLocalDate ASC, h.StationLocalTime ASC";
$querytable['TodaysTemperatureMinMaxByHourByStation']=$query;

unset($query);
$query['bind']="s";
$query['query']=$minmaxtemperaturequery." WHERE ((DATE(h.StationLocalDate) = DATE(NOW() - INTERVAL 1 DAY)) AND (h.StationID=?)) GROUP BY HOUR(h.StationLocalTime) ORDER BY h.StationLocalDate ASC, h.StationLocalTime ASC";
$querytable['YesterdaysTemperatureMinMaxByHourByStation']=$query;

unset($query);
$query['bind']="s";
$query['query']=$minmaxtemperaturequery." WHERE ((h.StationID=?) AND ((DATE(h.StationLocalDate) = DATE(NOW() - INTERVAL 1 DAY) AND Hour(h.StationLocalTime)>17) OR (DATE(h.StationLocalDate) = DATE(NOW()) AND Hour(h.StationLocalTime)<6))) Group By h.StationID";
$querytable['OvernightLowTemperatureByStation']=$query;

unset($query);
$query['bind']="s";
$query['query']=$minmaxtemperaturequery." WHERE ((h.StationID=?) AND (DATE(h.StationLocalDate) = DATE(NOW()) AND Hour(h.StationLocalTime)>5)) Group By h.StationID";
$querytable['DaytimeHighTemperatureByHourByStation']=$query;

// Historical Temperature Min/Max In 30 Minute Intervals -->> change 1800 to 900 for 15 minute intervals
$minmax15temperaturequery="SELECT h.HistoricalWeatherID,
                                Min(h.Temperature) as MinV, Max(h.Temperature) as MaxV,
                                h.StationLocalDate,
                                date_format(date_add(h.StationLocalDate, interval timestampdiff(second, h.StationLocalDate, addtime(h.StationLocalDate, h.StationLocalTime)) div 1800 * 1800 second),\"%H:%i:%s\") AS StationLocalTime
                          From HistoricalWeather h";

unset($query);
$query['bind']="s";
$query['query']=$minmax15temperaturequery." WHERE ((DATE(h.StationLocalDate) = DATE(NOW())) AND (h.StationID=?))
GROUP BY h.StationLocalDate,
    timestampdiff(second, h.StationLocalDate, addtime(h.StationLocalDate, h.StationLocalTime)) div 1800
    ORDER BY h.StationLocalDate ASC, h.StationLocalTime ASC";
$querytable['TodaysTemperatureMinMaxBy15ByStation']=$query;

unset($query);
$query['bind']="s";
$query['query']=$minmax15temperaturequery." WHERE ((DATE(h.StationLocalDate) = DATE(NOW() - INTERVAL 1 DAY)) AND (h.StationID=?)) GROUP BY h.StationLocalDate,
    timestampdiff(second, h.StationLocalDate, addtime(h.StationLocalDate, h.StationLocalTime)) div 1800
    ORDER BY h.StationLocalDate ASC, h.StationLocalTime ASC";
$querytable['YesterdaysTemperatureMinMaxBy15ByStation']=$query;

// hourly weather for the last month by day
$minmaxhourlytemperaturequery="SELECT d.HourlyWeatherID, Min(d.TemperatureMin) as MinV, Max(d.TemperatureMax) as MaxV,
                                d.StationLocalDate, Concat(Hour(d.StationLocalTime),':00:00') as StationLocalHour
                          From HourlyWeather d";
unset($query);
$query['bind']="s";
$query['query']=$minmaxhourlytemperaturequery." WHERE ((DATE(d.StationLocalDate) > DATE(NOW() - INTERVAL 1 MONTH)) AND (d.StationID=?)) GROUP BY d.StationLocalDate, StationLocalHour ORDER BY d.StationLocalDate ASC, StationLocalHour ASC";
$querytable['LastMonthTemperatureMinMaxByHourByStation']=$query;

// daily temperature for the last month by day
$minmaxdailytemperaturequery="SELECT d.DailyWeatherID, Min(d.TemperatureMin) as MinV, Max(d.TemperatureMax) as MaxV,
                                d.StationLocalDate, '00:00:00'
                          From DailyWeather d";
unset($query);
$query['bind']="s";
$query['query']=$minmaxdailytemperaturequery." WHERE ((DATE(d.StationLocalDate) > DATE(NOW() - INTERVAL 1 MONTH)) AND (d.StationID=?)) GROUP BY d.StationLocalDate ORDER BY d.StationLocalDate ASC";
$querytable['LastMonthTemperatureMinMaxByStation']=$query;

unset($query);
$query['bind']="s";
$query['query']=$minmaxdailytemperaturequery." WHERE ((DATE(d.StationLocalDate) > DATE(NOW() - INTERVAL 7 DAY)) AND (d.StationID=?)) GROUP BY d.StationLocalDate ORDER BY d.StationLocalDate ASC";
$querytable['Last7DaysTemperatureMinMaxByStation']=$query;

// daily coldframe for the last month by day
$minmaxdailycoldframequery="SELECT d.DailyWeatherID, Min(d.ColdFrameTemperatureMin) as MinV, Max(d.ColdFrameTemperatureMax) as MaxV,
                                d.StationLocalDate, '00:00:00'
                          From DailyWeather d";
unset($query);
$query['bind']="s";
$query['query']=$minmaxdailycoldframequery." WHERE ((DATE(d.StationLocalDate) > DATE(NOW() - INTERVAL 1 MONTH)) AND (d.StationID=?)) GROUP BY d.StationLocalDate ORDER BY d.StationLocalDate ASC";
$querytable['LastMonthColdFrameMinMaxByStation']=$query;

unset($query);
$query['bind']="s";
$query['query']=$minmaxdailycoldframequery." WHERE ((DATE(d.StationLocalDate) > DATE(NOW() - INTERVAL 7 DAY)) AND (d.StationID=?)) GROUP BY d.StationLocalDate ORDER BY d.StationLocalDate ASC";
$querytable['Last7DaysColdFrameMinMaxByStation']=$query;

// daily weather for the last year by month
$minmaxweeklytemperaturequery="SELECT d.DailyWeatherID, Min(d.TemperatureMin) as MinV, Max(d.TemperatureMax) as MaxV,
                                d.StationLocalDate, '00:00:00'
                          From DailyWeather d";
unset($query);
$query['bind']="s";
$query['query']=$minmaxweeklytemperaturequery." WHERE ((DATE(d.StationLocalDate) > DATE(NOW() - INTERVAL 1 YEAR)) AND (d.StationID=?)) GROUP BY MONTH(DATE(d.StationLocalDate)) ORDER BY d.StationLocalDate ASC";
$querytable['LastYearTemperatureMinMaxByStation']=$query;

// daily coldframe temperature for the last year by month
$minmaxweeklycoldframequery="SELECT d.DailyWeatherID, Min(d.ColdFrameTemperatureMin) as MinV, Max(d.ColdFrameTemperatureMax) as MaxV,
                                d.StationLocalDate, '00:00:00'
                          From DailyWeather d";
unset($query);
$query['bind']="s";
$query['query']=$minmaxweeklycoldframequery." WHERE ((DATE(d.StationLocalDate) > DATE(NOW() - INTERVAL 1 YEAR)) AND (d.StationID=?)) GROUP BY MONTH(DATE(d.StationLocalDate)) ORDER BY d.StationLocalDate ASC";
$querytable['LastYearColdFrameMinMaxByStation']=$query;

// Historical Pressure Min/Max
$minmaxpressurequery="SELECT h.HistoricalWeatherID,
                                Min(h.Pressure) as MinV, Max(h.Pressure) as MaxV,
                                h.StationLocalDate, h.StationLocalTime
                          From HistoricalWeather h";

unset($query);
$query['bind']="s";
$query['query']=$minmaxpressurequery." WHERE ((DATE(h.StationLocalDate) = DATE(NOW())) AND (h.StationID=?)) GROUP BY HOUR(h.StationLocalTime) ORDER BY h.StationLocalDate ASC, h.StationLocalTime ASC";
$querytable['TodaysPressureMinMaxByHourByStation']=$query;

unset($query);
$query['bind']="s";
$query['query']=$minmaxpressurequery." WHERE ((DATE(h.StationLocalDate) = DATE(NOW() - INTERVAL 1 DAY)) AND (h.StationID=?)) GROUP BY HOUR(h.StationLocalTime) ORDER BY h.StationLocalDate ASC, h.StationLocalTime ASC";
$querytable['YesterdaysPressureMinMaxByHourByStation']=$query;

// daily pressure for the last month by day
$minmaxdailypressurequery="SELECT d.DailyWeatherID, Min(d.PressureMin) as MinV, Max(d.PressureMax) as MaxV,
                                d.StationLocalDate, '00:00:00'
                          From DailyWeather d";
unset($query);
$query['bind']="s";
$query['query']=$minmaxdailypressurequery." WHERE ((DATE(d.StationLocalDate) > DATE(NOW() - INTERVAL 1 MONTH)) AND (d.StationID=?)) GROUP BY d.StationLocalDate ORDER BY d.StationLocalDate ASC";
$querytable['LastMonthPressureMinMaxByStation']=$query;

unset($query);
$query['bind']="s";
$query['query']=$minmaxdailypressurequery." WHERE ((DATE(d.StationLocalDate) > DATE(NOW() - INTERVAL 7 DAY)) AND (d.StationID=?)) GROUP BY d.StationLocalDate ORDER BY d.StationLocalDate ASC";
$querytable['Last7DaysPressureMinMaxByStation']=$query;


// Historical ColdFrame Min/Max
$minmaxcoldframequery="SELECT h.HistoricalWeatherID,
                                Min(h.ColdFrameTemperature) as MinV, Max(h.ColdFrameTemperature) as MaxV,
                                h.StationLocalDate, h.StationLocalTime
                          From HistoricalWeather h";

unset($query);
$query['bind']="s";
$query['query']=$minmaxcoldframequery." WHERE ((h.ColdFrameProbe!='NotSet') AND (DATE(h.StationLocalDate) = DATE(NOW())) AND (h.StationID=?)) GROUP BY HOUR(h.StationLocalTime) ORDER BY h.StationLocalDate ASC, h.StationLocalTime ASC";
$querytable['TodaysColdFrameMinMaxByHourByStation']=$query;

unset($query);
$query['bind']="s";
$query['query']=$minmaxcoldframequery." WHERE ((h.ColdFrameProbe!='NotSet') AND (DATE(h.StationLocalDate) = DATE(NOW() - INTERVAL 1 DAY)) AND (h.StationID=?)) GROUP BY HOUR(h.StationLocalTime) ORDER BY h.StationLocalDate ASC, h.StationLocalTime ASC";
$querytable['YesterdaysColdFrameMinMaxByHourByStation']=$query;

// Historical ColdFrame Min/Max In 30 Minute Intervals -->> change 1800 to 900 for 15 minute intervals
$minmax15coldframequery="SELECT h.HistoricalWeatherID,
                                Min(h.ColdFrameTemperature) as MinV, Max(h.ColdFrameTemperature) as MaxV,
                                h.StationLocalDate,
                                date_format(date_add(h.StationLocalDate, interval timestampdiff(second, h.StationLocalDate, addtime(h.StationLocalDate, h.StationLocalTime)) div 1800 * 1800 second),\"%H:%i:%s\") AS StationLocalTime
                          From HistoricalWeather h";

unset($query);
$query['bind']="s";
$query['query']=$minmax15coldframequery." WHERE ((h.ColdFrameProbe!='NotSet') AND (DATE(h.StationLocalDate) = DATE(NOW())) AND (h.StationID=?))
GROUP BY h.StationLocalDate,
timestampdiff(second, h.StationLocalDate, addtime(h.StationLocalDate, h.StationLocalTime)) div 1800
ORDER BY h.StationLocalDate ASC, h.StationLocalTime ASC";
$querytable['TodaysColdFrameMinMaxBy15ByStation']=$query;

unset($query);
$query['bind']="s";
$query['query']=$minmax15coldframequery." WHERE ((h.ColdFrameProbe!='NotSet') AND (DATE(h.StationLocalDate) = DATE(NOW() - INTERVAL 1 DAY)) AND (h.StationID=?)) GROUP BY h.StationLocalDate,
timestampdiff(second, h.StationLocalDate, addtime(h.StationLocalDate, h.StationLocalTime)) div 1800
ORDER BY h.StationLocalDate ASC, h.StationLocalTime ASC";
$querytable['YesterdaysColdFrameMinMaxBy15ByStation']=$query;

// Historical Relative Humidity Min/Max
$minmaxhumidityquery="SELECT h.HistoricalWeatherID,
                                Min(h.RelativeHumidity) as MinV, Max(h.RelativeHumidity) as MaxV,
                                h.StationLocalDate, h.StationLocalTime
                          From HistoricalWeather h";

unset($query);
$query['bind']="s";
$query['query']=$minmaxhumidityquery." WHERE ((DATE(h.StationLocalDate) = DATE(NOW())) AND (h.StationID=?)) GROUP BY HOUR(h.StationLocalTime) ORDER BY h.StationLocalDate ASC, h.StationLocalTime ASC";
$querytable['TodaysHumidityMinMaxByHourByStation']=$query;

unset($query);
$query['bind']="s";
$query['query']=$minmaxhumidityquery." WHERE ((DATE(h.StationLocalDate) = DATE(NOW() - INTERVAL 1 DAY)) AND (h.StationID=?)) GROUP BY HOUR(h.StationLocalTime) ORDER BY h.StationLocalDate ASC, h.StationLocalTime ASC";
$querytable['YesterdaysHumidityMinMaxByHourByStation']=$query;

// Control
$controlquery="SELECT c.ControlID,c.ActionID,
                      c.ParameterType,c.ParameterInt,c.ParameterChar,
                      c.StationID,c.Updated
                    FROM Control c";

unset($query);
$query['bind']="s";
$query['query']=$controlquery." WHERE c.ControlID=?";
$querytable['ControlByID']=$query;

unset($query);
$query['bind']="s";
$query['query']=$controlquery." WHERE c.StationID=?";
$querytable['ControlByStationID']=$query;

unset($query);
$query['bind']="ss";
$query['query']=$controlquery." WHERE c.ControlID=? AND c.StationID=?";
$querytable['ControlByIDAndStationID']=$query;

// Actions
$actionsquery="SELECT a.ActionID,a.Action,
                      a.ControlID,a.ParameterType,
                      a.ParameterInt,a.ParameterChar,
                      a.Updated
                    FROM Actions a";

unset($query);
$query['bind']="";
$query['query']=$actionsquery." WHERE 1";
$querytable['AllActions']=$query;

unset($query);
$query['bind']="i";
$query['query']=$actionsquery." WHERE a.ActionID=?";
$querytable['ActionByID']=$query;

unset($query);
$query['bind']="s";
$query['query']=$controlquery." WHERE a.ControlID=?";
$querytable['ActionByControlID']=$query;

// Settings
$actionsquery="SELECT s.StationID, s.Status,
                      s.DisplayDim, s.DisplayOn, s.ColdFrameOn, s.WUUpload,
                      s.Updated
                    FROM Settings s";

unset($query);
$query['bind']="";
$query['query']=$actionsquery." WHERE 1";
$querytable['AllSettings']=$query;

unset($query);
$query['bind']="s";
$query['query']=$actionsquery." WHERE s.StationID=?";
$querytable['SettingsByID']=$query;

unset($query);
$query['bind']="ss";
$query['query']=$actionsquery." WHERE s.StationID=? AND s.Status=?";
$querytable['SettingsByIDStatus']=$query;

$updatetable=Array();
// hourly insert & update
unset($query);
$query='INSERT INTO HourlyWeather (HourlyWeatherID, StationID, StationUTCDate, StationUTCTime, StationLocalDate, StationLocalTime, TemperatureMin, TemperatureMax, ColdFrameTemperatureMin, ColdFrameTemperatureMax, PressureMin, PressureMax, RelativeHumidityMin, RelativeHumidityMax, Probe, ColdFrameProbe)
  SELECT HistoricalWeatherID, StationID,
    StationUTCDate, Concat(hour(StationUTCTime),":00:00"),
    StationLocalDate, Concat(hour(StationLocalTime),":00:00"),
    MIN(Temperature), MAX(Temperature),
    MIN(ColdFrameTemperature), MAX(ColdFrameTemperature),
    MIN(Pressure), MAX(Pressure),
    MIN(RelativeHumidity), MAX(RelativeHumidity),
    Probe, ColdFrameProbe
  FROM HistoricalWeather
    WHERE (((DATE(StationLocalDate)) < DATE(NOW())) AND (Hourly=0))
    GROUP BY StationLocalDate, hour(StationLocalTime)';

$updatetable['InsertHourly']=$query;

unset($query);
$query='UPDATE HistoricalWeather SET Hourly=1
  WHERE ((DATE(StationLocalDate)) < DATE(NOW()) AND (Hourly=0))';

$updatetable['UpdateHourly']=$query;

// daily insert & update
unset($query);
$query='INSERT INTO DailyWeather (DailyWeatherID, StationID, StationUTCDate, StationLocalDate, TemperatureMin, TemperatureMax, ColdFrameTemperatureMin, ColdFrameTemperatureMax, PressureMin, PressureMax, RelativeHumidityMin, RelativeHumidityMax, Probe, ColdFrameProbe)
  SELECT HistoricalWeatherID, StationID,
    StationUTCDate,
    StationLocalDate,
    MIN(Temperature), MAX(Temperature),
    MIN(ColdFrameTemperature), MAX(ColdFrameTemperature),
    MIN(Pressure), MAX(Pressure),
    MIN(RelativeHumidity), MAX(RelativeHumidity),
    Probe, ColdFrameProbe
  FROM HistoricalWeather
    WHERE (((DATE(StationLocalDate)) < DATE(NOW())) AND (Daily=0))
    GROUP BY StationLocalDate';
$updatetable['InsertDaily']=$query;

unset($query);
$query='UPDATE HistoricalWeather SET Daily=1
  WHERE ((DATE(StationLocalDate)) < DATE(NOW()) AND (Daily=0))';

$updatetable['UpdateDaily']=$query;

// monthly insert & update
unset($query);
$query='INSERT INTO MonthlyWeather (MonthlyWeatherID, StationID, StationUTCDate, StationLocalDate, TemperatureMin, TemperatureMax, TemperatureAvg, ColdFrameTemperatureMin, ColdFrameTemperatureMax, ColdFrameTemperatureAvg, PressureMin, PressureMax, RelativeHumidityMin, RelativeHumidityMax, RelativeHumidityAvg)
  SELECT HistoricalWeatherID, StationID,
    CONCAT(YEAR(DATE(StationUTCDate)),"-",MONTH(DATE(StationUTCDate)),"-01"),
    CONCAT(YEAR(DATE(StationLocalDate)),"-",MONTH(DATE(StationLocalDate)),"-01"),
    MIN(Temperature), MAX(Temperature), AVG(Temperature),
    MIN(ColdFrameTemperature), MAX(ColdFrameTemperature), AVG(ColdFrameTemperature),
    MIN(Pressure), MAX(Pressure),
    MIN(RelativeHumidity), MAX(RelativeHumidity), AVG(RelativeHumidity)
  FROM HistoricalWeather
    WHERE (((MONTH(DATE(StationLocalDate))) < MONTH(DATE(NOW()))) AND (Monthly=0))
    GROUP BY YEAR(DATE(StationLocalDate)),  MONTH(DATE(StationLocalDate))';
$updatetable['InsertMonthly']=$query;

unset($query);
$query='UPDATE HistoricalWeather SET Monthly=1
  WHERE (((MONTH(DATE(StationLocalDate))) < MONTH(DATE(NOW()))) AND (Monthly=0))';

$updatetable['UpdateMonthly']=$query;

// historical weather delete
unset($query);
$query='DELETE FROM HistoricalWeather
  WHERE ((Hourly=1) AND (Daily=1) AND (Monthly=1) AND ((DATE(StationLocalDate) + INTERVAL 3 MONTH) < DATE(NOW())))';

$updatetable['RemoveHourlyDaily']=$query;

?>
