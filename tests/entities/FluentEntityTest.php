<?php

use CodeIgniter\I18n\Time;
use Tatter\Users\Entities\FluentEntity;
use Tatter\Users\Test\EntityTestCase;

/**
 * @internal
 */
final class FluentEntityTest extends EntityTestCase
{
    protected $class = FluentEntity::class;

    /**
     * Fluent does not suport names so the result should always be null.
     */
    public function testGetName()
    {
        $this->data['name'] = 'Desmond Tutu';
        $entity             = new $this->class($this->data);

        $this->assertNull($entity->name);
    }

    /**
     * Fluent does not have an "active" attribute so status
     * is deteremined based on deleted_at.
     *
     * @dataProvider activeProvider
     *
     * @param mixed $input
     */
    public function testIsActive($input, bool $result)
    {
        $this->data['deleted_at'] = $input;
        $entity                   = new $this->class($this->data);

        $this->assertSame($result, $entity->isActive());
    }

    public function activeProvider()
    {
        return [
            [null, true],
            [Time::now(), false],
        ];
    }
}
