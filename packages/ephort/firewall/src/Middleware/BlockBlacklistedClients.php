<?php

namespace Ephort\Firewall\Middleware;

use Closure;
use Ephort\Firewall\CRUD\Read;
use Ephort\Firewall\Misc;
use Ephort\Firewall\Misc\CheckBlacklist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class BlockBlacklistedClients
{
    //Inspired by https://www.positronx.io/how-to-restrict-or-block-user-access-from-ip-address-in-laravel/ (TODO spørg kristian om copyright)
    // Blocked IP addresses (Copied from the internet atm but these should be grabbed from the api)
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //Instantiate classes
        $read = new Read;
        $CheckBlackList = new CheckBlacklist;

        //get data from whitelist
        $whitelist = $read->getWhitelist();

        //Check if the ip is whitelisted. We do this first so we can ignore the blacklist if the ip is whitelisted.
        if (in_array($request->ip(), $whitelist)) {
            return $next($request);
        }

        //Check if the ip is is blacklisted. If the ip is on the blacklist the connection is denied.

        if ($CheckBlackList->CheckBlackList($request->ip())) {
            Cache::put('blocklist', $request->ip());

            return response()->json(['message' => "You are not allowed to access this site. If you believe this is an error please contact the owner(s) of the page"], 401);
        }

        //otherwise allow connection
        return $next($request);
    }
}
