<?php

namespace Ecjia\App\Franchisee;

use Royalcms\Component\App\AppParentServiceProvider;

class FranchiseeServiceProvider extends  AppParentServiceProvider
{
    
    public function boot()
    {
        $this->package('ecjia/app-franchisee', null, dirname(__DIR__));
    }
    
    public function register()
    {
        
    }
    
    
    
}