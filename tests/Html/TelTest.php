<?php namespace Arcanedev\Html\Tests\Html;

/**
 * Class     TelTest
 *
 * @package  Arcanedev\Html\Tests\Html
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class TelTest extends TestCase
{
    /* -----------------------------------------------------------------
     |  Tests
     | -----------------------------------------------------------------
     */

    /** @test */
    public function it_can_create_a_tel_link()
    {
        static::assertHtmlStringEqualsHtmlString(
            '<a href="tel:+19999999999">+19999999999</a>',
            $this->html->telLink('+19999999999')
        );
    }

    /** @test */
    public function it_can_create_a_tel_link_with_contents()
    {
        static::assertHtmlStringEqualsHtmlString(
            '<a href="tel:+19999999999">Call me</a>',
            $this->html->telLink('+19999999999', 'Call me')
        );
    }
}
