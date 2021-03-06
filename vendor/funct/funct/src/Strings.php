<?php

namespace Funct\Strings;

/**
 * Extracts the string between two substrings
 *
 * @param string $input
 * @param string $left
 * @param string $right
 *
 * @return string
 *
 * @author Lucantis Swann <lucantis.swann@gmail.com>
 */
function between($input, $left, $right)
{
    $input = ' ' . $input;
    $ini   = strpos($input, $left);

    if ($ini == 0) {
        return '';
    }

    $ini += strlen($left);
    $len = strpos($input, $right, $ini) - $ini;

    return substr($input, $ini, $len);
}


/**
 * Camelizes string
 *
 * @param string $input
 * @param bool   $firstLetterUppercase
 *
 * @return string
 *
 * @author Aurimas Niekis <aurimas@niekis.lt>
 */
function camelize($input, $firstLetterUppercase = false)
{
    $input = trim($input);

    if ($firstLetterUppercase) {
        $input = upperCaseFirst($input);
    } else {
        $input = lowerCaseFirst($input);
    }

    $input = preg_replace('/^[-_]+/', '', $input);

    $input = preg_replace_callback(
        '/[-_\s]+(.)?/u',
        function ($match) {
            if (isset($match[1])) {
                return strtoupper($match[1]);
            } else {
                return '';
            }
        },
        $input
    );

    $input = preg_replace_callback(
        '/[\d]+(.)?/u',
        function ($match) {
            return strtoupper($match[0]);
        },
        $input
    );

    return $input;
}


/**
 * Removes prefix from start of string
 *
 * @param string $input
 * @param string $prefix
 *
 * @return string
 *
 * @author Lucantis Swann <lucantis.swann@gmail.com>
 */
function chompLeft($input, $prefix)
{
    if (startsWith($input, $prefix)) {
        return mb_substr($input, mb_strlen($prefix));
    }

    return $input;
}

/**
 * Removes suffix from end of string
 *
 * @param string $input
 * @param string $suffix
 *
 * @return string
 *
 * @author Lucantis Swann <lucantis.swann@gmail.com>
 */
function chompRight($input, $suffix)
{
    if (endsWith($input, $suffix)) {

        return mb_substr($input, 0, mb_strlen($input) - mb_strlen($suffix));
    }

    return $input;
}

/**
 * Converts string to camelized class name. First letter is always upper case
 *
 * @param string $string
 *
 * @return string
 * @author Aurimas Niekis <aurimas@niekis.lt>
 */
function classify($string)
{
    return camelize($string, true);
}


/**
 * Collapse multiple spaces
 *
 * @param string $input
 *
 * @return string
 *
 * @author Lucantis Swann <lucantis.swann@gmail.com>
 */
function collapseWhitespace($input)
{
    return preg_replace('/\s+/u', ' ', $input);
}

/**
 * Check if string contains substring
 *
 * @param string $input
 * @param string $substring
 *
 * @return bool
 *
 * @author Lucantis Swann <lucantis.swann@gmail.com>
 */
function contains($input, $substring)
{
    return mb_strpos($input, $substring) !== false;
}

/**
 * Count the occurrences of substring in string
 *
 * @param string $input
 * @param string $substring
 *
 * @return int
 *
 * @author Lucantis Swann <lucantis.swann@gmail.com>
 */
function countOccurrences($input, $substring)
{
    return mb_substr_count($input, $substring);
}


/**
 * Converts hyphens and camel casing to underscores
 *
 * @param string $string
 *
 * @return string
 * @author Aurimas Niekis <aurimas@niekis.lt>
 */
function dasherize($string)
{
    return strtolower(preg_replace('/(?<!^)([A-Z])/', '-$1', str_replace('_', '-', $string)));
}


/**
 * Check if string ends with substring
 *
 * @param string $input
 * @param string $substring
 *
 * @return bool
 *
 * @author Lucantis Swann <lucantis.swann@gmail.com>
 */
function endsWith($input, $substring)
{
    return mb_substr($input, -strlen($substring)) === $substring;
}

