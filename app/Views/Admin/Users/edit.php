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
    <div class="card-body">
      <h5 class="pb-2 border-bottom mb-4"><?= esc($title); ?></h5>
  
        <?php if (session()->has('errors_model')): ?>
          <ul>
            <?php foreach (session('errors_model') as $error): ?>
              <li class="text-danger"><?= $error ?></li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>

        <?= form_open("admin/users/update/$user->id"); ?>

          <?= $this->include('Admin/Users/form'); ?>

          <a href="<?= site_url("admin/users/show/$user->id"); ?>" class="btn btn-sm btn-light text-dark">
            <i class="bx bx-left-arrow-alt tf-icons"></i>
            Back
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