<?php
namespace App\Filter;

/**
 * Interface for filtering the collection by json field.
 *
 * @author Ulrich Grah <grulogdev@gmail.com>
 */
interface JsonFilterInterface
{
    /**
     * @var string Field type string
     */
    public const TYPE_STRING = 'string';

    /**
     * @var string Field type integer
     */
    public const TYPE_INT = 'int';

    /**
     * @var string Field type float
     */
    public const TYPE_FLOAT = 'float';

    /**
     * @var string Field type boolean
     */
    public const TYPE_BOOLEAN = 'bool';

    /**
     * @var array Available field types
     */
    public const AVAILABLE_TYPES = [
        self::TYPE_STRING => true,
        self::TYPE_INT => true,
        self::TYPE_FLOAT => true,
        self::TYPE_BOOLEAN => true,
    ];

    /**
     * @var string Exact matching
     */
    public const STRATEGY_EXACT = 'exact';

    /**
     * @var string The value must be contained in the field
     */
    public const STRATEGY_PARTIAL = 'partial';

    /**
     * @var string Finds fields that are starting with the value
     */
    public const STRATEGY_START = 'start';

    /**
     * @var string Finds fields that are ending with the value
     */
    public const STRATEGY_END = 'end';

    /**
     * @var string Finds fields that are starting with the word
     */
    public const STRATEGY_WORD_START = 'word_start';
}