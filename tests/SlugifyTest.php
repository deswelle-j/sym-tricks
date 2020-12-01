<?php

namespace App\Tests\Service;

use App\Service\Slugify;
use PHPUnit\Framework\TestCase;

class SlugifyTest extends TestCase
{
    /**
     * @dataProvider titleToSlugify
     */
    public function testSlugifyTitle($title, $expectedSlug)
    {
        $slugify = new Slugify();
        $slug = $slugify->slugify($title);

        $this->assertSame($expectedSlug, $slug);
    }

    public function titleToSlugify()
    {
        return [
            ["Backside Air", "backside-air"],
            [" Switch Backside Rodeo 720 ", "switch-backside-rodeo-720"],
            ["BS 540 Seatbelt", "bs-540-seatbelt"]
        ];
    }
}