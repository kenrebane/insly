<?php

namespace Insly\Collection;


class InstallmentCollection extends \ArrayObject implements \JsonSerializable
{
    public function __construct($values, $count)
    {
        parent::__construct();

        for($i = 0; $i < $count; $i++) {
            $installment = new Installment($values);
            $this->append($installment);
        }
    }

    public function totals(): InstallmentCollection
    {
        foreach ($this as $installment) {
            foreach($installment->keys() as $fee) {
                if (!isset($this->totals[$fee])) {
                    $this->totals[$fee] = $installment->offsetGet($fee);
                } else {
                    $this->totals[$fee] += $installment->offsetGet($fee);
                }
            }
        }
        return $this;
    }

    public function update($fees): void
    {
        foreach($fees as $name => $fee) {
            $initial = $this[$this->count()-1]->offsetGet($name);
            $this[$this->count()-1]->set($name, bcdiv($initial + $fee-$this->totals[$name], 1, 2));
        }
    }

    public function jsonSerialize(): array
    {
        return $this->getArrayCopy();
    }
}