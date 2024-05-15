# 作業ログ


## まずは環境構築
ChatGPTの指示通りにやってみる

```bash
% brew install php
```

```bash
% php -v 
PHP 8.3.7 (cli) (built: May  7 2024 16:35:26) (NTS)
Copyright (c) The PHP Group
Zend Engine v4.3.7, Copyright (c) Zend Technologies
    with Zend OPcache v8.3.7, Copyright (c), by Zend Technologies
```

```bash
% brew install composer
```

```bash
% composer -v       
   ______
  / ____/___  ____ ___  ____  ____  ________  _____
 / /   / __ \/ __ `__ \/ __ \/ __ \/ ___/ _ \/ ___/
/ /___/ /_/ / / / / / / /_/ / /_/ (__  )  __/ /
\____/\____/_/ /_/ /_/ .___/\____/____/\___/_/
                    /_/
Composer version 2.7.6 2024-05-04 23:03:15

Usage:
  command [options] [arguments]

Options:
  -h, --help                     Display help for the given command. When no command is given display help for the list command
  -q, --quiet                    Do not output any message
  -V, --version                  Display this application version
      --ansi|--no-ansi           Force (or disable --no-ansi) ANSI output
  -n, --no-interaction           Do not ask any interactive question
      --profile                  Display timing and memory usage information
      --no-plugins               Whether to disable plugins.
      --no-scripts               Skips the execution of all scripts defined in composer.json file.
  -d, --working-dir=WORKING-DIR  If specified, use the given directory as working directory.
      --no-cache                 Prevent use of the cache
  -v|vv|vvv, --verbose           Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug

Available commands:
  about                Shows a short information about Composer
  archive              Creates an archive of this composer package
  audit                Checks for security vulnerability advisories for installed packages
  browse               [home] Opens the package's repository URL or homepage in your browser
  bump                 Increases the lower limit of your composer.json requirements to the currently installed versions
  check                Runs the check script as defined in composer.json
  check-platform-reqs  Check that platform requirements are satisfied
  clear-cache          [clearcache|cc] Clears composer's internal package cache
  completion           Dump the shell completion script
  config               Sets config options
  create-project       Creates new project from a package into given directory
  cs-check             Runs the cs-check script as defined in composer.json
  cs-fix               Runs the cs-fix script as defined in composer.json
  depends              [why] Shows which packages cause the given package to be installed
  diagnose             Diagnoses the system to identify common errors
  dump-autoload        [dumpautoload] Dumps the autoloader
  exec                 Executes a vendored binary/script
  fund                 Discover how to help fund the maintenance of your dependencies
  global               Allows running commands in the global composer dir ($COMPOSER_HOME)
  help                 Display help for a command
  init                 Creates a basic composer.json file in current directory
  install              [i] Installs the project dependencies from the composer.lock file if present, or falls back on the composer.json
  licenses             Shows information about licenses of dependencies
  list                 List commands
  outdated             Shows a list of installed packages that have updates available, including their latest version
  prohibits            [why-not] Shows which packages prevent the given package from being installed
  reinstall            Uninstalls and reinstalls the given package names
  remove               [rm|uninstall] Removes a package from the require or require-dev
  require              [r] Adds required packages to your composer.json and installs them
  run-script           [run] Runs the scripts defined in composer.json
  search               Searches for packages
  self-update          [selfupdate] Updates composer.phar to the latest version
  show                 [info] Shows information about packages
  stan                 Runs the stan script as defined in composer.json
  status               Shows a list of locally modified packages
  suggests             Shows package suggestions
  test                 Runs the test script as defined in composer.json
  update               [u|upgrade] Updates your dependencies to the latest version according to composer.json, and updates the composer.lock file
  validate             Validates a composer.json and composer.lock
