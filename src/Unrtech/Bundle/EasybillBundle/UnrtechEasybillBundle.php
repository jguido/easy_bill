<?php

namespace Unrtech\Bundle\EasybillBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class UnrtechEasybillBundle extends Bundle
{
    public function getParent() {
        
        return 'FOSUserBundle';
    }
}
