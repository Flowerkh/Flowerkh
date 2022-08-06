<?
$query_arr = array(
    'test1' => $test1,
    'test2' => $test2,
    ...
);
$sql = "INSERT INTO <table> SET " . change_query_string($query_arr);
$sql = "UPDATE <table> SET ".change_query_string($query_arr). " WHERE ...";

function change_query_string($arr)
{
    $field_vals = array();
    foreach($arr as $field => $value) $field_vals[] = ($value===NULL) ? "$field=NULL" : "$field='".$value."'";
    return @join(', ', $field_vals);
}

?>