```

## CakePHPプロジェクトの作成

```bash
% composer create-project --prefer-dist cakephp/app pracitice-php-app
```

生成された

```bash
% tree -L 2         
.
├── README.md
├── bin
│   ├── bash_completion.sh
│   ├── cake
│   ├── cake.bat
│   └── cake.php
├── composer.json
├── composer.lock
├── config
│   ├── app.php
│   ├── app_local.example.php
│   ├── app_local.php
│   ├── bootstrap.php
│   ├── bootstrap_cli.php
│   ├── paths.php
│   ├── plugins.php
│   ├── routes.php
│   └── schema
├── index.php
├── logs
├── memo
│   └── 01_initial.md
├── phpcs.xml
├── phpstan.neon
├── phpunit.xml.dist
├── plugins
├── psalm.xml
├── resources
├── src
│   ├── Application.php
│   ├── Console
│   ├── Controller
│   ├── Model
│   └── View
├── templates
│   ├── Error
│   ├── Pages
│   ├── cell
│   ├── element
│   ├── email
│   └── layout
├── tests
│   ├── Fixture
│   ├── TestCase
│   ├── bootstrap.php
│   └── schema.sql
├── tmp
│   ├── cache
│   ├── debug_kit.sqlite
│   ├── sessions
│   └── tests
├── vendor
│   ├── autoload.php
│   ├── bin
│   ├── brick
│   ├── cakephp
│   ├── cakephp-plugins.php
│   ├── composer
│   ├── dealerdirect
│   ├── doctrine
│   ├── jasny
│   ├── josegonzalez
│   ├── justinrainbow
│   ├── laminas
│   ├── league
│   ├── m1
│   ├── mobiledetect
│   ├── myclabs
│   ├── nikic
│   ├── phar-io
│   ├── phpstan
│   ├── phpunit
│   ├── psr
│   ├── react
│   ├── robmorgan
│   ├── sebastian
│   ├── seld
│   ├── slevomat
│   ├── squizlabs
│   ├── symfony
│   ├── theseer
│   └── twig
└── webroot
    ├── css
    ├── favicon.ico
    ├── font
    ├── img
    ├── index.php
    └── js

61 directories, 29 files
```

## ローカルサーバーを起動

```bash 
% cd practice-php-app
% bin/cake server

