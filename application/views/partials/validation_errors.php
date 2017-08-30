<?php echo validation_errors('<div data-alert class="alert alert-danger">', '</div>') ?>

<?php if ($this->session->flashdata('success')) { ?>
    <div data-alert class='alert alert-success'>
        <?php echo $this->session->flashdata('success') ?>
    </div>
<?php }

if ($this->session->flashdata('warning')) { ?>
    <div data-alert class='alert alert-warning'>
        <?php echo $this->session->flashdata('warning') ?>
    </div>
<?php }

if ($this->session->flashdata('error')) { ?>
    <div data-alert class='alert alert-danger'>
        <?php echo $this->session->flashdata('error') ?>
    </div>
<?php }

if (isset($error)) {
    echo $error;
} ?>

<div id="mensajeSuccess" style="display: none;" data-alert class="alert alert-success"></div>
<div id="mensajeWarning" style="display: none;" data-alert class="alert alert-warning"></div>
<div id="mensajeError" style="display: none;" data-alert class="alert alert-danger"></div>
