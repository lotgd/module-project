<?php
declare(strict_types=1);

namespace MyVendor\MyNamespace\Tests;

use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\ORM\Events as DoctrineEvents;
use LotGD\Core\Configuration;
use LotGD\Core\Doctrine\EntityPostLoadEventListener;
use LotGD\Core\Game;
use LotGD\Core\GameBuilder;
use LotGD\Core\LibraryConfigurationManager;
use LotGD\Core\ModelExtender;
use LotGD\Core\Models\EventSubscription;
use LotGD\Core\Models\Module as ModuleModel;
use LotGD\Core\Tests\ModelTestCase;
use Monolog\Logger;
use Monolog\Handler\NullHandler;

use MyVendor\MyNamespace\Module;
use Symfony\Component\Yaml\Yaml;

/**
 * Class ModuleTestCase
 *
 * Abstract basis test case. Only necessary changes here are the two constants (Library and RootNamespace) that you must
 * adjust. In each test deriving from this abstract test class, you must also define $this->dataset
 * @package MyVendor\MyNamespace\Tests
 */
abstract class ModuleTestCase extends ModelTestCase
{
    const Library = 'lotgd/module-project';
    const RootNamespace = "MyVendor\\MyNamespace\\";

    public $g;
    protected $moduleModel;
    protected string $dataset;

    /**
     * This methods loads in the test datasets saved in tests/datasets, and whatever filename you've defined in $this->dataset.
     * @return array
     */
    public function getDataSet(): array
    {
        return Yaml::parseFile(implode(DIRECTORY_SEPARATOR, [__DIR__, 'datasets', $this->dataset . '.yml']));
    }

    /**
     * Utility method - makes sure the current working directory is this module's root (expressed as __DIR__/..)
     * @return string
     */
    public function getCwd(): string
    {
        return implode(DIRECTORY_SEPARATOR, [__DIR__, '..']);
    }

    /**
     * You can switch this to false to see the output of logs during testing.
     * @return bool
     */
    public function useSilentHandler(): bool
    {
        return true;
    }

    /**
     * This method is called each time a test class is run (*not* before each test method within a test class)
     * Its usually not necessary to change this method, unless you need additional setup.
     */
    public function setUp(): void
    {
        parent::setUp();

        // Register and unregister before/after each test, since
        // handleEvent() calls may expect the module be registered (for example,
        // if they read properties from the model).
        $this->moduleModel = new ModuleModel(self::Library);
        $this->moduleModel->save($this->getEntityManager());
        Module::onRegister($this->g, $this->moduleModel);

        $this->g->getEntityManager()->flush();
        $this->g->getEntityManager()->clear();
    }

    /**
     * This method is called each time after a class is run (*not* ater each test method within a test class).
     * Its usually not necessary to change this method, unless you need additional teardown.
     */
    public function tearDown(): void
    {
        $this->g->getEntityManager()->flush();
        $this->g->getEntityManager()->clear();

        Module::onUnregister($this->g, $this->moduleModel);
        $m = $this->getEntityManager()->getRepository(ModuleModel::class)->find(self::Library);
        if ($m) {
            $m->delete($this->getEntityManager());
        }

        parent::tearDown();
    }
}