/**
 * Alias of contains
 *
 * @param string $input
 * @param string $substring
 *
 * @return bool
 *
 * @author Lucantis Swann <lucantis.swann@gmail.com>
 */
function includes($input, $substring)
{
    return contains($input, $substring);
}


/**
 * Check if string contains only letters
 *
 * @param string $input
 *
 * @return bool
 *
 * @author Lucantis Swann <lucantis.swann@gmail.com>
 */
function isAlpha($input)
{
    return ctype_alpha($input);
}

/**
 * Check if string contains only alphanumeric
 *
 * @param string $input
 *
 * @return bool
 *
 * @author Lucantis Swann <lucantis.swann@gmail.com>
 */
function isAlphaNumeric($input)
{
    return ctype_alnum($input);
}

/**
 * Checks if letters in given string are all lowercase.
 *
 * @param string $input
 * @param bool   $mb
 *
 * @return bool
 *
 * @author Ernestas Kvedaras <kvedaras.ernestas@gmail.com>
 */
function isLower($input, $mb = false)
{
    return $mb
        ? mb_strtolower($input, mb_detect_encoding($input, 'auto')) === $input
        : strtolower($input) === $input;
}


/**
 * Check if string contains only digits
 *
 * @param string $input
 *
 * @return bool
 *
 * @author Lucantis Swann <lucantis.swann@gmail.com>
 */
function isNumeric($input)
{
    return ctype_digit($input);
}

/**
 * Checks if letters in given string are all uppercase.
 *
 * @param string $input
 * @param bool   $mb
 *
 * @return bool
 *
 * @author Ernestas Kvedaras <kvedaras.ernestas@gmail.com>
 */
function isUpper($input, $mb = false)
{
    return $mb
        ? mb_strtoupper($input, mb_detect_encoding($input, 'auto')) === $input
        : strtoupper($input) === $input;
}


/**
 * Remove accents from latin characters
 *
 * @param string $input
 *
 * @return string
 *
 * @author Lucantis Swann <lucantis.swann@gmail.com>
 */
