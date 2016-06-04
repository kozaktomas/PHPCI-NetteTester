# Nette tester plugin for PHPCI

## Installation
1) Go to root of PHPCI project and open **composer.json**. In require section add:
```sh
"kozaktomas/phpcinettetester": "dev-master"
```
2) Run composer update
```sh
composer update
```
3) Plugin is ready to use in application


## Configuration

```sh
test:
    \Kozaktomas\PHPCI\Plugin\NetteTester:
        params: ""
```
In params argument you can add any parameters for run tests. php vendor/bin/tester %params% tests/