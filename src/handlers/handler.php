<?php

interface handler {

    /**
     * @param $object
     * @return string
     * @throws dbException
     */
    public function handle($object): string;
}