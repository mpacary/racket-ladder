<?php

$form_url = Routing::getUrlFor(array('module' => $g_current_module, 'action' => $g_current_action));

?>
<h2>Ajouter un joueur</h2>

<form class="form-horizontal" action="<?php echo $form_url; ?>" method="post">

  <div class="form-group">
    <label for="first_name" class="col-sm-2 control-label">Prénom</label>
    <div class="col-sm-10">
      <input class="form-control" type="text" name="first_name" />
    </div>
  </div>
  
  <div class="form-group">
    <label for="last_name" class="col-sm-2 control-label">Nom</label>
    <div class="col-sm-10">
      <input class="form-control" type="text" name="last_name" />
    </div>
  </div>
  
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <input class="btn btn-default" type="submit" value="Ajouter" />
    </div>
  </div>

</form>
