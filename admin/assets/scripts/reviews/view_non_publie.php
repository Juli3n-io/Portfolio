<?php
require_once __DIR__ . '/../../config/bootstrap_admin.php';
require_once __DIR__ . '/../../functions/reviews_functions.php';

$record_per_page = 5;
$page = '';
$result['resultat'] = '';

if (isset($_POST['page'])) {

  $page = $_POST['page'];
} else {

  $page = 1;
}

$start_from = ($page - 1) * $record_per_page;

$query = $pdo->query("SELECT * FROM reviews WHERE est_publie = 0 ORDER BY date_enregistrement ASC LIMIT $start_from,$record_per_page");

$result['resultat'] .= '
            <table>
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Nom</th>
                  <th>Company</th>
                  <th>Notes</th>';
if ($Membre['statut'] == 0) {
  $result['resultat'] .= '<th>Publié</th>';
  $result['resultat'] .= '<th>Actions</th>';
} else {
  $result['resultat'] .= '<th>Action</th>';
}
$result['resultat'] .=    '</tr>
              </thead>';

$result['resultat'] .= '<tbody >';

while ($row = $query->fetch()) {

  $result['resultat'] .= '
              <tr>
                <td>' . $row['id'] . '</td>
                <td>' . $row['name'] . '</td>
                <td>' . $row['company'] . '</td>
                <td>' . stars($row['note']) . '</td>';

  if ($Membre['statut'] == 0) {
    if ($row['est_publie']) {
      $result['resultat'] .= '<td> <input type="checkbox" id="est_publie" name="est_publie" class="est_publie" value=' . $row['est_publie'] . ' checked></td>';
    } else {
      $result['resultat'] .= '<td> <input type="checkbox" id="est_publie" name="est_publie" class="est_publie" value=' . $row['est_publie'] . '></td>';
    }

    $result['resultat']  .= '<td class="member_action">';
    $result['resultat']  .= '<a href=' . $row['url'] . ' class="linkbtn"></a>';
    $result['resultat']  .= '<input type="button" class="viewbtn" name="view" id="' . $row['id'] . '"></input>';
    $result['resultat']  .= '<input type="button" class="editbtn" id="' . $row['id'] . '"></input>';
    $result['resultat']  .= '<input type="button" class="deletebtn"></input>';
    $result['resultat']  .= '</td>';
  } else {

    $result['resultat']  .= '<td class="member_action">';
    $result['resultat']  .= '<a href=' . $row['url'] . ' class="linkbtn"></a>';
    $result['resultat']  .= '</td>';
  }

  $result['resultat'] .= '</tr>';
}

$result['resultat'] .= '</tbody >';

$result['resultat'] .= '</table><br /><div  class="custom_pagination">';

$page_query = $pdo->query('SELECT * FROM reviews WHERE est_publie = 0 ORDER BY date_enregistrement ASC ');
$total_records = $page_query->rowCount();
$total_pages = ceil($total_records / $record_per_page);

for ($i = 1; $i <= $total_pages; $i++) {

  if ($i == $page) {

    $result['resultat'] .= '<span 
              class="pagination_link active" id="' . $i . '">' . $i . '</span>';
  } else {

    $result['resultat'] .= '<span 
              class="pagination_link" id="' . $i . '">' . $i . '</span>';
  }

  // $output .= '<span 
  //             class="pagination_link" 
  //             style="cursor:pointer; padding:6px;border: 1px solid #CCC;"
  //             id="'.$i.'">'.$i.'</span>';
}

// Return result 
echo json_encode($result);
