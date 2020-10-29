<?php

namespace Imlooke\Installer\Middleware;

use Closure;

/**
 * CanInstall
 *
 * @package imlooke\installer
 * @author lwx12525 <lwx12525@qq.com>
 */
class CanInstall
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\RedirectResponse|mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->alreadyInstalled()) {
            abort(404);
        }

        return $next($request);
    }

    /**
     * If application is already installed.
     *
     * @return bool
     */
    public function alreadyInstalled()
    {
        return file_exists(config('installer.installed_file_path'));
    }
}
