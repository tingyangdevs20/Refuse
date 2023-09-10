<?php

if (!function_exists('getUniqueFileName')) {
    /**
     * get unique file name by length
     *
     * @param int $length
     * @return string
     * @author Bhavesh Vyas
     */
    function getUniqueFileName(int $length = 24): string
    {
        return substr(sha1(microtime()), 0, $length);
    }
}

if (!function_exists('generateRandomString')) {
    /**
     * generate the random string
     *
     * @param int $length
     * @return string
     * @author Bhavesh Vyas
     */
    function generateRandomString(int $length = 15): string
    {
        $characters       = '0123456789@#&!abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString     = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}

if (!function_exists('makeDir')) {
    /**
     * make new directory for us
     *
     * @param string $path
     * @param bool $isPermission
     * @return bool
     * @author Bhavesh Vyas
     */
    function makeDir(string $path, bool $isPermission = false): bool
    {
        if (!file_exists($path)) {
            mkdir($path, 0775, true);
            if ($isPermission) {
                chmod($path, 0775);
            }
        }

        return true;
    }
}

if (!function_exists('removeFile')) {
    /**
     * remove file from givan path
     *
     * @param string $path
     * @return bool
     * @author Bhavesh Vyas
     */
    function removeFile(string $path): bool
    {
        if (file_exists($path)) {
            return unlink($path);
        }
    }
}

if (!function_exists('runCURL')) {
    /**
     * call cURL for givan url
     *
     * @param string $url
     * @return bool
     * @author Bhavesh Vyas
     */
    function runCURL(string $url): bool
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_USERAGENT, 'api');
        curl_setopt($curl, CURLOPT_TIMEOUT, 1);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, false);
        curl_setopt($curl, CURLOPT_FORBID_REUSE, true);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 1);
        curl_setopt($curl, CURLOPT_DNS_CACHE_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_FRESH_CONNECT, true);
        curl_exec($curl);
        curl_close($curl);
        return true;
    }
}

if (!function_exists('getIPAddress')) {
    /**
     * get user ip address
     *
     * @return string
     * @author Bhavesh Vyas
     */
    function getIPAddress(): string
    {
        foreach (['HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR'] as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    $ip = trim($ip); // just to be safe
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                        return $ip;
                    }
                }
            }
        }
        return request()->ip(); // it will return server ip when no client ip found
    }
}
