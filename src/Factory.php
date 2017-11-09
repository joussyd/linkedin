<?php
/**
 * This file is part of the Compos Mentis Inc.
 * PHP version 7+ (c) 2017 CMI
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 *
 * @category Class
 * @package  Class
 * @author   Joussyd Calupig <joussydmcalupig@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://joussydmcalupig.com
 */
namespace Redscript\LinkedIn;
use Redscript\LinkedIn\User;
use Redscript\LinkedIn\Auth;

/**
 * Base Class
 *
 * PHP version 7+
 *
 * @category Class
 * @author   Joussyd Calupig <joussydmcalupig@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://joussydmcalupig.com
 */
class Factory extends Base
{
    /* Constants
    -------------------------------*/
    const HOST                  = 'https://www.linkedin.com';
    const LINKED_API            = 'https://api.linkedin.com/v1/people';
    const OAUTH_URL             = '/uas/oauth2';
    const AUTH                  = '/authorization';
    const ACCESS_TOKEN          = '/accessToken';
    const RESPONSE_TYPE         = 'code';
    const STATE                 = 'CSRF';
    const GRANT                 = 'authorization_code';

    /* Public Properties
    -------------------------------*/
    /* Protected Properties
    -------------------------------*/
    protected $clientId;
    protected $clientSecret;
    protected $redirectUri;
    protected $scope;
    protected $format;
    
     /**
     * LinkedIn Auth
     *
     * @param string $clientId     The Client's id
     * @param string $clientSecret The Client's secret
     * @param string $redirectUri  The Client's redirect uri
     * @param string $scope         The request's scope
     * @param string $format        The response type
     * @return Oauth class
     */
    public function auth($clientId, $clientSecret, $redirectUri, $scope, $format)
    {
        return new Auth($clientId, $clientSecret, $redirectUri, $scope, $format);
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

    /**
     * Get the User's Info
     *
     *
     * @return array
     */
    public function user($accessToken, $format, $scope)
    {
        return new User($accessToken, $format, $scope);
    }
}