function latinize($input)
{
    $table = [
        '??' => 'a', '??' => 'b', '??' => 't', '??' => 'th', '??' => 'g', '??' => 'h', '??' => 'kh', '??' => 'd', '??' => 'th',
        '??' => 'r', '??' => 'z', '??' => 's', '??' => 'sh', '??' => 's', '??' => 'd', '??' => 't', '??' => 'th', '??' => 'aa',
        '??' => 'gh', '??' => 'f', '??' => 'k', '??' => 'k', '??' => 'l', '??' => 'm', '??' => 'n', '??' => 'h', '??' => 'o',
        '??' => 'y', '??' => 'A', '??' => 'O', '??' => 'U', '??' => 'ss', '??' => 'a', '??' => 'o', '??' => 'u', '???' => 'k',
        '???' => 'kh', '???' => 'g', '???' => 'ga', '???' => 'ng', '???' => 's', '???' => 'sa', '???' => 'z', '??????' => 'za',
        '???' => 'ny', '???' => 't', '???' => 'ta', '???' => 'd', '???' => 'da', '???' => 'na', '???' => 't', '???' => 'ta', '???' => 'd',
        '???' => 'da', '???' => 'n', '???' => 'p', '???' => 'pa', '???' => 'b', '???' => 'ba', '???' => 'm', '???' => 'y', '???' => 'ya',
        '???' => 'l', '???' => 'w', '???' => 'th', '???' => 'h', '???' => 'la', '???' => 'a', '???' => 'y', '???' => 'ya', '???' => 'w',
        '??????' => 'yw', '??????' => 'ywa', '???' => 'h', '???' => 'e', '???' => '-e', '???' => 'i', '???' => '-i', '???' => 'u',
        '???' => '-u', '???' => 'aw', '????????????' => 'aw', '???' => 'aw', '???' => 'ywae', '???' => 'hnaik', '???' => '0', '???' => '1',
        '???' => '2', '???' => '3', '???' => '4', '???' => '5', '???' => '6', '???' => '7', '???' => '8', '???' => '9', '???' => '',
        '???' => '', '???' => '', '???' => 'a', '???' => 'a', '???' => 'e', '???' => 'e', '???' => 'i', '???' => 'i', '??????' => 'o',
        '???' => 'u', '???' => 'u', '????????????' => 'aung', '??????' => 'aw', '?????????' => 'aw', '??????' => 'aw', '?????????' => 'aw', '???' => 'at',
        '??????' => 'et', '????????????' => 'aik', '????????????' => 'auk', '??????' => 'in', '????????????' => 'aing', '????????????' => 'aung', '??????' => 'it',
        '??????' => 'i', '??????' => 'at', '?????????' => 'eik', '?????????' => 'ok', '?????????' => 'ut', '?????????' => 'it', '??????' => 'd',
        '????????????' => 'ok', '?????????' => 'ait', '??????' => 'an', '?????????' => 'an', '?????????' => 'ein', '?????????' => 'on', '?????????' => 'un',
        '??????' => 'at', '?????????' => 'eik', '?????????' => 'ok', '?????????' => 'ut', '???????????????' => 'nub', '??????' => 'an', '?????????' => 'ein',
        '?????????' => 'on', '?????????' => 'un', '??????' => 'e', '????????????' => 'ol', '??????' => 'in', '???' => 'an', '??????' => 'ein',
        '??????' => 'on', '??' => 'C', '??' => 'D', '??' => 'E', '??' => 'N', '??' => 'R', '??' => 'S', '??' => 'T', '??' => 'U',
        '??' => 'Z', '??' => 'c', '??' => 'd', '??' => 'e', '??' => 'n', '??' => 'r', '??' => 's', '??' => 't', '??' => 'u',
        '??' => 'z', '??' => 0, '??' => 1, '??' => 2, '??' => 3, '???' => 4, '???' => 5, '???' => 6, '???' => 7, '???' => 8, '???' => 9,
        '???' => 0, '???' => 1, '???' => 2, '???' => 3, '???' => 4, '???' => 5, '???' => 6, '???' => 7, '???' => 8, '???' => 9, '??' => 'ae',
        '??' => 'ae', '??' => 'A', '??' => 'A', '??' => 'A', '??' => 'A', '??' => 'AA', '??' => 'A', '??' => 'A', '??' => 'A',
        '??' => 'AE', '??' => 'AE', '??' => 'a', '??' => 'a', '??' => 'a', '??' => 'a', '??' => 'aa', '??' => 'a', '??' => 'a',
        '??' => 'a', '??' => 'a', '@' => 'at', '??' => 'C', '??' => 'C', '??' => 'c', '??' => 'c', '??' => 'c', '??' => 'Dj',
        '??' => 'D', '??' => 'dj', '??' => 'd', '??' => 'E', '??' => 'E', '??' => 'E', '??' => 'E', '??' => 'E', '??' => 'E',
        '??' => 'e', '??' => 'e', '??' => 'e', '??' => 'e', '??' => 'e', '??' => 'e', '??' => 'f', '??' => 'G', '??' => 'G',
        '??' => 'g', '??' => 'g', '??' => 'H', '??' => 'H', '??' => 'h', '??' => 'h', '??' => 'I', '??' => 'I', '??' => 'I',
        '??' => 'I', '??' => 'I', '??' => 'I', '??' => 'I', '??' => 'I', '??' => 'IJ', '??' => 'i', '??' => 'i', '??' => 'i',
        '??' => 'i', '??' => 'i', '??' => 'i', '??' => 'i', '??' => 'i', '??' => 'ij', '??' => 'J', '??' => 'j', '??' => 'L',
        '??' => 'L', '??' => 'L', '??' => 'l', '??' => 'l', '??' => 'l', '??' => 'N', '??' => 'n', '??' => 'n', '??' => 'O',
        '??' => 'O', '??' => 'O', '??' => 'O', '??' => 'O', '??' => 'O', '??' => 'O', '??' => 'O', '??' => 'OE', '??' => 'O',
        '??' => 'OE', '??' => 'o', '??' => 'o', '??' => 'o', '??' => 'o', '??' => 'o', '??' => 'o', '??' => 'o', '??' => 'o',
        '??' => 'oe', '??' => 'o', '??' => 'o', '??' => 'oe', '??' => 'R', '??' => 'R', '??' => 'r', '??' => 'r', '??' => 'S',
        '??' => 'S', '??' => 's', '??' => 's', '??' => 's', '??' => 'T', '??' => 'T', '??' => 'T', '??' => 'TH', '??' => 't',
        '??' => 't', '??' => 't', '??' => 'th', '??' => 'U', '??' => 'U', '??' => 'U', '??' => 'U', '??' => 'U', '??' => 'U',
        '??' => 'U', '??' => 'U', '??' => 'U', '??' => 'U', '??' => 'U', '??' => 'U', '??' => 'U', '??' => 'u', '??' => 'u',
        '??' => 'u', '??' => 'u', '??' => 'u', '??' => 'u', '??' => 'u', '??' => 'u', '??' => 'u', '??' => 'u', '??' => 'u',
        '??' => 'u', '??' => 'u', '??' => 'W', '??' => 'w', '??' => 'Y', '??' => 'Y', '??' => 'Y', '??' => 'y', '??' => 'y',
        '??' => 'y', '???' => 'a', '???' => 'b', '???' => 'g', '???' => 'd', '???' => 'e', '???' => 'v', '???' => 'z', '???' => 't',
        '???' => 'i', '???' => 'k', '???' => 'l', '???' => 'm', '???' => 'n', '???' => 'o', '???' => 'p', '???' => 'zh', '???' => 'r',
        '???' => 's', '???' => 't', '???' => 'u', '???' => 'f', '???' => 'k', '???' => 'gh', '???' => 'q', '???' => 'sh', '???' => 'ch',
        '???' => 'ts', '???' => 'dz', '???' => 'ts', '???' => 'ch', '???' => 'kh', '???' => 'j', '???' => 'h', '????' => 'AU',
        '????' => 'Au', '????' => 'OU', '????' => 'Ou', '????' => 'EU', '????' => 'Eu', '????' => 'I', '????' => 'I', '????' => 'I',
        '????' => 'I', '????' => 'I', '????' => 'I', '????' => 'AU', '????' => 'Au', '????' => 'OU', '????' => 'Ou', '????' => 'EU',
        '????' => 'Eu', '????' => 'I', '????' => 'I', '????' => 'I', '????' => 'I', '????' => 'I', '????' => 'I', '????' => 'I',
        '????' => 'I', '????' => 'au', '????' => 'ou', '????' => 'eu', '????' => 'i', '????' => 'i', '????' => 'i', '????' => 'au',
        '????' => 'ou', '????' => 'eu', '????' => 'i', '????' => 'i', '????' => 'i', '????' => 'i', '??' => 'A', '??' => 'V',
        '??' => 'G', '??' => 'D', '??' => 'E', '??' => 'Z', '??' => 'I', '??' => 'Th', '??' => 'I', '??' => 'K', '??' => 'L',
        '??' => 'M', '??' => 'N', '??' => 'X', '??' => 'O', '??' => 'P', '??' => 'R', '??' => 'S', '??' => 'T', '??' => 'I',
        '??' => 'F', '??' => 'Ch', '??' => 'Ps', '??' => 'O', '??' => 'A', '??' => 'E', '??' => 'I', '??' => 'I', '??' => 'O',
        '??' => 'I', '??' => 'I', '??' => 'I', '??' => 'I', '??' => 'a', '??' => 'v', '??' => 'g', '??' => 'd', '??' => 'e',
        '??' => 'z', '??' => 'i', '??' => 'th', '??' => 'i', '??' => 'k', '??' => 'l', '??' => 'm', '??' => 'n', '??' => 'x',
        '??' => 'o', '??' => 'p', '??' => 'r', '??' => 's', '??' => 's', '??' => 't', '??' => 'i', '??' => 'f', '??' => 'ch',
        '??' => 'ps', '??' => 'o', '??' => 'a', '??' => 'e', '??' => 'i', '??' => 'i', '??' => 'o', '??' => 'i', '??' => 'i',
        '??' => 'i', '??' => 'i', '??' => 'o', '??' => 'v', '??' => 'th', '???' => 'a', '???' => 'aa', '???' => 'e', '???' => 'ii',
        '???' => 'ei', '???' => '???', '???' => 'ai', '???' => 'i', '???' => 'o', '???' => 'oi', '???' => 'oii', '???' => 'uu',
        '???' => 'ou', '???' => 'u', '???' => 'B', '???' => 'Bha', '???' => 'Ca', '???' => 'Chha', '???' => 'Da', '???' => 'Dha',
        '???' => 'Fa', '??????' => 'Fi', '???' => 'Ga', '???' => 'Gha', '??????' => 'Ghi', '???' => 'Ha', '???' => 'Ja', '???' => 'Jha',
        '???' => 'Ka', '???' => 'Kha', '??????' => 'Khi', '???' => 'L', '???' => 'Li', '???' => 'Li', '???' => 'Lii', '???' => 'Lii',
        '???' => 'Ma', '???' => 'Na', '???' => 'Na', '???' => 'Nia', '???' => 'Nae', '???' => 'Ni', '???' => 'oms', '???' => 'Pa',
        '??????' => 'Qi', '???' => 'Ra', '???' => 'Ri', '???' => 'Ri', '???' => 'Ri', '???' => 'Sa', '???' => 'Sha', '???' => 'Shha',
        '???' => 'Ta', '???' => 'Ta', '???' => 'Tha', '???' => 'Tha', '???' => 'Tha', '???' => 'Thha', '??????' => 'ugDha',
        '??????' => 'ugDhha', '???' => 'Va', '???' => 'Ya', '??????' => 'Yi', '??????' => 'Za', '??' => 'A', '??' => 'E', '??' => 'G',
        '??' => 'I', '??' => 'K', '??' => 'L', '??' => 'N', '??' => 'U', '??' => 'a', '??' => 'e', '??' => 'g', '??' => 'i',
        '??' => 'k', '??' => 'l', '??' => 'n', '??' => 'u', '??' => 'A', '??' => 'C', '??' => 'E', '??' => 'L', '??' => 'N',
        '??' => 'O', '??' => 'S', '??' => 'Z', '??' => 'Z', '??' => 'a', '??' => 'c', '??' => 'e', '??' => 'l', '??' => 'n',
        '??' => 'o', '??' => 's', '??' => 'z', '??' => 'z', '??' => '', '??' => '', '??' => 'A', '??' => 'B', '??' => 'C',
        '??' => 'Ch', '??' => 'D', '??' => 'E', '??' => 'E', '??' => 'E', '??' => 'F', '??' => 'G', '??' => 'H', '??' => 'I',
        '??' => 'Y', '??' => 'Ya', '??' => 'Yu', '??' => 'K', '??' => 'L', '??' => 'M', '??' => 'N', '??' => 'O', '??' => 'P',
        '??' => 'R', '??' => 'S', '??' => 'Sh', '??' => 'Shch', '??' => 'T', '??' => 'U', '??' => 'V', '??' => 'Y', '??' => 'Z',
        '??' => 'Zh', '??' => '', '??' => '', '??' => 'a', '??' => 'b', '??' => 'c', '??' => 'ch', '??' => 'd', '??' => 'e',
        '??' => 'e', '??' => 'e', '??' => 'f', '??' => 'g', '??' => 'h', '??' => 'i', '??' => 'y', '??' => 'ya', '??' => 'yu',
        '??' => 'k', '??' => 'l', '??' => 'm', '??' => 'n', '??' => 'o', '??' => 'p', '??' => 'r', '??' => 's', '??' => 'sh',
        '??' => 'shch', '??' => 't', '??' => 'u', '??' => 'v', '??' => 'y', '??' => 'z', '??' => 'zh', '??' => 'C', '??' => 'G',
        '??' => 'I', '??' => 'S', '??' => 'c', '??' => 'g', '??' => 'i', '??' => 's', '??' => 'G', '??' => 'I', '??' => 'Ji',
        '??' => 'Ye', '??' => 'g', '??' => 'i', '??' => 'ji', '??' => 'ye', '???' => 'a', '???' => 'a', '???' => 'a', '???' => 'a',
        '???' => 'a', '???' => 'a', '???' => 'a', '???' => 'a', '???' => 'a', '???' => 'a', '???' => 'a', '???' => 'a', '???' => 'e',
        '???' => 'e', '???' => 'e', '???' => 'e', '???' => 'e', '???' => 'e', '???' => 'e', '???' => 'e', '???' => 'i', '???' => 'i',
        '???' => 'o', '???' => 'o', '???' => 'o', '???' => 'o', '???' => 'o', '???' => 'o', '???' => 'o', '???' => 'o', '???' => 'o',
        '???' => 'o', '???' => 'o', '???' => 'o', '???' => 'u', '???' => 'u', '???' => 'u', '???' => 'u', '???' => 'u', '???' => 'u',
        '???' => 'u', '???' => 'y', '???' => 'y', '???' => 'y', '???' => 'y', '???' => 'A', '???' => 'A', '???' => 'A', '???' => 'A',
        '???' => 'A', '???' => 'A', '???' => 'A', '???' => 'A', '???' => 'A', '???' => 'A', '???' => 'A', '???' => 'A', '???' => 'E',
        '???' => 'E', '???' => 'E', '???' => 'E', '???' => 'E', '???' => 'E', '???' => 'E', '???' => 'E', '???' => 'I', '???' => 'I',
        '???' => 'O', '???' => 'O', '???' => 'O', '???' => 'O', '???' => 'O', '???' => 'O', '???' => 'O', '???' => 'O', '???' => 'O',
        '???' => 'O', '???' => 'O', '???' => 'O', '???' => 'U', '???' => 'U', '???' => 'U', '???' => 'U', '???' => 'U', '???' => 'U',
    ];

    $string = strtr($input, $table);

    return $string;
}


