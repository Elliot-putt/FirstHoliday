<?php

namespace App\Http\Middleware;

use App\Models\Backup;
use App\Models\Booking;
use App\Models\Company;
use App\Models\Log;
use App\Models\Role;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware {

    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param \Illuminate\Http\Request $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'auth' => [
                'user' => [
                    'username' => function() {
                        if(auth()->user() != null)
                        {
                            return auth()->user()->name ?? 'Friend';
                        } else
                        {
                            return 'User';
                        }
                    },
                    'email' => function() {
                        if(auth()->user() != null)
                        {
                            return auth()->user()->email ?? '';
                        } else
                        {
                            return '';
                        }
                    },
                    'id' => function() {
                        if(auth()->user() != null)
                        {
                            return auth()->user()->id ?? '';
                        } else
                        {
                            return '';
                        }
                    },
                    'photo' => function() {
                        if(auth()->user() != null)
                        {
                            return auth()->user()->photo() ?? '';
                        }
                    },
                ],
            ],
        ]);
    }

}
