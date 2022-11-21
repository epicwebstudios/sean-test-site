<?php

class Share{

    private function share_settings(){

        $stmt = "SELECT * FROM `m_news_settings` WHERE `id` = 1";
        $exec = mysql_query($stmt);

        if($exec){
            return toArray($exec);
        }
        return false;

    }

    public function view_share_button($link){
        global $settings;
        $sett = $this->share_settings();
        $share_options = $sett['share_options'];

        if( !empty($share_options) ){

            $share_options = explode(',',$share_options);
            $link_attributes = "width=700, height=700, left=24, top=24, scrollbars, resizable";

            echo "<div class='share-box'>";
            echo "<ul>";
            foreach ($share_options as $option){
                echo "<li>";

                //facebook
                if( $option == 1 ){
                    $fb_link = "https://www.facebook.com/sharer/sharer.php?u=".$link;
                    $title = "Share on Facebook";
                    echo "<a href='".$fb_link."' class='share share-icon share-facebook'
                             onclick='window.open(this.href,\"".$title."\",\"".$link_attributes."\"); return false;'><i class='fa fa-facebook'></i></a>";
                }

                //twitter
                if( $option == 2 ){
                    $tw_link = "https://twitter.com/intent/tweet?url=".$link;
                    $title = "Share on Twitter";
                    echo "<a href='".$tw_link."' class='share share-icon share-twitter'
                             onclick='window.open(this.href,\"".$title."\",\"".$link_attributes."\"); return false;'><i class='fa fa-twitter'></i></a>";
                }

                //linkedin
                if( $option == 3 ){
                    $li_link = "https://www.linkedin.com/shareArticle?mini=true&url=".$link;
                    $title = "Share on LinkedIn";
                    echo "<a href='".$li_link."' class='share share-icon share-linkedin'
                             onclick='window.open(this.href,\"".$title."\",\"".$link_attributes."\"); return false;'><i class='fa fa-linkedin'></i></a>";
                }

                //reddit
                if( $option == 4 ){
                    $title = "Share on Reddit";
                    $tw_link = "http://reddit.com/submit?url=".$link."&title=".$title;
                    echo "<a href='".$tw_link."' class='share share-icon share-twitter'
                             onclick='window.open(this.href,\"".$title."\",\"".$link_attributes."\"); return false;'><i class='fa fa-reddit'></i></a>";
                }

                //pinterest
                if( $option == 5 ){
                    $p_link = "https://pinterest.com/pin/create/button/?url=".$link;
                    $title = "Share on Pinterest";
                    echo "<a href='".$p_link."' class='share share-icon share-pinterest'
                             onclick='window.open(this.href,\"".$title."\",\"".$link_attributes."\"); return false;'><i class='fa fa-pinterest'></i></a>";
                }

                //email
                if( $option == 6 ){
                    $email_link = "https://twitter.com/intent/tweet?url=".$link;
                    echo "<a href='mailto:exampl@mail.com?subject=".$settings['title']."&body=".$email_link."' class='share share-icon share-email'><i class='fa fa-envelope-o'></i></a>";
                }

                echo "</li>";
            }
            echo "</ul>";
            echo "</div>";

        }

    }
}