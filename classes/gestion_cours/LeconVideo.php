<?php
    require_once('ContenuLecon.php');

    class LeconVideo extends ContenuLecon{
        private $video_id;
        private $url_video;
        private $duree;


        public function afficherContenu(){

        }

        public function getVideoId(){
            return $this->video_id;
        }

        public function setVideoId($video_id){
            $this->video_id = $video_id;
        }

        public function getUrlVideo(){
            return $this->url_video;
        }

        public function setUrlVideo($url_video){
            $this->url_video = $url_video;
        }

        public function getDuree(){
            return $this->duree;
        }

        public function setDuree($duree){
            $this->duree = $duree;
        }

    }