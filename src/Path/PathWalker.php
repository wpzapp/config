<?php
/**
 * Configuration utility for WP-ZAPP modules and libraries.
 *
 * @package WPZAPP\Config
 * @license GPL-3.0
 * @link    https://wpzapp.org
 */

namespace WPZAPP\Config\Path;

use WPZAPP\Config\Exception\PathSegmentNotFoundException;

/**
 * Class representing a path to a key.
 *
 * @since 1.0.0
 */
class PathWalker
{

    /**
     * Check whether a specific path can be walked on a given input array.
     *
     * @since 1.0.0
     *
     * @param array $input Input array.
     * @param Path  $path  Path.
     *
     * @return bool True if the path can be walked on the input, false otherwise.
     */
    public static function canWalk(array $input, Path $path): bool
    {
        $result = $input;

        $segments = $path->getSegments();

        while (count($segments) > 0) {
            $key = array_shift($segments);

            if (!isset($result[$key])) {
                return false;
            }

            $result = $result[$key];
        }

        return true;
    }

    /**
     * Walk a specific path on a given input array and get the subset located there.
     *
     * @since 1.0.0
     *
     * @param array $input Input array.
     * @param Path  $path  Path.
     *
     * @return mixed A subset of the $input array, located by the $path.
     */
    public static function walk(array $input, Path $path)
    {
        $result = $input;

        $segments = $path->getSegments();

        while (count($segments) > 0) {
            $key = array_shift($segments);

            if (!isset($result[$key])) {
                throw new PathSegmentNotFoundException(sprintf('Segment %1$s of path %2$s does not exist on the input array.', $key, (string) $path));
            }

            $result = $result[$key];
        }

        return $result;
    }
}