/**
 * Return the substring denoted by n positive left-most characters
 *
 * @param string $string
 * @param int    $n
 *
 * @return string
 * @author Aurimas Niekis <aurimas@niekis.lt>
 */
function left($string, $n)
{
    $start = 0;
    if ($n < 0) {
        $start = $n;
        $n     = -$n;
    }

    return substr($string, $start, $n);
}

/**
 * Return the length of a string
 *
 * @param  string $string the input string
 * @param bool    $mb     to use or not to use mb_strlen
 *
 * @return int         the length of the input string
 * @author Rod Elias <rod@wgo.com.br>
 */
function len($string, $mb = false)
{
    return length($string, $mb);
}

/**
 * Return the length of a string
 *
 * @param  string $string the input string
 * @param bool    $mb     to use or not to use mb_strlen
 *
 * @return int         the length of the input string
 * @author Rod Elias <rod@wgo.com.br>
 */
function length($string, $mb = false)
{

    return $mb ? mb_strlen($string) : strlen($string);
}

/**
 * Returns an array with the lines. Cross-platform compatible
 *
 * @param string $string
 *
 * @return array
 * @author Aurimas Niekis <aurimas@niekis.lt>
 */
function lines($string)
{
    return preg_split('/\r\n|\n|\r/', $string);
}


