<?php

namespace App\Providers;

use App\Policies\FileTypePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Modules\Khotian\App\Models\EightRegister;
use Modules\Khotian\App\Models\KhasLandKhotian;
use Modules\Khotian\App\Models\MutedKhotian;
use Modules\Khotian\App\Policies\EightRegisterPolicy;
use Modules\Khotian\App\Policies\KhasLandKhotianPolicy;
use Modules\Khotian\App\Policies\MutedKhotiansPolicy;
use Modules\Landless\App\Models\FileType;
use Modules\Landless\App\Models\Landless;
use Modules\Landless\App\Policies\LandlessPolicy;
use Modules\Meeting\App\Policies\CommitteeTypePolicy;
use Modules\Meeting\App\Policies\MeetingPolicy;
use Modules\Meeting\App\Policies\NotificationPolicy;
use Modules\Meeting\App\Policies\TemplatePolicy;
use Modules\Meeting\Models\CommitteeType;
use Modules\Meeting\Models\Meeting;
use Modules\Meeting\Models\Notification;
use Modules\Meeting\Models\Template;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */

    protected $policies = [
        Landless::class => LandlessPolicy::class,
        CommitteeType::class => CommitteeTypePolicy::class,
        Template::class => TemplatePolicy::class,
        Meeting::class => MeetingPolicy::class,
        Notification::class => NotificationPolicy::class,
        MutedKhotian::class => MutedKhotiansPolicy::class,
        EightRegister::class => EightRegisterPolicy::class,
        KhasLandKhotian::class => KhasLandKhotianPolicy::class,
        FileType::class => FileTypePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
