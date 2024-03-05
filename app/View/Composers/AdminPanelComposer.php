<?php
 
namespace App\View\Composers;

use App\Facades\PluginService;
use App\Repositories\UserRepository;
use Illuminate\View\View;
 
class AdminPanelComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $data = [
            'active_plugins_sidebars'=>PluginService::getActivePluginNavigationLocation(),
            'placeholder' => getPlaceholderImagePath()
        ];

        $view->with($data);
    }
}