/**
 * Converts string first char to lowercase
 *
 * @param string $input
 *
 * @return string
 *
 * @author Aurimas Niekis <aurimas@niekis.lt>
 */
function lowerCaseFirst($input)
{
    return lcfirst($input);
}


/**
 * Pads the string in the center with specified character. char may be a string or a number, defaults is a space
 *
 * @param string $string
 * @param int    $length
 * @param string $char
 *
 * @return string
 * @author Aurimas Niekis <aurimas@niekis.lt>
 */
function pad($string, $length, $char = ' ')
{
    return str_pad($string, $length, $char, STR_PAD_BOTH);
}


/**
 * Left pads the string
 *
 * @param string $input
 * @param string $length
 * @param string $char
 *
 * @return string
 *
 * @author Lucantis Swann <lucantis.swann@gmail.com>
 */
function padLeft($input, $length, $char = ' ')
{
    return str_pad($input, $length, $char, STR_PAD_LEFT);
}


/**
 * Right pads the string
 *
 * @param string $input
 * @param string $length
 * @param string $char
 *
 * @return string
 *
 * @author Lucantis Swann <lucantis.swann@gmail.com>
 */
function padRight($input, $length, $char = ' ')
{
    return str_pad($input, $length, $char, STR_PAD_RIGHT);
}


