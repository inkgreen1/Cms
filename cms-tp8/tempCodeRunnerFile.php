<?php
function buildTree($array,$pid=0){
    $tree = [];

    foreach ($array as $key => $value) {
        if($value["pid"] == $pid){
            $children = buildTree($array,$value["id"]);
            if(!empty($children)){
                $value["children"] = $children;
            }
            $tree[] = $value;
        }
    }

    return $tree;
}

$arr = [
    [
        "id"=>1,
        "pid"=>0,
        "name"=>"中国"
    ],
    [
        "id"=>2,
        "pid"=>1,
        "name"=>"河南"
    ],
    [
        "id"=>3,
        "pid"=>2,
        "name"=>"郑州"
    ],
    [
        "id"=>4,
        "pid"=>2,
        "name"=>"新乡"
    ]
];

print_r(buildTree($arr));
?>