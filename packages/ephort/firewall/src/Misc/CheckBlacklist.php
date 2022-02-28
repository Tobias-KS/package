<?php

namespace Ephort\Firewall\Misc;

use Ephort\Firewall\CRUD\Read;
use Illuminate\Support\Facades\Cache;

class CheckBlacklist
{
    function CheckBlacklist($ip)
    {

        $ip = explode(".", $ip);
        $read = new Read;
        if (!Cache::has('blacklist')) {
            $blacklist = $read->getBlacklist();
            Cache::put('blacklist', $blacklist, now()->addMinutes(360));

        } else {
            $blacklist = Cache::get('blacklist');
        }

        foreach ($blacklist as $octet1 => $key) {
            if ($octet1 == $ip[0]) {

                foreach ($blacklist[$ip[0]] as $octet2 => $key1) {
                    if ($octet2 == $ip[1]) {

                        foreach ($blacklist[$ip[0]][$ip[1]] as $octet3 => $key2) {
                            if ($octet3 == $ip[2]) {

                                foreach ($blacklist[$ip[0]][$ip[1]][$ip[2]] as $octet4 => $key3) {
                                    if ($octet4 == $ip[3]) {
                                        return true;
                                    } else {
                                        return false;
                                    }
                                }
                            } else {
                                return false;
                            }
                        }
                    } else {
                        return false;
                    }
                }
            } else {
                return false;
            }
        }
    }
}
