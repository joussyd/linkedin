<?php

namespace Redscript\LinkedIn;
use Redscript\LinkedIn\User;

class Oauth extends Base
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
    public function __construct($client_id, $client_secret, $redirect_uri, $scope, $format)
    {

        if (!empty($client_id)) {
            $this->client_id = $client_id;
        }else{
            die('Error: Client id cannot be empty');
        }

        if (!empty($client_secret)) {
            $this->client_secret = $client_secret;
        }else{
            die('Error: Client secret cannot be empty');
        }

        if (!empty($redirect_uri)) {
            $this->redirect_uri = $redirect_uri;    
        }else{
            die('Error: Redirect Uri cannot be empty');
        }

        if (!empty($scope)) {
            $this->scope = $scope;    
        }else{
            die('Error: Scope cannot be empty');
        }

        if (!empty($format)) {
            $this->format = $format;    
        }else{
            die('Error: Format cannot be empty');
        }
    }

    /**
     * Generate the LinkedIn Login Url
     *
     *
     * @return string
     */
    public function getLoginURL()
    {
        // append scope in the LinkedIn's login url
        $login_url = self::LINKEDIN_AUTH 
            . '?response_type=' . self::RESPONSE_TYPE
            . '&client_id='. $this->client_id 
            . '&redirect_uri='. $this->redirect_uri
            . '&state=' . self::STATE;

        // return login url
        return $login_url;
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
        $url = self::LINKEDIN_ACCESS_TOKEN;             
        
        // request for access token
        $post_data = 'client_id=' . $this->client_id 
            . '&redirect_uri=' . $this->redirect_uri 
            . '&client_secret=' .$this->client_secret 
            . '&code='. $code 
            . '&grant_type=authorization_code';

        // crete settings
        $settings = array(
            'url'         => $url,
            'post_data'   => $post_data,
            'http_header' => ''
        );

        // send request
        $response = Factory::sendRequest($settings);
        
        // return access token
        return $response['access_token'];
    }

     /**
     * Get the User's Info
     *
     *
     * @return array
     */
    public function getUserInfo($access_token)
    {
        return User::_getUserInfo($access_token, $this->scope, $this->format);
    }
}