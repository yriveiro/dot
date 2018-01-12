<?php
namespace Yriveiro\Dot;

/**
 * @codeCoverageIgnore
 */
function json_error($error)
{
    switch ($error) {
        case JSON_ERROR_NONE:
            return 'no error has occurred';
        case JSON_ERROR_DEPTH:
            return 'the maximum stack depth has been exceeded';
        case JSON_ERROR_STATE_MISMATCH:
            return 'invalid or malformed JSON';
        case JSON_ERROR_CTRL_CHAR:
            return 'control character error, possibly incorrectly encoded';
        case JSON_ERROR_SYNTAX:
            return 'syntax error';
        case JSON_ERROR_UTF8:
            return 'malformed UTF-8 characters, possibly incorrectly encoded';
        case JSON_ERROR_RECURSION:
            return 'one or more recursive references in the value to be encoded';
        case JSON_ERROR_INF_OR_NAN:
            return 'one or more NAN or INF values in the value to be encoded';
        case JSON_ERROR_UNSUPPORTED_TYPE:
            return 'a value of a type that cannot be encoded was given';
        case JSON_ERROR_INVALID_PROPERTY_NAME:
            return 'a property name that cannot be encoded was given';
        case JSON_ERROR_UTF16:
            return 'malformed UTF-16 characters, possibly incorrectly encoded';
    }

    return 'incorrect json error code';
}
