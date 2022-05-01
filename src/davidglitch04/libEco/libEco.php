<?php 

declare(strict_types=1);

namespace davidglitch04\libEco;

use davidglitch04\libEco\Utils\Utils;
use pocketmine\Server as PMServer;
use pocketmine\player\Player;
use cooldogedev\BedrockEconomy\libs\cooldogedev\libSQL\context\ClosureContext;

final class libEco {

	/**
	 * @return array<string, object>
	 */
	protected static function getEconomy(): array{
		$api = PMServer::getInstance()->getPluginManager()->getPlugin("EconomyAPI");
		if($api !== null){
			return [Utils::ECONOMYAPI, $api];
		} else{
			$api = PMServer::getInstance()->getPluginManager()->getPlugin("BedrockEconomy");
			if($api !== null){
				return [Utils::BEDROCKECONOMYAPI, $api];
			}
		}
	}
	/**
	 * @param  Player $player
	 * @return int
	 */
	public static function myMoney(Player $player): int{
		if (self::getEconomy()[0] === Utils::ECONOMYAPI){
			return self::getEconomy()[1]->myMoney($player);
		} elseif (self::getEconomy()[0] === Utils::BEDROCKECONOMYAPI){
			$value = 0;
			self::getEconomy()[1]->getAPI()->getPlayerBalance(
				$player->getName(),
				ClosureContext::create(
					function (?int $balance) : void{
						$value = $balance;
					},
				)
			);
			return $value;
		}
	}
	/**
	 * @param Player $player
	 * @param int $amount
	 * @return void
	 */
	public static function addMoney(Player $player, int $amount): void{
		if(self::getEconomy()[0] === Utils::ECONOMYAPI){
			self::getEconomy()[1]->addMoney($player, $amount);
		} elseif(self::getEconomy()[0] === Utils::BEDROCKECONOMYAPI){
			self::getEconomy()[1]->getAPI()->addToPlayerBalance($player->getName(), (int)$amount);
		}
	}
	/**
	 * @param  Player $player
	 * @param  int $amount
	 * @return void
	 */
	public static function reduceMoney(Player $player, int $amount): void{
		if(self::getEconomy()[0] === Utils::ECONOMYAPI){
			self::getEconomy()[1]->reduceMoney($player, $amount);
		} elseif(self::getEconomy()[0] === Utils::BEDROCKECONOMYAPI){
			self::getEconomy()[1]->getAPI()->subtractFromPlayerBalance($player->getName(), (int)$amount);
		}
	}
}
