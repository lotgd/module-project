<?php
declare(strict_types=1);

namespace LotGD\Modules\MyNamespace;

use LotGD\Core\Game;
use LotGD\Core\Module;

class MyModule implements Module {
    public static function handleEvent(string $event, array $context) { }
    public static function onRegister(Game $g) { }
    public static function onUnregister(Game $g) { }
}
