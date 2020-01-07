<?php

namespace Pinyin\String;

interface Normalizing extends Stringable
{
    public function normalized(): self;
}
