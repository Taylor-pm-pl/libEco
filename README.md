# LibEconomy
**LibEconomy is a PocketMine-MP virion that makes easy to use API of economy plugins!**

## Installation
You can get the compiled .phar file on poggit by clicking [here](https://poggit.pmmp.io/ci/Eric-pm-pl/LibEconomy/~).

## Supports
Currently this library only supports BedrockEconomy and EconomyAPI

## Usage
LibEconomy makes using the economy plugins API easier!.

## Get the money of a player

```php
use YTBJero\LibEconomy\Economy;
Economy::myMoney($player);
```
## Add the money of a player

```php
use YTBJero\LibEconomy\Economy;
Economy::addMoney($player, $amount);
```

## Reduce the money of a player

```php
use YTBJero\LibEconomy\Economy;
Economy::reduceMoney($player, $amount);
```