/**
 * Repeat the string n times
 *
 * @param string $input
 * @param int    $n
 *
 * @return string
 *
 * @author Lucantis Swann <lucantis.swann@gmail.com>
 */
function repeat($input, $n)
{
    return str_repeat($input, $n);
}

/**
 * Reverses a string
 *
 * @param  string $input
 *
 * @return string
 * @author Rod Elias <rod@wgo.com.br>
 */
function reverse($input)
{
    return strrev($input);
}


/**
 * Return the substring denoted by n positive right-most characters
 *
 * @param string $string
 * @param int    $n
 *
 * @return string
 * @author Aurimas Niekis <aurimas@niekis.lt>
 */
function right($string, $n)
{
    $start = -$n;
    if ($n < 0) {
        $start = 0;
        $n     = -$n;
    }

    return substr($string, $start, $n);
}


/**
 * Converts the text into a valid url slug. Removes accents from Latin characters
 *
 * @param string $string
 *
 * @return string
 * @author Aurimas Niekis <aurimas@niekis.lt>
 */
function slugify($string)
{
    $string = latinize($string);
    $string = preg_replace('~[^\\pL\d]+~u', '-', $string);
    $string = trim($string, '-');
    $string = strtolower($string);

    return preg_replace('~[^-\w]+~', '', $string);
}


