-- phpMyAdmin SQL Dump
-- version 4.6.6deb4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 09, 2018 at 12:33 PM
-- Server version: 10.1.23-MariaDB-9+deb9u1
-- PHP Version: 7.0.27-0+deb9u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `weather`
--

-- --------------------------------------------------------

--
-- Table structure for table `Actions`
--

CREATE TABLE `Actions` (
  `ActionID` int(7) NOT NULL,
  `Action` varchar(50) NOT NULL,
  `ControlID` varchar(50) DEFAULT 'Unknown',
  `ParameterType` char(1) DEFAULT NULL,
  `ParameterInt` int(7) DEFAULT NULL,
  `ParameterChar` varchar(15) DEFAULT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Audit`
--

CREATE TABLE `Audit` (
  `AuditID` int(11) NOT NULL,
  `Added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Data` mediumblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `Control`
--

CREATE TABLE `Control` (
  `ControlID` varchar(50) DEFAULT 'Unknown',
  `ActionID` int(7) DEFAULT NULL,
  `ParameterType` char(1) DEFAULT NULL,
  `ParameterInt` int(7) DEFAULT NULL,
  `ParameterChar` varchar(15) DEFAULT NULL,
  `StationID` varchar(64) NOT NULL DEFAULT '6100245999979349',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `DailyWeather`
--

CREATE TABLE `DailyWeather` (
  `DailyWeatherID` int(11) NOT NULL,
  `StationID` varchar(64) NOT NULL,
  `StationUTCDate` date NOT NULL,
  `StationLocalDate` date NOT NULL,
  `TemperatureMin` decimal(4,1) DEFAULT NULL,
  `TemperatureMax` decimal(4,1) DEFAULT NULL,
  `ColdFrameTemperatureMin` decimal(4,1) DEFAULT NULL,
  `ColdFrameTemperatureMax` decimal(4,1) DEFAULT NULL,
  `PressureMin` decimal(6,2) DEFAULT NULL,
  `PressureMax` decimal(6,2) DEFAULT NULL,
  `RelativeHumidityMin` decimal(4,1) DEFAULT NULL,
  `RelativeHumidityMax` decimal(4,1) DEFAULT NULL,
  `Probe` varchar(20) DEFAULT NULL,
  `ColdFrameProbe` varchar(20) DEFAULT NULL,
  `Added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `HistoricalWeather`
--

CREATE TABLE `HistoricalWeather` (
  `HistoricalWeatherID` int(11) NOT NULL,
  `Temperature` decimal(4,1) DEFAULT NULL,
  `ColdFrameTemperature` decimal(4,1) DEFAULT NULL,
  `Pressure` decimal(6,2) DEFAULT NULL,
  `RelativeHumidity` decimal(4,1) DEFAULT NULL,
  `DewPoint` decimal(4,1) DEFAULT NULL,
  `WindSpeed` int(3) DEFAULT NULL,
  `WindDirectionDegrees` int(3) DEFAULT NULL,
  `WindDirectionEmpirical` varchar(50) NOT NULL,
  `Luminousity` int(5) DEFAULT NULL,
  `UVIndex` decimal(3,1) DEFAULT NULL,
  `DayPeriod` varchar(25) NOT NULL,
  `Probe` varchar(20) NOT NULL,
  `ColdFrameProbe` varchar(20) NOT NULL,
  `StationID` varchar(64) NOT NULL,
  `StationLocalDate` date NOT NULL,
  `StationLocalTime` time NOT NULL,
  `StationTimeZone` varchar(25) NOT NULL DEFAULT 'Unknown',
  `StationUTCDate` date NOT NULL DEFAULT '0000-00-00',
  `StationUTCTime` time NOT NULL DEFAULT '00:00:00',
  `Added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Hourly` tinyint(1) NOT NULL DEFAULT '0',
  `Daily` tinyint(1) NOT NULL DEFAULT '0',
  `Monthly` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `HourlyWeather`
--

CREATE TABLE `HourlyWeather` (
  `HourlyWeatherID` int(11) NOT NULL,
  `StationID` varchar(64) NOT NULL,
  `StationUTCDate` date NOT NULL,
  `StationUTCTime` time NOT NULL,
  `StationLocalDate` date NOT NULL,
  `StationLocalTime` text NOT NULL,
  `TemperatureMin` decimal(4,1) DEFAULT NULL,
  `TemperatureMax` decimal(4,1) DEFAULT NULL,
  `ColdFrameTemperatureMin` decimal(4,1) DEFAULT NULL,
  `ColdFrameTemperatureMax` decimal(4,1) DEFAULT NULL,
  `PressureMin` decimal(6,2) DEFAULT NULL,
  `PressureMax` decimal(6,2) DEFAULT NULL,
  `RelativeHumidityMin` decimal(4,1) DEFAULT NULL,
  `RelativeHumidityMax` decimal(4,1) DEFAULT NULL,
  `Probe` varchar(20) DEFAULT NULL,
  `ColdFrameProbe` varchar(20) DEFAULT NULL,
  `Added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `MonthlyWeather`
--

CREATE TABLE `MonthlyWeather` (
  `MonthlyWeatherID` int(11) NOT NULL,
  `StationID` varchar(64) NOT NULL,
  `StationUTCDate` date NOT NULL,
  `StationLocalDate` date NOT NULL,
  `TemperatureMin` decimal(4,1) DEFAULT NULL,
  `TemperatureMax` decimal(4,1) DEFAULT NULL,
  `TemperatureAvg` decimal(4,1) DEFAULT NULL,
  `ColdFrameTemperatureMin` decimal(4,1) DEFAULT NULL,
  `ColdFrameTemperatureMax` decimal(4,1) DEFAULT NULL,
  `ColdFrameTemperatureAvg` decimal(4,1) DEFAULT NULL,
  `PressureMin` decimal(6,2) DEFAULT NULL,
  `PressureMax` decimal(6,2) DEFAULT NULL,
  `RelativeHumidityMin` decimal(4,1) DEFAULT NULL,
  `RelativeHumidityMax` decimal(4,1) DEFAULT NULL,
  `RelativeHumidityAvg` decimal(4,1) DEFAULT NULL,
  `Added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Settings`
--

CREATE TABLE `Settings` (
  `StationID` varchar(64) DEFAULT NULL,
  `Status` varchar(15) NOT NULL DEFAULT 'None',
  `DisplayDim` tinyint(1) NOT NULL DEFAULT '0',
  `DisplayOn` tinyint(1) NOT NULL DEFAULT '0',
  `ColdFrameOn` tinyint(1) NOT NULL DEFAULT '0',
  `WUUpload` int(2) NOT NULL DEFAULT '0',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Actions`
--
ALTER TABLE `Actions`
  ADD UNIQUE KEY `Action_NDX` (`ActionID`);

--
-- Indexes for table `DailyWeather`
--
ALTER TABLE `DailyWeather`
  ADD UNIQUE KEY `DailyWeather_UXD` (`StationLocalDate`);

--
-- Indexes for table `HistoricalWeather`
--
ALTER TABLE `HistoricalWeather`
  ADD UNIQUE KEY `HW_NDX` (`HistoricalWeatherID`);

--
-- Indexes for table `HourlyWeather`
--
ALTER TABLE `HourlyWeather`
  ADD UNIQUE KEY `HourlyWeather_UXD` (`HourlyWeatherID`);

--
-- Indexes for table `MonthlyWeather`
--
ALTER TABLE `MonthlyWeather`
  ADD UNIQUE KEY `MonthlyWeather_UXD` (`StationLocalDate`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Actions`
--
ALTER TABLE `Actions`
  MODIFY `ActionID` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `HistoricalWeather`
--
ALTER TABLE `HistoricalWeather`
  MODIFY `HistoricalWeatherID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96688;
