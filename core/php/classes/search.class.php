<?php


class Search{

    private $table;
    private $count = 0;
    private $view;
    public $keyword;


    function __construct($keyword)
    {
        $this->keyword = $keyword;
        $this->table = "m_search_table";
    }

    public function do_search(){

        if( empty( $this->table ) ){
            echo "Improper Configuration. Cannot perform search";
            exit();
        }else{
            if( strlen( $this->keyword ) > 3 )
                $this->do_fulltext_search();
            else
                $this->do_keyword_search();
        }
    }

    private function do_fulltext_search(){

        // $stmt = "SELECT * FROM `".$this->table."`
        //             WHERE MATCH (content)
        //                 AGAINST ('".$this->keyword."' 
        //                     IN BOOLEAN MODE)";
        
        $stmt = "SELECT * FROM `".$this->table."` 
                    WHERE `content` 
                        LIKE '%".$this->keyword."%' 
                            AND `status` = 1";

        $result = $this->execute( $stmt );
        $this->set_search_result($result);

    }

    private function do_keyword_search(){

        $stmt = "SELECT * FROM `".$this->table."` 
                    WHERE `content` 
                        LIKE '%".$this->keyword."%' 
                            AND `status` = 1";

        $result = $this->execute( $stmt );
        $this->set_search_result($result);
    }

    public function set_search_result( $result ){
        $this->view_search_count($this->getCount($result));
        if( !empty($result) ){
            foreach( $result as $info ){
                $permalink = returnURL()."/".$info['link'];
                echo "<div class='search_box'>";
                    echo "<h5 class='title'>
                                <a href='".$permalink."'>".$this->word_highlight($permalink, $this->keyword)."</a>
                                 <p class='desc'>".summary( $this->word_highlight($info['content'],$this->keyword), 400)."</p>
                          </h5>";
                echo "</div>";
            }
        }

    }

    public function view_search_count($count){

        if( $count > 0 ){
            echo "<div class=\"p_b\">".$count."&nbsp;Search Result(s) found for <b>\"".$this->keyword."\"</b></div>";
        }else{
            echo "Empty Result";
        }

    }


    public static function search_styles(){
        echo "<style>
                .search_box { width: auto; display: block; margin-bottom: 10px; }
                .search_box .desc { margin: 0; font-size: 16px; font-weight: normal; }
                .search_box .title { margin: 0; }
                .search_box .title a { font-size: 18px; font-weight: bold; }
                .search_box .link { display: block; width: auto; height: auto; color:#263B80; font-weight: bold;  }
            </style>";
    }

    public function getCount($array){
        return sizeof($array);
    }

    private function word_highlight($text, $words) {
        preg_match_all('~\w+~', $words, $m);
        if(!$m)
            return $text;
        $re = '~\\b(' . implode('|', $m[0]) . ')\\b~i';
        return preg_replace($re, '<b class="highlight">$0</b>', $text);
    }

    private function execute($query){
        $exec = mysql_query( $query );
        if( !$exec ){
            return mysql_error();
        }else{
            $arr = array();
            while ($row = mysql_fetch_array($exec)) {
                array_push($arr,$row);
                $this->count += 1;
            }
            return $arr;
        }
    }

}