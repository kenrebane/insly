<?php


namespace Insly\Collection;


class Installment implements \ArrayAccess, \JsonSerializable
{
    private array $fees;

    public function __construct(array $fees)
    {
        $this->fees = $fees;
    }

    public function set($offset, $value)
    {
        $this->offsetSet($offset, $value);
    }

    public function offsetSet($offset, $value)
    {
        if (!is_null($offset) && is_numeric($value)) {
            $this->fees[$offset] = $value;
        }
    }

    public function offsetGet($offset)
    {
        return $this->offsetExists($offset) ? $this->fees[$offset] : null;
    }

    public function offsetUnset($offset)
    {
        unset($this->fees[$offset]);
    }

    public function offsetExists($offset): bool
    {
        return isset($this->fees[$offset]);
    }

    public function update($offset, $value)
    {
        if($this->offsetExists(($offset))) {
            $this->fees[$offset] += $value;
        } else {
            $this->set($offset, $value);
        }
    }

    public function keys(): array
    {
        return array_keys($this->fees);
    }

    public function jsonSerialize(): array
    {
        return $this->fees;
    }
}