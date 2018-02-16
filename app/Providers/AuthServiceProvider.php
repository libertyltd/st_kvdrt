<?php

namespace App\Providers;

use App\AboutPage;
use App\AdditionalCoefficient;
use App\CategoryDesign;
use App\Contact;
use App\Design;
use App\DesignOption;
use App\FeedBack;
use App\Option;
use App\Order;
use App\Policies\ModelPolicy;
use App\Post;
use App\PostComment;
use App\Role;
use App\RolePermission;
use App\SEO;
use App\Slider;
use App\TextOnVideo;
use App\TypeBathroom;
use App\TypeBuilding;
use App\User;
use App\VariableParam;
use App\Work;
use App\WorkDescription;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        User::class => ModelPolicy::class,
        RolePermission::class => ModelPolicy::class,
        Role::class => ModelPolicy::class,
        Contact::class => ModelPolicy::class,
        Slider::class => ModelPolicy::class,
        FeedBack::class => ModelPolicy::class,
        Work::class => ModelPolicy::class,
        Design::class => ModelPolicy::class,
        TypeBuilding::class => ModelPolicy::class,
        TypeBathroom::class => ModelPolicy::class,
        Option::class => ModelPolicy::class,
        CategoryDesign::class => ModelPolicy::class,
        DesignOption::class => ModelPolicy::class,
        Order::class => ModelPolicy::class,
        SEO::class => ModelPolicy::class,
        WorkDescription::class => ModelPolicy::class,
        Post::class => ModelPolicy::class,
        PostComment::class => ModelPolicy::class,
        AboutPage::class => ModelPolicy::class,
        VariableParam::class => ModelPolicy::class,
        AdditionalCoefficient::class => ModelPolicy::class,
        TextOnVideo::class => ModelPolicy::class,
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        //
    }
}
