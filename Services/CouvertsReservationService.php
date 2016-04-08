<?php

class CouvertsReservationService {
    private $_baseUrl = CouvertsConstants::API_BASE_URL;
    private $_apiKey = CouvertsConstants::API_KEY;

    private $_restaurantId;
    private $_language;

    public function __construct($restaurantId, $language ='Dutch') {
        $this->_restaurantId=$restaurantId;
        $this->_language=$language;
    }

    public function GetBasicInfo() {
        $url = sprintf('%s/BasicInfo', $this->_baseUrl);

        return $this->_getJsonResponse($url, $this->_getGetStreamContext());
    }

    public function GetAvailableTimes(DateTime $date, $numPersons) {
        $url = sprintf('%s/AvailableTimes?numPersons=%d&year=%d&month=%d&day=%d', $this->_baseUrl, $numPersons, $date->format("Y"), $date->format("m"), $date->format("d"));
        $response = $this->_getJsonResponse($url, $this->_getGetStreamContext( true ));

        if ($response->NoTimesAvailable) {
            throw new Exception( $response->NoTimesAvailable->Reason .": ". $response->NoTimesAvailable->Message->{$this->_language} );
        }

        return $response;
    }

    public function GetInputFields(DateTime $dateTime) {
        $url = sprintf('%s/InputFields?year=%d&month=%d&day=%d&hours=%d&minutes=%d', $this->_baseUrl, $dateTime->format("Y"), $dateTime->format("m"), $dateTime->format("d"), $dateTime->format("H"), $dateTime->format("i"));
        $response = $this->_getJsonResponse($url, $this->_getGetStreamContext( true ));

        return $response;
    }


    public function MakeReservation($reservation) {
        $_reservation = $this->_mapReservationData($reservation);

        $url = sprintf('%s/Reservation', $this->_baseUrl);
        $response = $this->_getJsonResponse($url, $this->_getPostStreamContext($_reservation));

        return array($_reservation, $response);
    }

    private function _mapDate($date) {
        return array(
            'Year'  => $date->format("Y"),
            'Month' => $date->format("m"),
            'Day'   => $date->format("d")
        );
    }


    private function _mapReservationData($reservation) {
        $dateTime = DateTime::createFromFormat('Y-m-d H:i', $reservation['DateTime']);

        $_reservation = $reservation;
        unset($_reservation['DateTime']);

        $_reservation['Date'] = $this->_mapDate($dateTime);

        $_reservation['Time'] = array(
            'Hours'   => $dateTime->format("H"),
            'Minutes' => $dateTime->format("i")
        );

        if(!empty($reservation['BirthDate'])) {
            $dob = DateTime::createFromFormat("Y-m-d", $reservation['BirthDate']);
            $_reservation['BirthDate'] = $this->_mapDate($dob);
        }

        return $_reservation;
    }

    /**
     * @param array $content
     * @return stream context
     */
    private function _getPostStreamContext($content) {
        $opts = array(
            'http'=>array(
                'method'=>"POST",
                'header'=>array(
                    "Authorization: Basic ". base64_encode( $this->_restaurantId.":".$this->_apiKey ),
                    "Content-Type: application/json"
                ),
                'content'=>json_encode($content),
                'ignore_errors'=>true
            )
        );

        return  stream_context_create( $opts );
    }

    /**
     * @param bool|false $ignoreErrors
     * @return stream context
     */
    private function _getGetStreamContext($ignoreErrors =false) {
        $opts = array(
            'http'=>array(
                'method'=>"GET",
                'header'=>array(
                    "Authorization: Basic ". base64_encode( $this->_restaurantId.":".$this->_apiKey )
                ),
                'ignore_errors'=>$ignoreErrors
            )
        );

        return stream_context_create( $opts );
    }

    private function _getJsonResponse($url, $context) {
        $response = json_decode( file_get_contents( $url, null, $context ) );

        // For details about the predefined variable $http_response_header see:
        // http://php.net/manual/en/reserved.variables.httpresponseheader.php
        if ($http_response_header[0] == 'HTTP/1.1 404 Not Found') {
            //TODO verschillende types exception gooien?
            throw new Exception( $response->Message );
        }
        elseif ($http_response_header[0] == 'HTTP/1.1 400 Bad Request') {
            throw new Exception( $response->Message .": ". (isset($response->MessageDetail) ? $response->MessageDetail : "") );
        }

        return $response;
    }
}
