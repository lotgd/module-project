<?php
declare(strict_types=1);

namespace MyVendor\MyNamespace\Tests;

use LotGD\Core\Game;
use LotGD\Core\Models\Character;
use LotGD\Core\Models\Module as ModuleModel;

use MyVendor\MyNamespace\Module;

class ModuleTest extends ModuleTestCase
{
    protected string $dataset = "module";

    // TODO for LotGD staff: this test assumes the schema in their yaml file
    // reflects all columns in the core's models of characters, scenes and modules.
    // This is pretty fragile since every time we add a column, everyone's tests
    // will break.
    public function testUnregister()
    {
        Module::onUnregister($this->g, $this->moduleModel);
        $m = $this->getEntityManager()->getRepository(ModuleModel::class)->find(self::Library);
        $m->delete($this->getEntityManager());

        // Assert that databases are the same before and after.
        // TODO for module author: update list of tables below to include the
        // tables you modify during registration/unregistration.
        $tableList = [
            'characters', 'scenes', 'modules'
        ];

        $this->assertDataWasKeptIntact($this->getDataSet(), $this->getConnection()[0], $tableList);

        // Since tearDown() contains an onUnregister() call, this also tests
        // double-unregistering, which should be properly supported by modules.
    }

    public function testHandleUnknownEvent()
    {
        // Always good to test a non-existing event just to make sure nothing happens :).
        $context = new \LotGD\Core\Events\EventContext(
            "e/lotgd/tests/unknown-event",
            "none",
            \LotGD\Core\Events\EventContextData::create([])
        );

        $newContext = Module::handleEvent($this->g, $context);

        $this->assertSame($context, $newContext);
    }
}