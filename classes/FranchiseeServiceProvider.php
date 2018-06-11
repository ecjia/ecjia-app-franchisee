<?php

namespace Ecjia\App\Franchisee;

use Royalcms\Component\App\AppServiceProvider;

class FranchiseeServiceProvider extends  AppServiceProvider
{
    
    public function boot()
    {
        $this->package('ecjia/app-franchisee');
    }
    
    public function register()
    {
        
    }
    
    
    
}