<?php
include_once '../models/masterdata.php';
include_once '../inc/functions.php';
?>
<table cellspacing="0" width="50%" class="list-data">
<thead>
<tr class="italic">
    <th width="5%">No.</th>
    <th width="70%">Nama farmakoterapi</th>
    <th width="4%">#</th>
</tr>
</thead>
<tbody>
    <?php 
    $limit = 10;
    $page  = $_GET['page'];
    if ($_GET['page'] === '') {
        $page = 1;
        $offset = 0;
    } else {
        $offset = ($page-1)*$limit;
    }
    
    $param = array(
        'id' => $_GET['id_farmakoterapi'],
        'limit' => $limit,
        'start' => $offset,
        'search' => $_GET['search']
    );
    $data_list = load_data_farmakoterapi($param);
    $list_data = $data_list['data'];
    $total_data= $data_list['total'];
    foreach ($list_data as $key => $data) { 
        $str = $data->id.'#'.$data->nama;
        ?>
    <tr class="<?= ($key%2==0)?'even':'odd' ?>">
        <td align="center"><?= (++$key+$offset) ?></td>
        <td><?= $data->nama ?></td>
        <td class='aksi' align='center'>
            <a class='edition' onclick="edit_farmakoterapi('<?= $str ?>');" title="Klik untuk edit">&nbsp;</a>
            <a class='deletion' onclick="delete_farmakoterapi('<?= $data->id ?>','<?= $page ?>');" title="Klik untuk hapus">&nbsp;</a>
        </td>
    </tr>
    <?php } ?>
</tbody>
</table>
<?= paging_ajax($total_data, $limit, $page, '1', $_GET['search']) ?>