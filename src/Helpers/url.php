<?php

function company_url($company_id, $domain = false)
{
    $domain_name = env('APP_URL');
    $url = '/' . $company_id;
    if ($domain === true) {
        $url = $domain_name . $url;
    }

    return $url;
}

function base_url($url)
{
    return env('APP_URL') . $url;
}

function clean_url($str, $ext = 'view_detail')
{
    $str = strtolower($str);
    $pattern = '/[^a-zA-Z0-9]/i';
    $str = preg_replace($pattern, '_', $str);
    $str = preg_replace('/_{1,}/', '_', $str);

    return $str == '_' ? $ext : $str;
}

function is_unicode($string)
{
    return strlen($string) != strlen(utf8_decode($string));
}
