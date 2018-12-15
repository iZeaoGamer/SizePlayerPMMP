<?php
declare(strict_types=1);
namespace SizePLayer;
use pocketmine\{
  Server, Player
};
use pocketmine\command\{
  Command, CommandSender
};
use pocketmine\utils\TextFormat as TF;
use pocketmine\entity\Entity;
  
class SizePLayerCommand extends Command {
    
    /** var Plugin */
    private $plugin;
  
    public function __construct($plugin) {
        $this->plugin = $plugin;
        parent::__construct("size", "Change your player size!");
    }
    
    public function execute(CommandSender $player, string $label, array $args){
        if(!$player instanceof Player){
			$player->sendMessage(TF::RED."This command only works in-game");
			return;
		}
        if($player->hasPermission("size.command")) {
            if(isset($args[0])) {
                if(is_numeric($args[0])) {
                    if($args[0] > 15) {
                      $player->sendMessage(TF::RED. "This size cannot be bigger than §2$args[0]");
                      return true;
                    }elseif($args[0] <= 0) {
                      $player->sendMessage(TF::RED. "This size cannot be smaller than or equal to §2$args[0]");
                      return true;
                    }
                    $this->plugin->size[$player->getName()] = $args[0];
                    $player->setScale((float)$args[0]);
                    $player->sendMessage("§dYou have changed your size to §5".TF::GOLD . $args[0]."§d!");
                }elseif($args[0] == "reset") {
                    if(!empty($this->plugin->size[$player->getName()])) {
                        unset($this->plugin->size[$player->getName()]);
                        $player->setScale(1);
                        $player->sendMessage("§dYou size has back to normal!");
                    }else{
                        $player->sendMessage("§dYou have reseted your size!");
                    }
                }else{
                    $player->sendMessage("§aCommands§5 Lists! §3Size§cPlayer\n§7/size help - §bif you don`t know the commands!\n§8» §7/size reset §7- §bThis command reset your sizes!\n§7/size (size:number) §7- §bThis command makes you any size!");
                }
            } else {
              $player->sendMessage(TF::RED. "§cThe size is not a valid number!");
            }
            return true;
        }
        $player->sendMessage(TF::RED. "§cThis command is only meant to be used for voters and ranked players!");
    }
}
