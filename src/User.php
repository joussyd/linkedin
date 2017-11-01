<?php

namespace Redscript\LinkedIn;

class User extends Base
{
	/**
     * Get User's Basic info
     *
     *
     * @return json
     */
    public function _getUserInfo($access_token)
    {       
        // Check if the access token is not empty
        if(! empty($access_token)){
            $url = self::LINKED_API . '/~:(' . $this->scope . ')?format=' . $this->format;
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