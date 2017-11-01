<?php

namespace Redscript\LinkedIn;

class User extends Base
{
	/**
     * Get User's Basic info
     *
     * @param string $access_token  The request's Access Token
     * @param string $scope         The request's scope
     * @param string $format        The response type
     * @return json
     */
    public function _getUserInfo($access_token, $scope, $format)
    {       
        // Check if the access token is not empty
        if(! empty($access_token)){
            $url = self::LINKED_API . '/~:(' . $scope . ')?format=' . $format;

            // If not empty, build settings
            $settings = array(
                'url'         => $url,
                'http_header' => $access_token,
                'post_data'   => ''
            );

            //send request
            $response = Factory::sendRequest($settings);

            // return response
            return $response;
        }else{
            return null;
        }
    }
}