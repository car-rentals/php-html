<?php namespace Arcanedev\Html\Tests\Concerns;

use DOMDocument;

/**
 * Trait     AssertsHtmlStrings
 *
 * @package  Arcanedev\Html\Tests\Concerns
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
trait AssertsHtmlStrings
{
    /* -----------------------------------------------------------------
     |  Custom Assertions
     | -----------------------------------------------------------------
     */

    /**
     * Assert two Html strings are equals.
     *
     * @param  string  $expected
     * @param  string  $actual
     * @param  string  $message
     */
    public static function assertHtmlStringEqualsHtmlString(string $expected, string $actual, string $message = '')
    {
        static::assertEquals(
            static::convertToDomDocument($expected),
            static::convertToDomDocument($actual),
            $message,
            0.0,
            10,
            true
        );
    }

    /* -----------------------------------------------------------------
     |  Other Methods
     | -----------------------------------------------------------------
     */

    /**
     * Convert string to DOMDocument.
     *
     * @param  string  $html
     *
     * @return \DOMDocument
     */
    protected static function convertToDomDocument($html)
    {
        return tap(new DOMDocument, function (DOMDocument $dom) use ($html) {
            $dom->loadHTML(preg_replace('/>\s+</', '><', $html));
            $dom->preserveWhiteSpace = false;
        });
    }
}
