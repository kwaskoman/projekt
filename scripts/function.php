<?php



function countDay($create_user){


$data1 = $create_user;
$y1 = substr($data1, 0,4);
$m1 = substr($data1, 5,2);
$d1 = substr($data1, 8,2);
//echo $y1, '-', $m1, '-', $d1;
$create_user1 = "$y1-$m1-$d1";

$data2 =  getdate();

$y2 = $data2['year'];
$m2 = $data2['mon'];
$d2 = $data2['mday'];
//echo $y2, '-', $m2, '-', $d2;

$date1 = strtotime($data1);
    //cho $x1;
$date2 = time();

$date = $date2 - $date1;
$date = abs($date);
$date = intval($date / (60*60*24));
//echo $date;
$yesterday = date('Y-m-d', strtotime("-1 day"));
//echo $dzien;
if ($date == 0) {
  return "Dzisiaj";

}else if($date > 365){
  return '> rok temu';

}else if($date > 30 && $date < 365){
  return '> miesiąc temu';

}else if($yesterday == $create_user1){
  return 'Wczoraj';
}else{
  return "<2 - 30> dni";
}
}

 ?>
