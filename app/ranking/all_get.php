


<div class="row">

  <div class="col-xs-6">
    <?php require 'app/ranking/DD_get.php'; ?>
  </div>

  <div class="col-xs-6">
    <?php require 'app/ranking/DH_get.php'; ?>
  </div>

</div>

<div class="row">

  <div class="col-xs-6">
    <?php require 'app/ranking/SD_get.php'; ?>
  </div>

  <div class="col-xs-6">
    <?php require 'app/ranking/SH_get.php'; ?>
  </div>

</div>


<hr style="page-break-after: always;" />

<div class="row">

  <div class="col-xs-6 col-centered">
    <?php require 'app/ranking/DX_get.php'; ?>
  </div>

</div>


<div class="printable-footer">

  <ul>
    <li>Date : <?php echo date('j/n/Y'); ?></li>
    <li>Rappel :
      <ul>
        <li>Score en <span class="grayed">gris</span> = moins de <?php echo MIN_SETS_FOR_BEING_RANKED ?> sets joués = score "provisoire"</li>
        <li>Score en noir = <?php echo MIN_SETS_FOR_BEING_RANKED ?> sets joués ou plus = score "valide" pour le classement
          (qui peut encore évoluer au fil des futures séances)</li>
      </ul>
    </li>
  </ul>

</div>
