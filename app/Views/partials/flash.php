<?php if ($msg = Core\Session::get('flash')): ?>
    <?= Core\View::component('alert', ['type' => 'success', 'message' => $msg]) ?>
    <?php Core\Session::forget('flash'); ?>
<?php endif; ?>