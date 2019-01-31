<?php namespace Arcanedev\Html\Tests\Elements;

use Arcanedev\Html\Elements\Div;
use Arcanedev\Html\Elements\Element;

/**
 * Class     ElementTest
 *
 * @package  Arcanedev\Html\Tests\Elements
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class ElementTest extends TestCase
{
    /* -----------------------------------------------------------------
     |  Tests
     | -----------------------------------------------------------------
     */

    /** @test */
    public function it_can_create_an_element()
    {
        static::assertEquals(
            '<meta>',
            Element::withTag('meta')
        );
    }

    /** @test */
    public function it_can_create_an_element_with_attributes()
    {
        static::assertHtmlStringEqualsHtmlString(
            '<meta name="csrf-token" content="csrf-token-value">',
            Element::withTag('meta')->attributes(['name' => 'csrf-token', 'content' => 'csrf-token-value'])
        );
    }

    /** @test */
    public function it_can_create_an_element_with_a_custom_tag()
    {
        static::assertSame(
            '<foo></foo>',
            Element::withTag('foo')->toHtml()
        );
    }

    /**
     * @test
     *
     * @expectedException         \Arcanedev\Html\Exceptions\MissingTagException
     * @expectedExceptionMessage  Class Arcanedev\Html\Elements\Element has no `$tag` property or empty.
     */
    public function it_cant_create_an_element_without_a_tag()
    {
        Element::make()->render();
    }

    /** @test */
    public function it_can_add_conditional_changes()
    {
        $elt      = Element::withTag('foo');
        $callback = function (Element $elt) {
            return (clone $elt)->attributes(['class' => 'active']);
        };

        static::assertEquals(
            '<foo class="active"></foo>',
            $elt->if(true, $callback)
        );

        static::assertEquals(
            '<foo></foo>',
            $elt->if(false, $callback)
        );

        static::assertEquals(
            '<foo class="active"></foo>',
            $elt->unless(false, $callback)
        );

        static::assertEquals(
            '<foo></foo>',
            $elt->unless(true, $callback)
        );
    }

    /** @test */
    public function it_can_set_an_attribute_with_attribute_if()
    {
        static::assertHtmlStringEqualsHtmlString(
            '<div foo="bar"></div>',
            Div::make()
                ->attributeIf(true, 'foo', 'bar')
                ->attributeIf(false, 'bar', 'baz')
                ->render()
        );

        static::assertHtmlStringEqualsHtmlString(
            '<div foo="bar"></div>',
            Element::withTag('div')
                ->attributeUnless(false, 'foo', 'bar')
                ->attributeUnless(true, 'bar', 'baz')
                ->render()
        );

        static::assertHtmlStringEqualsHtmlString(
            '<input required>',
            Element::withTag('input')
                ->attributeUnless(false, 'required')
                ->render()
        );
    }

    /** @test */
    public function it_can_get_class_list()
    {
        $elt = Element::withTag('a')->class('btn btn-primary');

        static::assertEquals(
            '<a class="btn btn-primary"></a>',
            $elt
        );

        static::assertInstanceOf(
            \Arcanedev\Html\Entities\Attributes\ClassAttribute::class,
            $elt->classList()
        );

        $elt->classList()->toggle('active');

        static::assertEquals(
            '<a class="btn btn-primary active"></a>',
            $elt
        );

        $elt->classList()->toggle('active');

        static::assertEquals(
            '<a class="btn btn-primary"></a>',
            $elt
        );
    }

    /**
     * @test
     *
     * @expectedException         \Arcanedev\Html\Exceptions\InvalidHtmlException
     * @expectedExceptionMessage  Can't set inner contents on `br` because it's a void element
     */
    public function it_must_throw_exception_on_void_element_with_child_elements()
    {
        Element::withTag('br')->html('Hello');
    }
}