<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
$pdo=new PDO('mysql:host=localhost:8889;dbname=howSearch;charset=utf8','root','root');
    $search=$_GET['q'];
    $searche=explode(" ",$search);
    $x=0;
    $construct="";
    $params=array();
    foreach($searche as $term)
    {
        $x++;
        if($x==1)
        {
            $construct.="title LIKE CONCAT('%',:search$x,'%') OR description LIKE CONCAT('%',:search$x,'%') OR keywords LIKE CONCAT('%',:search$x,'%')";
        }
        else
        {
            $construct.=" AND title LIKE CONCAT('%',:search$x,'%') OR description LIKE CONCAT('%',:search$x,'%') OR keywords LIKE CONCAT('%',:search$x,'%')";
        }
        $params[":search$x"]=$term;
    }
    $results=$pdo->prepare("SELECT * FROM `index` WHERE $construct");
    $results->execute($params);
    
    if($results->rowCount()==0)
    {
        echo "0 results found! <hr /> \n";
    }
    else
    {
        echo $results->rowCount()." results found! <hr /> \n";
    }
    echo "<pre>";
    foreach($results->fetchAll() as $result)
    {
        echo '<a href="'.$result["url"].'">'.$result["title"].'<br /></a>';
        echo $result["url"]."<br />";
        if($result["description"]!="")
        {
            echo $result["description"]."<br />";
        }
        echo "<hr />";
    }
    //print_r($results->fetchAll());
?>
