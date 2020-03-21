<h1><?= $header ?></h1>
<div>
  <? foreach ($breadcrumbs as $link => $title): ?>
    <a style="padding-right: 10px" href="<?= $link ?>"><?= $title ?></a>
  <? endforeach; ?>
</div>
<div>
  <?= $content ?>
</div>