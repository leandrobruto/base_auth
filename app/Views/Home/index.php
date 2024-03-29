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

<div class="col-lg-8 mb-4 order-0">
  <div class="card">
    <div class="d-flex align-items-end row">
      <div class="col-sm-7">
        <div class="card-body">
          <h5 class="card-title text-primary"><?= $this->renderSection('title'); ?> 🎉🦎⚽</h5>
          <p class="mb-4">
            You have done <span class="fw-bold">72%</span> more sales today. Check your new badge in
            your profile.
          </p>

          <a href="javascript:;" class="btn btn-sm btn-outline-primary">View Badges</a>
        </div>
      </div>
      <div class="col-sm-5 text-center text-sm-left">
        <div class="card-body pb-0 px-0 px-md-4">
          <img
            src="<?= site_url(''); ?>/assets/img/illustrations/man-with-laptop-light.png"
            height="140"
            alt="View Badge User"
            data-app-dark-img="illustrations/man-with-laptop-dark.png"
            data-app-light-img="illustrations/man-with-laptop-light.png"
          />
        </div>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection(); ?>


<!-- Aqui enviamos para o template principal os scripts -->
<?= $this->section('scripts'); ?>


<?= $this->endSection(); ?>