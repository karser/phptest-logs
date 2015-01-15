## How to run
Please run this script with php
```bash
php -S localhost:8000 ./web/index.php
```
Or setup your web server ./web/index.php as document root

You can use ./testlog for testing purpose.

## How it looks
![upload](https://raw.githubusercontent.com/karser/phptest-logs/master/1.png?raw=true)
![statistics](https://raw.githubusercontent.com/karser/phptest-logs/master/2.png?raw=true)


## Task description
For this exercise, we want to print a report about the usage of an Apache web server, based on the access logs.
To do that we'll build a simple page including a form that will allow us to upload a log file.
When the file is uploaded, the script will analyze its contents and print the following:
- number of hits / day (for each day)
- number of unique visitors / day (for each day)
- average number of hits / visitor (for the whole period)

Log format:
```
192.168.1.1 - - [16/Feb/2014:06:44:00 +0000] "GET /images/icon.png HTTP/1.1" 200 1331 "http://www.example.com/index.html" "Mozilla/5.0 (iPad; CPU OS 7_0_4 like Mac OS X) AppleWebKit/537.51.1 (KHTML, like Gecko) Version/7.0 Mobile/11B554a Safari/9537.53"
```

Do not use any Javascript or CSS, we just want a PHP/HTML page (in core PHP, no framework).
