<?php


class SearchCron{

    public $config;

    function __construct()
    {
        $this->config = array(
            array(
                'table'     => 'pages',
                'content'   => 'content',
                'link'      => 'link',
                'ref_id'    => 'id',
                'status'    => 'status'
            ),
            array(
                'table'     => 'm_news_entries',
                'content'   => 'entry',
                'link'      => 'permalink',
                'pre_link'  => 'news/',
                'ref_id'    => 'id',
                'status'    => 'status'
            ),
            array(
                'table'     => 'm_videos',
                'content'   => 'description',
                'link'      => 'permalink',
                'pre_link'  => 'videos/',
                'ref_id'    => 'id',
                'status'    => 'status'
            )
        );
        $this->register_search();

    }

    public function start_cron_job(){

        $query = "SELECT * FROM `m_search_table`";
        $count = mysql_num_rows( mysql_query($query) );

        if( $count > 0 ){
            $this->do_periodic_update();
        }else{
            $this->do_first_insert();
        }

    }

    function do_first_insert(){

        foreach ( $this->config as $table ){
            $query = "SELECT * FROM `".$table['table']."`";
            $exec = mysql_query($query);

            if( $exec ){

                while( $info = mysql_fetch_array($exec) ){
                    $this->first_insert_loop($info,$table);
                }

            }else{
                die( 'Invalid Query: '.mysql_error());
            }

        }

    }



    function do_periodic_update( ){

        foreach ( $this->config as $table ){
            $query = "SELECT * FROM `".$table['table']."`";
            $exec = mysql_query($query);
            if( $exec ){
                while( $info = mysql_fetch_array($exec) ){
                    $inn_query = "SELECT * FROM `m_search_table` WHERE `ref_id` = ".$info['id']." AND `ref_type` = '".$table['table']."' LIMIT 1";
                    $inn_exec = mysql_query($inn_query);
                    if(mysql_num_rows($inn_exec) > 0){
                        $this->do_update($info, $table);
                    }else{
                        $this->first_insert_loop($info,$table);
                    }
                }
            }else{
                die( 'Updating the result failed: '.mysql_error());
            }
        }

    }

    function do_destroy($id,$table){

        $query = "DELETE FROM `m_search_table` WHERE `ref_id` = ".$id." AND `ref_type` = '".$table."'";
        $exec = mysql_query($query);
        if(!$exec){
            echo "Cound not delete the query".mysql_error();
            die();
        }

    }

    function do_update($info, $table){

        $data = $info[$table['content']];

        if($info['status'] == 1){

            $content = mysql_escape_string(returnParsedPage($data));
            $link = ( isset( $table['pre_link'] ) )  ? $table['pre_link'].$info[$table['link']] : $info[$table['link']];

            $update_stmt = "UPDATE `m_search_table` 
                                SET `content` = '".$content."',
                                    `link` = '".$link."',
                                    `status` = '".$info[$table['status']]."'
                                        WHERE `ref_type` = '".$table['table']."'
                                            AND `ref_id` = '".$info[$table['ref_id']]."'";

            $execute = mysql_query($update_stmt);
            if( !$execute ){
                die( 'Invalid Update Query: '.mysql_error());
            }

        }else{
            echo "destory the record for ".$info['id']."-".$table['table'];
            $this->do_destroy($info['id'],$table['table']);
        }

    }

    function first_insert_loop($info,$table){

        $data = $info[$table['content']];

        if($info['status'] == 1) {

            $content = mysql_escape_string(returnParsedPage($data));

            $link = (isset($table['pre_link'])) ? $table['pre_link'] . $info[$table['link']] : $info[$table['link']];

            $insert_stmt = "INSERT INTO `m_search_table` 
                                        (   `ref_type`,
                                            `ref_id`,
                                            `content`,
                                            `link`,
                                            `status`) 
                                        VALUES 
                                            (   '" . $table['table'] . "',
                                                '" . $info[$table['ref_id']] . "',
                                                '" . $content . "',
                                                '" . $link . "',
                                                '" . $info[$table['status']] . "'
                                                )";

            $execute = mysql_query($insert_stmt);
            if (!$execute) {
                die('Inserting the result failed: ' . mysql_error());
            }

        }else{
            $this->do_destroy($info['id'],$table);
        }

    }

    function strip_shortcodes($content){
        $search = "/[{](.*)[}]/";
        $replace = "";
        $string = $content;
        return preg_replace($search,$replace,$string);
    }

    private function register_search(){

        $checktable = mysql_query("SHOW TABLES LIKE 'm_search_table'");
        $table_exists = mysql_num_rows($checktable) > 0;
        if( !$table_exists ){
            $this->create_search_table();
        }else{
            $this->start_cron_job();
        }
    }

    private function create_search_table(){

        $stmt = "CREATE TABLE `m_search_table` (
                    id INT(7) AUTO_INCREMENT PRIMARY KEY, 
                    ref_type varchar(64),
                    ref_id int(7),
                    content text,
                    title text,
                    link varchar(64),
                    status tinyint(1))";

        $exec = mysql_query( $stmt );
        if( !$exec ) echo mysql_error();
    }

}

