<?php 

declare(strict_types=1);

namespace YTBJero\LibEconomy;

use pocketmine\Server as PMServer;
use pocketmine\player\Player;
use SOFe\Capital\{Capital, CapitalException, LabelSet};

final class Economy{
	
	protected $selector;

	private const ECONOMYAPI = "EconomyAPI";
	
	private const BEDROCKECONOMYAPI = "BedrockEconomyAPI";
	
	private const CAPITAL = "Capital";

	/**
	 * @return array
	 */
	private function getEconomy(){
		$api = PMServer::getInstance()->getPluginManager()->getPlugin("EconomyAPI");
		if($api !== null){
			return [self::ECONOMYAPI, $api];
		} else{
			$api = PMServer::getInstance()->getPluginManager()->getPlugin("BedrockEconomy");
			if($api !== null){
				return [self::BEDROCKECONOMYAPI, $api];
			} else{
				$api = PMServer::getInstance()->getPluginManager()->getPlugin("Capital");
				if($api !== null){
					return [self::CAPITAL, $api];
				} 
		}
	}
	/**
	 * @param  Player $player
	 */
	public static function myMoney(Player $player){
		if($this->getEconomy()[0] === self::ECONOMYAPI){
			return $this->getEconomy()[1]->myMoney($player);
		} elseif($this->getEconomy()[0] === self::BEDROCKECONOMYAPI){
			return $this->getEconomy()[1]->getAPI()->getPlayerBalance($player->getName());
		}
	}
	/**
	 * @param Player $player
	 * @param int $amount
	 */
	public static function addMoney(Player $player, $amount){
		Capital::api("0.1.0", function(Capital $api) {
      		$this->selector = $api->completeConfig(["unknown"]);
    		});
		
		if($this->getEconomy()[0] === self::ECONOMYAPI){
			$this->getEconomy()[1]->addMoney($player, $amount);
		} elseif($this->getEconomy()[0] === self::BEDROCKECONOMYAPI){
			return $this->getEconomy()[1]->getAPI()->addToPlayerBalance($player->getName(), (int) ceil($amount));
		} elseif($this->getEconomy()[0] === self::CAPITAL){
			Capital::api("0.1.0", function(Capital $api) use($player) {
    			try {
      				yield from $api->addMoney(
        			"Null",
       				 $player,
        			$this->selector,
        			$amount, 
        			new LabelSet(["reason" => "Null"]),
      			);
		}
	}
	/**
	 * @param  Player $player
	 * @param  int $amount
	 */
	public static function reduceMoney(Player $player, $amount){
		Capital::api("0.1.0", function(Capital $api) {
      		$this->selector = $api->completeConfig(["unknown"]);
    		});
		if($this->getEconomy()[0] === self::ECONOMYAPI){
			$this->getEconomy()[1]->reduceMoney($player, $amount);
		} elseif($this->getEconomy()[0] === self::BEDROCKECONOMYAPI){
			return $this->getEconomy()[1]->getAPI()->subtractFromPlayerBalance($player->getName(), (int) ceil($amount));
		} elseif($this->getEconomy()[0] === self::CAPITAL){
			Capital::api("0.1.0", function(Capital $api) use($player) {
    			try {
      				yield from $api->takeMoney(
        			"Null",
       				 $player,
        			$this->selector,
        			$amount, 
        			new LabelSet(["reason" => "Null"]),
      			);
		}
	}
}
