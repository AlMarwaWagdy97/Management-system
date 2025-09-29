<?php

namespace App\Enums;

abstract class Enum 
{

    protected $value;
    

    /**
     * @return array
     */
    public static function labels(): array
    {
        $class = new \ReflectionClass(static::class);
        return $class->getConstants();
    }

    /**
     * Returns the names (keys) of all constants in the Enum class
     *
     * @return array
     */
    public static function keys()
    {
        return array_keys(static::labels());
    }
    
    /**
     * Returns instances of the Enum class of all Enum constants
     *
     * @return static[] Constant name in key, Enum instance in value
     */
    public static function values()
    {
        return array_values(static::labels());
    }

    /**
     * Return value by key
     *
     * @param string|int $value
     *
     * @return mixed
     */
    public static function getValue($key)
    {
        return static::labels()[$key]?? "___";
    }

     /**
     * Return value for key
     *
     * @param string|int $value
     *
     * @return mixed
     */
    public static function getKey($value)
    {
        return array_search($value,static::labels());
    }
    

     /**
     * @return string
     */
    public function label(): string
    {
        return $this->value;
    }
}