<div class="cell cell-user-articles">
  <div class="cell-heading">
    <div class="cell-title"><?=$title?></div>
  </div>
  <div class="cell-body">
    <?php foreach($articles as $article): ?>
        <h4><?= $article->title; ?></h4>
    <?php endforeach; ?>
  </div>
</div>