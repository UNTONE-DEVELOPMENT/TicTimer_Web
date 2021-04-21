<?php
if($type = "dev"){
    $key = "DVxhYXrK8nFJrJxjju4D6E4eKTSHKTDcpKnPUYYwZP2HEWrKPKA8PDkZFVsRzRWV";
}else if($type == "prod"){
    include("prod_key.php");
}