/**
 * Check if string starts with substring
 *
 * @param string $input
 * @param string $substring
 *
 * @return bool
 *
 * @author Lucantis Swann <lucantis.swann@gmail.com>
 */
function startsWith($input, $substring)
{
    return mb_strpos($input, $substring) === 0;
}

/**
 * Returns a new string with all occurrences of [string1],[string2],... removed.
 *
 * @param string $string
 * @param string $string1
 *
 * @return string
 * @author Aurimas Niekis <aurimas@niekis.lt>
 */
function strip($string, $string1)
{
    $arguments = func_get_args();

    return str_replace(array_slice($arguments, 1), '', $string);
}


/**
 * Strip all of the punctuation
 *
 * @param string $string
 *
 * @return string
 * @author Aurimas Niekis <aurimas@niekis.lt>
 */
function stripPunctuation($string)
{
    return preg_replace('/[^\w\s]|_/', '', $string);
}

/**
 * Makes a case swapped version of the string
 * @param  string  $string the input string
 * @param  boolean $mb     to use or not to use multibyte character feature
 * @return string          case swapped version of the input string
 *
 * @author Rod Elias <rod@wgo.com.br>
 */
function swapCase($string, $mb = false)
{
    return array_reduce(str_split($string), function($carry, $item) use ($mb) {
        return $carry .= isLower($item, $mb) ? toUpper($item, $mb) : toLower($item, $mb);
    }, '');
}

/**
 * Repeat the string n times
 *
 * @param string $input
 * @param int    $n
 *
 * @return string
 *
 * @author Lucantis Swann <lucantis.swann@gmail.com>
 */
function times($input, $n)
{
    return repeat($input, $n);
}

