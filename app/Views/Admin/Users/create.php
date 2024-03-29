<?= $this->extend('Admin/layout/main'); ?>

<!-- Aqui enviamos para o template principal o título -->
<?= $this->section('title'); ?>

  <?= $title; ?>

<?= $this->endSection(); ?>


<!-- Aqui enviamos para o template principal os estilos -->
<?= $this->section('styles'); ?>



<?= $this->endSection(); ?>



<!-- Aqui enviamos para o template principal o conteúdo -->
<?= $this->section('content'); ?>

<div class="col-md-8">
  <div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">Create user</h5>
    </div>
    <div class="card-body">

      <?= form_open("admin/users/register"); ?>

        <?= $this->include('Admin/Users/form'); ?>

        <a href="<?= site_url("admin/users"); ?>" class="btn btn-light text-dark btn-sm">
          <i class="bx bx-left-arrow-alt tf-icons"></i>
          Voltar
        </a>

      <?= form_close(); ?>

    </div>
  </div>
</div>

<?= $this->endSection(); ?>


<!-- Aqui enviamos para o template principal os scripts -->
<?= $this->section('scripts'); ?>

<script src="<?= site_url('assets/vendor/mask/jquery.mask.min.js') ?>"></script>
<script src="<?= site_url('assets/vendor/mask/app.js') ?>"></script>

<?= $this->endSection(); ?>