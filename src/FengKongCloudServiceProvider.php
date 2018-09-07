<?php

/*
 * This file is part of the sh single purpose prepaid card sdk package.
 *
 * (c) liugj <liugj@boqii.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Bqrd\IShuMei;

use Illuminate\Support\ServiceProvider;

class PrepaidCardServiceProvider extends ServiceProvider
{
    /**
     * defer.
     *
     * @var mixed
     */
    protected $defer = true;

    /**
     * register.
     *
     *
     *
     * @return mixed
     */
    public function register()
    {
        $this->app->singleton(PrepaidCard::class, function ($app) {
            $app->configure('sh-single-purpose-prepaid-card-sdk');
            $config = $app->make('config')->get('sh-single-purpose-prepaid-card-sdk');

            return new PrepaidCard($config);
        });
    }

    /**
     * provides.
     *
     *
     *
     * @return mixed
     */
    public function provides()
    {
        return [PrepaidCard::class];
    }
}
