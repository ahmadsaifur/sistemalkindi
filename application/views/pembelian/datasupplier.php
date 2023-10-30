<?php $this->load->view('include/header'); ?>
<?php $this->load->view('include/navbar'); ?>

<style>
    .footer {
        margin-bottom: 22px;
    }

    .panel-primary .form-group {
        margin-bottom: 10px;
    }

    .form-control {
        border-radius: 0px;
        box-shadow: none;
    }

    .error_validasi {
        margin-top: 0px;
    }
</style>

<?php
$level         = $this->session->userdata('ap_level');
$readonly    = '';
$disabled    = '';
if ($level !== 'admin') {
    $readonly    = 'readonly';
    $disabled    = 'disabled';
}
?>


<table class="table">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">First</th>
            <th scope="col">Last</th>
            <th scope="col">Handle</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th scope="row">1</th>
            <td>Mark</td>
            <td>Otto</td>
            <td>@mdo</td>
        </tr>
        <tr>
            <th scope="row">2</th>
            <td>Jacob</td>
            <td>Thornton</td>
            <td>@fat</td>
        </tr>
        <tr>
            <th scope="row">3</th>
            <td colspan="2">Larry the Bird</td>
            <td>@twitter</td>
        </tr>
    </tbody>
</table>