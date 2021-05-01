<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;

use Illuminate\Http\Request;

class ResourceController extends Controller
{
    public static function apiQuery(Request $request) {
        $base = $request->base;
        $route = $request->route;
        $params = $request->all();
        
        $append_params = '';
        $count = 0;
        foreach ($params as $key => $value) {
            if ($key != 'base' && $key != 'route') {
                if ($count == 0) {
                    $append_params .= '?';
                }
                else {
                    $append_params .= '&';
                }

                $append_params .= $key . '=' . $value;

                $count++;
            }
        }

        $client = new Client(['base_uri' => $base]);
        
        $response = $client->request('GET', $route . $append_params);
        $response = $response->getBody();
        $response = json_decode($response, true);

        return $response;
    }
}
