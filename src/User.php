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
class User extends Factory
{
    public function __construct($accessToken, $format, $scope)
    {
        $this->accessToken = $accessToken;
        $this->format      = $format;
        $this->scope       = $scope;
    }

    /**
     * Get User's Basic info
     *
     * @param string $access_token  The request's Access Token
     * @param string $scope         The request's scope
     * @param string $format        The response type
     * @return json
     */
    public function getProfile()
    {
        // set scope and format
        $scope       = $this->scope;
        $format      = $this->format;
        $accessToken = $this->accessToken;

        // Check if the access token is not empty
        if(! empty($accessToken)){
            $url = self::LINKED_API . '/~:(' . $scope . ')?format=' . $format;

            // If not empty, build settings
            $settings = array(
                'url'         => $url,
                'http_header' => $accessToken,
                'post_data'   => ''
            );

            //send request
            $response = $this->sendRequest($settings);
            
            // return response
            return $response;
        }else{
            throw new Exception("Cannot Process your request");
        }
    }
}