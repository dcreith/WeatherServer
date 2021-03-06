WeatherServer
=============

WeatherServer is a set of web services and pages to support WeatherPi and
WeatherConsole.

See the WeatherPi & WeatherConsole repositories for complementary applications
that capture and display the data.

WeatherServer consists of several web services (assets/ajax) supporting updates
from the WeatherPi application and providing data to the WeatherConsole application.

A single web page provides browser access to basic weather data.

**Today's Weather:**
![Weather](images/WeatherServer_1.png?raw=true "Today's Weather")

**30 Days:**
![Weather](images/WeatherServer_2.png?raw=true "30 Days")

**12 Months:**
![Weather](images/WeatherServer_3.png?raw=true "12 Months")

**30 Days Barometric Pressure:**
![Weather](images/WeatherServer_4.png?raw=true "30 Days Barometric Pressure")



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
