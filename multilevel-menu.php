<?php

$db_host="localhost";
$db_user="root";
$db_password="";
$db_base="ecom";

$link=mysqli_connect($db_host, $db_user, $db_password, $db_base);

if ($link->connect_errno) {
    echo "Failed to connect to MySQL: " . $link->connect_error;
    exit();
}

$result=mysqli_query($link, "SELECT * FROM categories");
while ($row=mysqli_fetch_array($result)) {
    $data[$row['id']]=$row;
}

function view_cat($dataset)
{

    $arr="";
    foreach ($dataset as $menu) {

        $arr.="<li><a>" . $menu["categories"] . "</a>";

        if (!empty($menu['childs'])) {
            $arr.='<ul>';
            $arr.=view_cat($menu['childs']);
            $arr.='</ul>';
        }
        $arr.='</li>';

    }
    return $arr;
}

function mapTree($dataset)
{

    $tree=array();

    foreach ($dataset as $id=>&$node) {

        if (!$node['parent_id']) {
            $tree[$id]= &$node;
        } else {
            $dataset[$node['parent_id']]['childs'][$id]= &$node;
        }
    }
    return $tree;
}

$data=mapTree($data);

echo "<ul class='tree'>" . view_cat($data) . "</ul>";

?>
