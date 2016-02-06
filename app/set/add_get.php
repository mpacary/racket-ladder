<?php

include_once 'model/SetType.php';
include_once 'model/Player.php';

// retrieve set types

$raw_set_types = ModelSetType::get(array('order_by' => 'name'));

$set_types = array('' => 'Choisir...');

foreach($raw_set_types as $row)
  $set_types[$row['id']] = $row['name'];

// retrieve players

$raw_players = ModelPlayer::get(array('order_by' => 'first_name, last_name'));

$players = array('' => 'Aucun');

foreach($raw_players as $row)
  $players[$row['id']] = $row['first_name'].' '.$row['last_name'];



$form_url = Routing::getUrlFor(array('module' => $g_current_module, 'action' => $g_current_action));

?>
<h2>Ajouter un set</h2>

<form id="form_add_set" class="form-horizontal" action="<?php echo htmlspecialchars($form_url); ?>" method="post" onsubmit="return checkDistinctPlayers(this);">

  <div class="form-group">
    <label for="id_set_type" class="col-sm-2 control-label">Type de set</label>
    <div class="col-sm-10">
      <?php Helper::buildSelect(array('name' => 'id_set_type', 'options' => $set_types)) ?>
    </div>
  </div>
  
  <div class="form-group">
    <label for="id_player_1_win" class="col-sm-2 control-label">Gagnant 1</label>
    <div class="col-sm-10">
      <?php Helper::buildSelect(array('name' => 'id_player_1_win', 'options' => $players)) ?>
    </div>
  </div>
  
  <div class="form-group">
    <label for="id_player_2_win" class="col-sm-2 control-label">Gagnant 2</label>
    <div class="col-sm-10">
      <?php Helper::buildSelect(array('name' => 'id_player_2_win', 'options' => $players)) ?>
    </div>
  </div>
  
  <div class="form-group">
    <label for="id_player_1_lose" class="col-sm-2 control-label">Perdant 1</label>
    <div class="col-sm-10">
      <?php Helper::buildSelect(array('name' => 'id_player_1_lose', 'options' => $players)) ?>
    </div>
  </div>
  
  <div class="form-group">
    <label for="id_player_2_lose" class="col-sm-2 control-label">Perdant 2</label>
    <div class="col-sm-10">
      <?php Helper::buildSelect(array('name' => 'id_player_2_lose', 'options' => $players)) ?>
    </div>
  </div>
  
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <input type="submit" name="submit" value="Ajouter" class="btn btn-default" />
    </div>
  </div>

</form>


<script type="text/javascript">

// default: all player selects disabled (choose set type first)
var form_add_set = document.getElementById('form_add_set');

form_add_set.elements['id_player_1_win'].disabled = true;
form_add_set.elements['id_player_2_win'].disabled = true;
form_add_set.elements['id_player_1_lose'].disabled = true;
form_add_set.elements['id_player_2_lose'].disabled = true;
form_add_set.elements['submit'].disabled = true;

function enableSubmitIfPossible()
{
  var form_add_set = document.getElementById('form_add_set');
  var select_set_type = form_add_set.elements['id_set_type'];
  var value = select_set_type.options[select_set_type.selectedIndex].value;
  var is_single = (value == <?php echo ID_SET_TYPE_MEN_SINGLES ?> || value == <?php echo ID_SET_TYPE_WOMEN_SINGLES ?>);
    
  form_add_set.elements['submit'].disabled = (
      select_set_type.selectedIndex == 0
      || form_add_set.elements['id_player_1_win'].selectedIndex == 0 || form_add_set.elements['id_player_1_lose'].selectedIndex == 0
      || (!is_single && (form_add_set.elements['id_player_2_win'].selectedIndex == 0 || form_add_set.elements['id_player_2_lose'].selectedIndex == 0))
    );
}

document.getElementById('form_add_set').elements['id_set_type'].addEventListener(
  'change',
  function() {
    var value = this.options[this.selectedIndex].value;
    var is_single = (value == <?php echo ID_SET_TYPE_MEN_SINGLES ?> || value == <?php echo ID_SET_TYPE_WOMEN_SINGLES ?>);
    
    select_w1 = this.form.elements['id_player_1_win'];
    select_w2 = this.form.elements['id_player_2_win'];
    select_l1 = this.form.elements['id_player_1_lose'];
    select_l2 = this.form.elements['id_player_2_lose'];
    
    if (is_single)
    {
      select_w2.selectedIndex = 0;
      select_l2.selectedIndex = 0;
    }
    
    select_w1.disabled = (value == '');
    select_w2.disabled = (value == '' || is_single);
    select_l1.disabled = (value == '');
    select_l2.disabled = (value == '' || is_single);
    
    enableSubmitIfPossible();
  },
  false
);


document.getElementById('form_add_set').elements['id_player_1_win'].addEventListener(
  'change', function() { enableSubmitIfPossible(); }, false
);

document.getElementById('form_add_set').elements['id_player_2_win'].addEventListener(
  'change', function() { enableSubmitIfPossible(); }, false
);

document.getElementById('form_add_set').elements['id_player_1_lose'].addEventListener(
  'change', function() { enableSubmitIfPossible(); }, false
);

document.getElementById('form_add_set').elements['id_player_2_lose'].addEventListener(
  'change', function() { enableSubmitIfPossible(); }, false
);

// check on form submit
function checkDistinctPlayers(form)
{
  var select_set_type = form.elements['id_set_type'];
  var value = select_set_type.options[select_set_type.selectedIndex].value;
  var is_single = (value == <?php echo ID_SET_TYPE_MEN_SINGLES ?> || value == <?php echo ID_SET_TYPE_WOMEN_SINGLES ?>);
  var distinct_problem = false;
  
  if (form.elements['id_player_1_win'].selectedIndex == form.elements['id_player_1_lose'].selectedIndex
    || (!is_single && (
      form.elements['id_player_1_win'].selectedIndex == form.elements['id_player_2_win'].selectedIndex
      || form.elements['id_player_1_win'].selectedIndex == form.elements['id_player_2_lose'].selectedIndex
      || form.elements['id_player_1_lose'].selectedIndex == form.elements['id_player_2_win'].selectedIndex
      || form.elements['id_player_1_lose'].selectedIndex == form.elements['id_player_2_lose'].selectedIndex
      || form.elements['id_player_2_win'].selectedIndex == form.elements['id_player_2_lose'].selectedIndex
    )))
  {
    alert('Certains joueurs sont identiques, veuillez modifier votre sélection');
    return false;
  }
  
  return true;
}

</script>