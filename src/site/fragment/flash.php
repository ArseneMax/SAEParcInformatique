<?php
// Fragment flash message - include ce fichier dans inventory.php (et toute page qui en a besoin)
// Le message est affiché une seule fois puis supprimé de la session
if (!empty($_SESSION['flash_success'])): ?>
    <div class="alert-success">
        <strong>✔ <?= htmlspecialchars($_SESSION['flash_success']) ?></strong>
    </div>
    <?php
    unset($_SESSION['flash_success']);
endif;

if (!empty($_SESSION['flash_error'])): ?>
    <div class="alert-warning">
        <strong>⚠ <?= htmlspecialchars($_SESSION['flash_error']) ?></strong>
    </div>
    <?php
    unset($_SESSION['flash_error']);
endif;
?>