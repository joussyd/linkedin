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
class Auth extends Factory
{
    /* Public Properties
    -------------------------------*/
    /* Protected Properties
    -------------------------------*/
    /* Private Properties
    -------------------------------*/
    /* Get
    -------------------------------*/
    /* Magic
    -------------------------------*/
    /* Public Methods
    -------------------------------*/

    /**
     * 
     * @param string $client_id      The Client id
     * @param string $client_secret  The Client secret
     * @param string $redirect_uri   The Client redirect Uri
     * @param string $scope          The request's scope
     * @param string $format         The response format
     * @return string
     */
    public function __construct($clientId, $clientSecret, $redirectUri, $scope, $format)
    {
        $this->clientId     = $clientId;
        $this->clientSecret = $clientSecret;
        $this->redirectUri  = $redirectUri;
        $this->scope        = $scope;
        $this->format       = $format;
    }

    /**
     * Generate the LinkedIn Login Url
     *
     *
     * @return string
     */
    public function getLoginURL()
    {

        // build url
        $url = self::HOST . self::OAUTH_URL . self::AUTH . '?';

        // query parameter 
        $params = array(
            'response_type' => self::RESPONSE_TYPE,
            'client_id'     => $this->clientId,
            'redirect_uri'   => $this->redirectUri,
            'state'         => self::STATE
        );

        // build url
        $loginUrl = $url . urldecode(http_build_query($params));

        // return login url
        return $loginUrl;
    }

    /**
     * Get User's access token
     *
     * @param string $code  The LinkedIn authorization code
     * @return string
     */
    public function getAccessToken($code)
    {

        // LinkedIn oauth url
        $url = self::HOST . self::OAUTH_URL . self::ACCESS_TOKEN;

        // query params
        $params = array(
            'client_id' => $this->clientId,
            'redirect_uri' => $this->redirectUri,
            'client_secret' => $this->clientSecret,
            'code'          => $code,
            'grant_type'    => self::GRANT
        );

        // build post data
        $postData = http_build_query($params);
   
        // crete settings
        $settings = array(
            'url'         => $url,
            'post_data'   => $postData,
            'http_header' => ''
        );

        // send request
        $response = Factory::sendRequest($settings);

        // check token
        if(!array_key_exists('access_token', $response)){
            // if token did not exist in the response array
            // throw error
            throw new \Exception("Unable to get access token");
        }
        // return access token
        return $response['access_token'];
    }
}