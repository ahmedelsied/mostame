<section class="queue-section special text-center mt-5" style="margin-top: 2.5vw;">
  <div class="queue-parent">
    <h1 class="h2 text-center main-color" style="margin-bottom:20px">
      <b><?=$this->__('user.queue.queue-h')?></b>
    </h1>
    <div class="all_queue">
    <?php if(!empty($this->queue)): ?>
    <?php foreach($this->queue as $queue): ?>
      <div data-id="<?=$queue['id']?>" class="queue text-<?=$this->__("settings.align")?>">
        <span class="avatar"><?=chr(rand(65,90));?></span>
        <span class="name main-color"><?=$this->__("user.queue.unknown")?></span>
        <button class="chat btn main-btn pull-<?=$this->__("settings.reverse-align")?>"><?=$this->__("user.queue.chat-action")?></button>
      </div>
      <?php endforeach; ?>
      <button id="load_more_queue" class="main-btn"><?=$this->__("user.queue.load-more")?></button>
      <?php else: ?>
      <div class="empty">
        <p class="lead"><?=$this->__("user.queue.no_queue")?></p>
      </div>
      <?php endif; ?>
    </div>
  </div>
</section>
<?php $this->fire_component("queue");?>