Welcome to CakePHP v5.0.8 Console
-------------------------------------------------------------------------------
App : src
Path: /Users/subfukunaga/dev/practice-php-app/src/
DocumentRoot: /Users/subfukunaga/dev/practice-php-app/webroot
Ini Path: 
-------------------------------------------------------------------------------
built-in server is running in http://localhost:8765/
You can exit with `CTRL-C`
[Wed May 15 20:57:46 2024] PHP 8.3.7 Development Server (http://localhost:8765) started
[Wed May 15 20:57:55 2024] 127.0.0.1:52968 Accepted
[Wed May 15 20:57:55 2024] 127.0.0.1:52969 Accepted
[Wed May 15 20:57:55 2024] 127.0.0.1:52968 Closing
[Wed May 15 20:57:55 2024] 127.0.0.1:52971 Accepted
[Wed May 15 20:57:55 2024] 127.0.0.1:52969 [200]: GET /css/normalize.min.css
[Wed May 15 20:57:55 2024] 127.0.0.1:52974 Accepted
[Wed May 15 20:57:55 2024] 127.0.0.1:52971 [200]: GET /css/milligram.min.css
[Wed May 15 20:57:55 2024] 127.0.0.1:52976 Accepted
[Wed May 15 20:57:55 2024] 127.0.0.1:52974 [200]: GET /css/fonts.css
[Wed May 15 20:57:55 2024] 127.0.0.1:52977 Accepted
[Wed May 15 20:57:55 2024] 127.0.0.1:52969 Closing
[Wed May 15 20:57:55 2024] 127.0.0.1:52976 [200]: GET /css/cake.css
[Wed May 15 20:57:55 2024] 127.0.0.1:52979 Accepted
[Wed May 15 20:57:55 2024] 127.0.0.1:52971 Closing
[Wed May 15 20:57:55 2024] 127.0.0.1:52977 [200]: GET /css/home.css
[Wed May 15 20:57:55 2024] 127.0.0.1:52979 Closing
[Wed May 15 20:57:55 2024] 127.0.0.1:52974 Closing
[Wed May 15 20:57:55 2024] 127.0.0.1:52976 Closing
[Wed May 15 20:57:55 2024] 127.0.0.1:52977 Closing
[Wed May 15 20:57:55 2024] 127.0.0.1:52983 Accepted
[Wed May 15 20:57:55 2024] 127.0.0.1:52984 Accepted
[Wed May 15 20:57:55 2024] 127.0.0.1:52983 [200]: GET /font/raleway-700-latin.woff2
[Wed May 15 20:57:55 2024] 127.0.0.1:52985 Accepted
[Wed May 15 20:57:55 2024] 127.0.0.1:52984 [200]: GET /font/raleway-400-latin.woff2
[Wed May 15 20:57:55 2024] 127.0.0.1:52985 [200]: GET /font/cakedingbats-webfont.woff2
[Wed May 15 20:57:55 2024] 127.0.0.1:52983 Closing
[Wed May 15 20:57:55 2024] 127.0.0.1:52984 Closing
[Wed May 15 20:57:55 2024] 127.0.0.1:52985 Closing
[Wed May 15 20:57:55 2024] 127.0.0.1:52987 Accepted
[Wed May 15 20:57:55 2024] 127.0.0.1:52987 Closing
[Wed May 15 20:57:55 2024] 127.0.0.1:52990 Accepted
[Wed May 15 20:57:55 2024] 127.0.0.1:52992 Accepted
[Wed May 15 20:57:55 2024] 127.0.0.1:52993 Accepted
[Wed May 15 20:57:55 2024] 127.0.0.1:52996 Accepted
[Wed May 15 20:57:55 2024] 127.0.0.1:52990 Closing
[Wed May 15 20:57:55 2024] 127.0.0.1:52997 Accepted
[Wed May 15 20:57:55 2024] 127.0.0.1:52992 Closing
[Wed May 15 20:57:55 2024] 127.0.0.1:52993 Closing
[Wed May 15 20:57:55 2024] 127.0.0.1:52996 Closing
[Wed May 15 20:57:55 2024] 127.0.0.1:52997 Closing
[Wed May 15 20:57:55 2024] 127.0.0.1:53001 Accepted
[Wed May 15 20:57:55 2024] 127.0.0.1:53002 Accepted
[Wed May 15 20:57:55 2024] 127.0.0.1:53004 Accepted
[Wed May 15 20:57:55 2024] 127.0.0.1:53007 Accepted
[Wed May 15 20:57:55 2024] 127.0.0.1:53001 Closing
[Wed May 15 20:57:55 2024] 127.0.0.1:53008 Accepted
[Wed May 15 20:57:55 2024] 127.0.0.1:53002 Closing
[Wed May 15 20:57:55 2024] 127.0.0.1:53004 Closing
[Wed May 15 20:57:55 2024] 127.0.0.1:53007 Closing
[Wed May 15 20:57:55 2024] 127.0.0.1:53009 Accepted
[Wed May 15 20:57:55 2024] 127.0.0.1:53008 Closing
[Wed May 15 20:57:55 2024] 127.0.0.1:53011 Accepted
[Wed May 15 20:57:55 2024] 127.0.0.1:53009 Closing
[Wed May 15 20:57:55 2024] 127.0.0.1:53013 Accepted
[Wed May 15 20:57:55 2024] 127.0.0.1:53011 Closing
[Wed May 15 20:57:55 2024] 127.0.0.1:53015 Accepted
[Wed May 15 20:57:55 2024] 127.0.0.1:53013 Closing
[Wed May 15 20:57:55 2024] 127.0.0.1:53017 Accepted
[Wed May 15 20:57:55 2024] 127.0.0.1:53015 Closing
[Wed May 15 20:57:55 2024] 127.0.0.1:53017 Closing
[Wed May 15 20:57:55 2024] 127.0.0.1:53019 Accepted
[Wed May 15 20:57:55 2024] 127.0.0.1:53019 [200]: GET /favicon.ico
[Wed May 15 20:57:55 2024] 127.0.0.1:53019 Closing
``` 