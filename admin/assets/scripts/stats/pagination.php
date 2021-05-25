<?php
require_once __DIR__ . '/../../config/bootstrap_admin.php';

$record_per_page = 5;
$page = '';
$output = '';

if(isset($_POST['page'])){

  $page = $_POST['page'];

}else{

  $page = 1;

}

$start_from = ($page - 1) * $record_per_page;

$query = $pdo->query ("SELECT * FROM visites ORDER BY id DESC LIMIT $start_from,$record_per_page");

$output .= '
            <table>
              <thead>
                <tr>
                  <th>date</th>
                  <th>Visites</th>
              </tr>
              </thead>';

$output .= '<tbody >';

while($row = $query->fetch()){

  $date = str_replace('/', '-', $row['date']);

  $output .= '
              <tr>
                <td>'.date('d-m-Y', strtotime($date)).'</td>
                <td>'.$row['nb_visites'].'</td>
              </tr>';
}

$output .= '</tbody >';

$output .= '</table><br /><div  class="custom_pagination">';

$page_query = $pdo->query('SELECT * FROM visites ORDER BY id DESC');
$total_records = $page_query->rowCount();
$total_pages = ceil($total_records / $record_per_page);

for($i = 1;$i<=$total_pages; $i++){

  if($i == $page){

    $output .= '<span 
              class="pagination_link active" id="'.$i.'">'.$i.'</span>';
    
  }else{

    $output .= '<span 
              class="pagination_link" id="'.$i.'">'.$i.'</span>';
     
  }

  // $output .= '<span 
  //             class="pagination_link" 
  //             style="cursor:pointer; padding:6px;border: 1px solid #CCC;"
  //             id="'.$i.'">'.$i.'</span>';
}

echo $output;

?>