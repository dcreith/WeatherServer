WeatherServer
=============

WeatherServer is a set of web services and pages to support WeatherPi and
WeatherConsole.

See the WeatherPi & WeatherConsole repositories for complementary applications
that capture and display the data.

WeatherServer consists of several web services (assets/ajax) supporting updates
from the WeatherPi application and providing data to the WeatherConsole application.

A single web page provides browser access to basic weather data.

![Weather](/WeatherServer_1.png)

**Prerequisites:**

Apache server

mySQL (mariaDB)

PHP 7.x

phpMyAdmin (optional)

**Setup**

'Create Database `weather`;'

Run DefineTables.sql

Set appropriate server, DB, user & password in assets/inc/iConnect.php

**Get repo:**

    git clone https://github.com/dcreith/WeatherServer.git
