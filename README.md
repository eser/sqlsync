# SqlSync

**SqlSync** is planned to be an open source database syncronous tool. However it is in early stages of development, and supports database dump transfer only for now.

[![Build Status](https://travis-ci.org/eserozvataf/sqlsync.png?branch=master)](https://travis-ci.org/eserozvataf/sqlsync)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/eserozvataf/sqlsync/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/eserozvataf/sqlsync/?branch=master)
[![Total Downloads](https://poser.pugx.org/eserozvataf/sqlsync/downloads.png)](https://packagist.org/packages/eserozvataf/sqlsync)
[![Latest Stable Version](https://poser.pugx.org/eserozvataf/sqlsync/v/stable)](https://packagist.org/packages/eserozvataf/sqlsync)
[![Latest Unstable Version](https://poser.pugx.org/eserozvataf/sqlsync/v/unstable)](https://packagist.org/packages/eserozvataf/sqlsync)


## Installation
Please make sure that you can access php command line tool via `php` command. Further commands will be executed on Terminal or Command Prompt:

**Step 1:**
Download and install composer dependency manager.

``` bash
php -r "readfile('https://getcomposer.org/installer');" | php
```

**Step 2:**
Create a new sqlsync project via composer.

``` bash
php composer.phar create-project eserozvataf/sqlsync:dev-master
```

**Step 3:**
Rename `config.sample.php` to `config.php` and edit configuration.

## Running

**Transfer Command:**
Transfer command simply creates or overwrites a new database/schema on client, by reading the source database from the server. The workflow of this procedure is
preparing a sql dump file on server side, downloading it to client, execution of the dump on the client. 

``` bash
vendor/bin/scabbia sqlSync:transfer my_database
```

Replace `my_database` with your database name which will be copied to your client.


## Requirements
* PHP 5.6.0+ (http://www.php.net/)
* Composer Dependency Manager (http://getcomposer.org/)


## Links
- [License Information](LICENSE)


## Contributing
It is publicly open for any contribution. Bugfixes, new features and extra modules are welcome. All contributions should be filed on the [eserozvataf/sqlsync](https://github.com/eserozvataf/sqlsync) repository.

* To contribute to code: Fork the repo, push your changes to your fork, and submit a pull request.
* To report a bug: If something does not work, please report it using GitHub issues.
* To support: [![Donate](https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif)](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=BXNMWG56V6LYS)
