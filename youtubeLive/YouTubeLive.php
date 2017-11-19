<?php

class YouTubeLive {

    private $_apiKey;
    private $_channelId;
    private $_youTubeURL;

    function __construct($channelID, $apiKey) {
        $this->_apiKey = $apiKey;
        $this->_channelId = $channelID;
    }

    private function getYoutubeApiData($eventType) {
        $tmpUrl_1 = 'https://www.googleapis.com/youtube/v3/search?part=snippet&channelId=' . $this->_channelId;
        $tmpUrl_2 = '&type=video&eventType=';
        $tmpUrl_3 = '&key=' . $this->_apiKey;

        switch ($eventType) {
            case 'live':
                $this->_youTubeURL = $tmpUrl_1 . $tmpUrl_2 . 'live' . $tmpUrl_3;
                break;
            case 'upcoming':
                $this->_youTubeURL = $tmpUrl_1 . $tmpUrl_2 . 'upcoming' . $tmpUrl_3;
                break;
            case 'completed':
                $this->_youTubeURL = $tmpUrl_1 . $tmpUrl_2 . 'completed' . $tmpUrl_3;
                break;
            default:
                throw new Exception("Wrong argument funciton! Allow: live|upcoming|completed");
                break;
        }

        return $responseJSON = file_get_contents($this->_youTubeURL);
    }

    private function getDataByEventType($type) {

        if (($type != 'live') && ($type != 'upcoming') && ($type != 'completed')) {
            throw new Exception("Wrong argument funciton! Allow: live|upcoming|completed");
        }

        $responseJSON = $this->getYoutubeApiData($type);

        $responseTab = (array) json_decode($responseJSON);
        $tab = [];
        $i = 0;

        foreach ($responseTab['items'] as $row) {
            $tab[$i]['title'] = $row->snippet->title;
            $tab[$i]['date'] = date("d-m-Y H:i", strtotime($row->snippet->publishedAt));
            $tab[$i]['desc'] = $row->snippet->description;
            $tab[$i]['img'] = $row->snippet->thumbnails->high->url;
            $tab[$i]['channel'] = $row->snippet->channelTitle;
            $tab[$i]['url'] = 'https://www.youtube.com/watch?v=' . $row->id->videoId;
            $i++;
        }
        return $tab;
    }

    private function isUpcommingEvent() {
        $responseJSON = $this->getYoutubeApiData('upcoming');
        $responseTab = (array) json_decode($responseJSON);
        if ($responseTab['pageInfo']->totalResults > 0) {
            return true;
        } else {
            return false;
        }
    }

    private function isLiveOn() {
        $responseJSON = $this->getYoutubeApiData('live');
        $responseTab = (array) json_decode($responseJSON);
        if ($responseTab['pageInfo']->totalResults > 0) {
            return true;
        }
        return false;
    }

    public function getLiveArray() {
        if ($this->isLiveOn()) {
            return $this->getDataByEventType('live');
        } else {
            return array();
        }
    }

    public function getUpcommingEventArray() {
        if ($this->isUpcommingEvent()) {
            return $this->getDataByEventType('upcoming');
        } else {
            return array();
        }
    }

}

?>

