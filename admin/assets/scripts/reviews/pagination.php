<?php
require_once __DIR__ . '/../../config/bootstrap_admin.php';
require_once __DIR__ . '/../../functions/reviews_functions.php';

$record_per_page = 5;
$page = '';
$output = '';

if (isset($_POST['page'])) {

  $page = $_POST['page'];
} else {

  $page = 1;
}

$start_from = ($page - 1) * $record_per_page;

$query = $pdo->query("SELECT * FROM reviews ORDER BY date_enregistrement ASC LIMIT $start_from,$record_per_page");

$output .= '
            <table>
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Nom</th>
                  <th>Company</th>
                  <th>Notes</th>';
if ($Membre['statut'] == 0) {
  $output .= '<th>Publié</th>';
  $output .= '<th>Actions</th>';
} else {
  $output .= '<th>Action</th>';
}
$output .=    '</tr>
              </thead>';

$output .= '<tbody >';

while ($row = $query->fetch()) {

  $output .= '
              <tr>
                <td>' . $row['id'] . '</td>
                <td>' . $row['name'] . '</td>
                <td>' . $row['company'] . '</td>
                <td>' . stars($row['note']) . '</td>';

  if ($Membre['statut'] == 0) {
    if ($row['est_publie']) {
      $output .= '<td> <input type="checkbox" id="est_publie" name="est_publie" class="est_publie" value=' . $row['est_publie'] . ' checked></td>';
    } else {
      $output .= '<td> <input type="checkbox" id="est_publie" name="est_publie" class="est_publie" value=' . $row['est_publie'] . '></td>';
    }

    $output  .= '<td class="member_action">';
    $output  .= '<a href=' . $row['url'] . ' class="linkbtn"></a>';
    $output  .= '<input type="button" class="viewbtn" name="view" id="' . $row['id'] . '"></input>';
    $output  .= '<input type="button" class="editbtn" id="' . $row['id'] . '"></input>';
    $output  .= '<input type="button" class="deletebtn"></input>';
    $output  .= '</td>';
  } else {

    $output  .= '<td class="member_action">';
    $output  .= '<a href=' . $row['url'] . ' class="linkbtn"></a>';
    $output  .= '</td>';
  }

  $output .= '</tr>';
}

$output .= '</tbody >';

$output .= '</table><br /><div  class="custom_pagination">';

$page_query = $pdo->query('SELECT * FROM reviews ORDER BY date_enregistrement DESC');
$total_records = $page_query->rowCount();
$total_pages = ceil($total_records / $record_per_page);

for ($i = 1; $i <= $total_pages; $i++) {

  if ($i == $page) {

    $output .= '<span 
              class="pagination_link active" id="' . $i . '">' . $i . '</span>';
  } else {

    $output .= '<span 
              class="pagination_link" id="' . $i . '">' . $i . '</span>';
  }

  // $output .= '<span 
  //             class="pagination_link" 
  //             style="cursor:pointer; padding:6px;border: 1px solid #CCC;"
  //             id="'.$i.'">'.$i.'</span>';
}

echo $output;
