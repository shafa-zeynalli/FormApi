<?php

class Counter
{
    protected int $count = 0;

    public function increase()
    {
        $this->count +=1;
    }public function decrease()
    {
        $this->count -=1;
    }
}