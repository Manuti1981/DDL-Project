<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AdgatemediasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AdgatemediasTable Test Case
 */
class AdgatemediasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AdgatemediasTable
     */
    protected $Adgatemedias;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Adgatemedias',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Adgatemedias') ? [] : ['className' => AdgatemediasTable::class];
        $this->Adgatemedias = TableRegistry::getTableLocator()->get('Adgatemedias', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Adgatemedias);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