/**
 * Creates a title version of the string. Capitalizes all the words and replaces some characters in the string to
 * create a nicer looking title. string_titleize is meant for creating pretty output
 *
 * @param string $string
 * @param array  $ignore
 *
 * @return string
 * @author Aurimas Niekis <aurimas@niekis.lt>
 */
function titleize($string, array $ignore = [])
{
    $string = preg_replace('/(?<!^)([A-Z])/', ' $1', $string);
    $string = preg_replace('/[^a-z0-9:]+/i', ' ', $string);
    $string = trim($string);

    return preg_replace_callback(
        '/([\S]+)/u',
        function ($match) use ($ignore) {
            if (in_array(strtolower($match[0]), $ignore)) {
                return $match[0];
            } else {
                return ucfirst(strtolower($match[0]));
            }
        },
        $string
    );
}

/**
 * Makes a string lowercase
 * @param  string  $input the input string
 * @param  boolean $mb    to use or not to use multibyte character feature
 * @return string         lowercased string
 *
 * @author Rod Elias <rod@wgo.com.br>
 */
function toLower($input, $mb = false)
{
    return $mb ? mb_strtolower($input, mb_detect_encoding($input, 'auto')) : strtolower($input);
}

/**
 * Join an array into a human readable sentence
 *
 * @param array  $array
 * @param string $delimiter
 * @param string $lastDelimiter
 *
 * @return string
 * @author Aurimas Niekis <aurimas@niekis.lt>
 */
function toSentence($array, $delimiter = ', ', $lastDelimiter = ' and ')
{
    $lastWord = array_pop($array);

    return implode($delimiter, $array) . $lastDelimiter . $lastWord;
}

/**
 * The same as string_to_sentence, but adjusts delimeters to use Serial comma)
 *
 * @param array  $array
 * @param string $delimiter
 * @param string $lastDelimiter
 *
 * @return string
 * @author Aurimas Niekis <aurimas@niekis.lt>
 */
function toSentenceSerial($array, $delimiter = ', ', $lastDelimiter = ' and ')
{
    $lastWord = array_pop($array);

    $lastDel = '';
    if (count($array) > 1) {
        $lastDel = trim($delimiter, ' ');
    }

    return implode($delimiter, $array) . $lastDel . $lastDelimiter . $lastWord;
}


/**
 * makes a string uppercase
 * @param  string  $input the input string
 * @param  boolean $mb    to use or not to use multibyte character feature
 * @return string         uppercased string
 *
 * @author Rod Elias <rod@wgo.com.br>
 */
function toUpper($input, $mb = false)
{
    return $mb ? mb_strtoupper($input, mb_detect_encoding($input, 'auto')) : strtoupper($input);
}


/**
 * Truncate string accounting for word placement and character count
 *
 * @param  string $input
 * @param  int    $length
 * @param  string $chars
 *
 * @return string
 *
 * @author Lucantis Swann <lucantis.swann@gmail.com>
 */
function truncate($input, $length, $chars = '???')
{
    if (strlen($input) > $length) {
        $splits = preg_split('/([\s\n\r]+)/u', $input, null, PREG_SPLIT_DELIM_CAPTURE);

        $splitsLength = 0;
        $splitsCount  = count($splits);

        for ($lastSplit = 0; $lastSplit < $splitsCount; ++$lastSplit) {
            $splitsLength += strlen($splits[$lastSplit]);
            if ($splitsLength > $length) {
                break;
            }
        }

        return implode(array_slice($splits, 0, $lastSplit)) . $chars;
    } else {
        return $input;
    }
}


/**
 * Converts hyphens and camel casing to underscores
 *
 * @param string $string
 *
 * @return string
 * @author Aurimas Niekis <aurimas@niekis.lt>
 */
function underscore($string)
{
    return strtolower(preg_replace('/(?<!^)([A-Z])/', '_$1', str_replace('-', '_', $string)));
}


/**
 * Converts string first char to uppercase
 *
 * @param string $input
 *
 * @return string
 *
 * @author Aurimas Niekis <aurimas@niekis.lt>
 */
function upperCaseFirst($input)
{
    return ucfirst($input);
}
