<?php

namespace Pinyin\Tests\Unit\Sanity;

use PHPUnit\Framework\TestCase;

class PassStringableObjectAsStringTest extends TestCase
{
    public function testPassStringableObjectAsString(): void
    {
        // Given a stringable object;
        $stringable = new class {
            public function __toString()
            {
                return 'foobar';
            }
        };

        // When we pass it in place of a string;
        $stringTaker = new class($stringable) {
            /** @var string */
            public $content;
            public function __construct(string $content)
            {
                $this->content = $content;
            }
        };

        // Then we shouldn't get any errors.
        self::assertSame((string) $stringable, $stringTaker->content);
    }
}
