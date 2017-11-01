<?php

namespace Redscript\Google;
use Redscript\Google\Util;
use Redscript\Google\User;
use Redscript\Google\Oauth;

class Factory extends Base
{
     /**
     * Google Auth
     *
     * @param string $client_id The Client's id
     * @param string $client_secret The Client's secret
     * @param string $redirect_uri The Client's redirect uri
     * @return Oauth class
     */
	public function auth($client_id, $client_secret, $redirect_uri)
	{
		return new Oauth($client_id, $client_secret, $redirect_uri);
	}

     /**
     * Send Curl Request
     *
     * @param  array $settings The request's URL,Post Data and or Http Header
     * @return json
     */
	public function sendRequest($settings)
	{
        $ch = curl_init();      
        curl_setopt($ch, CURLOPT_URL, $settings['url']);        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);        
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        // Check if there are post data to be send
        if(array_key_exists('post_data',$settings) && $settings['post_data'] !== ''){
            // Add the post data in the request     
            curl_setopt($ch, CURLOPT_POSTFIELDS, $settings['post_data']);
            curl_setopt($ch, CURLOPT_POST, 1);      
        }

        // Check if there are http headers to be send
        if(array_key_exists('http_header',$settings) && $settings['http_header'] !== ''){
            // Add the http header in the request
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '. $settings['http_header']));
        }

        // send request then decode the returned json string    
        $response = json_decode(curl_exec($ch), true);

        // get the request's return code
        $http_code = curl_getinfo($ch,CURLINFO_HTTP_CODE);  	

        // close the connection
        curl_close($ch);

        return $response; 
    }
}