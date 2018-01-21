<?php

namespace Zing\Core\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ZingCoreUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
