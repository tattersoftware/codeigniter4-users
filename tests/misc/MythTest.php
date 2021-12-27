<?php

use Tatter\Users\Factories\MythFactory;
use Tests\Support\TestCase;

/**
 * @internal
 */
final class MythTest extends TestCase
{
    /**
     * @dataProvider invalidProvider
     *
     * @param mixed $input
     */
    public function testFindByIdThrows($input)
    {
        $factory = new MythFactory();

        $this->expectException('InvalidArgumentException');
        $this->expectExceptionMessage('Invalid type for argument');

        $factory->findById($input);
    }

    public function invalidProvider()
    {
        return [
            [null],
            [[]],
            [12.34],
            [new stdClass()],
        ];
    }
}
