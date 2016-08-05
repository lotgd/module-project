<?php
declare(strict_types=1);

namespace MyVendor\MyNamespace;

use LotGD\Core\Game;
use LotGD\Core\Module as ModuleInterface;

class Module implements ModuleInterface {
    public static function handleEvent(Game $g, string $event, array $context) { }
    public static function onRegister(Game $g) { }
    public static function onUnregister(Game $g) { }
}
