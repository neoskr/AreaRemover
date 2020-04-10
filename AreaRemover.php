<?php

/**
 * @name        AreaRemover
 * @main        AreaRemover\AreaRemover
 * @author      Ne0sW0rld
 * @version     Master - Beta 1
 * @api         3.0.0  
 * @description (!) 영역을 제거합니다.
 */
 
namespace AreaRemover;


use pocketmine\plugin\PluginBase;
use pocketmine\scheduler\Task;

use ifteam\SimpleArea\database\area\AreaLoader;
use ifteam\SimpleArea\database\area\AreaProvider;



class AreaRemover extends PluginBase
{


	public function onEnable ()
	{

		$this->getScheduler()->scheduleDelayedTask (new class($this) extends Task
		{

			public function __construct (AreaRemover $owner)
			{
				
				$this->owner = $owner;
				
			}
			
			public function onRun (int $currentTick)
			{
				
				$this->owner->getLogger()->info ($this->owner->removeEmptyAreas() . "개의 구매되지 않은 매물이 제거되었습니다.");
				
			}
			
		}, 60);

	}
	
	public function removeEmptyAreas () : int
	{
		
		$c = 0;
		$level = 'flat';

		foreach (AreaLoader::getInstance()->getAll ($level) as $k => $v)
		{

			if ($v ['owner'] !== '') continue;
			
			$c ++;
			AreaProvider::getInstance()->deleteArea ($level, $v ['id']);
			
		}
		
		return $c;
		
	}


}
