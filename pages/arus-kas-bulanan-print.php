<?php
include_once '../models/transaksi.php';
include_once '../inc/functions.php';
?>
<link rel="stylesheet" href="../themes/theme_default/theme-print.css" />
<script type="text/javascript">
function cetak() {  		
    window.print();
    setTimeout(function(){ window.close();},300);
}
</script>
<body onload="cetak();">
<?= header_surat(); ?>
<h1>
    LAPORAN ARUS STOK BULANAN <br /> BULAN <?= tampil_nama_bulan($_GET['bulan']) ?>
</h1>
<table cellspacing="0" width="100%" class="list-data-print">
<thead>
    <tr class="italic">
        <th width="2%">No.</th>
        <th width="10%">Transaksi</th>
        <th width="10%">Masuk</th>
        <th width="10%">Keluar</th>
        <th width="10%">Sisa</th>
    </tr>
</thead>
<tbody>
    <?php
    $param = array(
        'bulan' => $_GET['bulan'],
        'transaksi' => $_GET['jenis_transaksi']
    );
    $arus_kas = arus_kas_bulanan_load_data($param);
    $list_data = $arus_kas['data'];
    //$total_data= $penerimaan['total'];
    $total_masuk=0;
    $total_keluar = 0;
    foreach ($list_data as $key => $data) { 
        $awal = mysql_fetch_object(mysql_query("select sum(masuk)-sum(keluar) as awal from arus_kas where waktu < '".$_GET['bulan']."-01'"));
        $sisa = mysql_fetch_object(mysql_query("select sum(masuk)-sum(keluar) as sisa from arus_kas where waktu <= '".$_GET['bulan']."-31'"));
        ?>
        <tr class="<?= ($key%2==0)?'even':'odd' ?>">
            <td align="center"><?= (++$key) ?></td>
            <td><?= $data->transaksi ?></td>
            <td align="right"><?= rupiah($data->masuk) ?></td>
            <td align="right"><?= rupiah($data->keluar) ?></td>
            <td align="right"></td>
            
        </tr>
    <?php 
    $total_masuk = $total_masuk+$data->masuk;
    $total_keluar= $total_keluar+$data->keluar;
    }
    ?>
</tbody>
<tfoot>
    <tr>
        <td colspan="2" align="right"><b>TOTAL</b></td>
        <td align="right"><b><?= rupiah($total_masuk) ?></b></td>
        <td align="right"><b><?= rupiah($total_keluar) ?></b></td>
        <td align="right"><b><?= rupiah($total_masuk-$total_keluar) ?></b></td>
    </tr>
</tfoot>
</table>
</body>