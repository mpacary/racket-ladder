<ul class="modules">
<?php

foreach($g_modules as $module_code => $module)
{
  if ($module_code == $g_current_module)
  {
    echo '<li class="current">'.$module['name'].'</li>'."\n";
  }
  else
  {
    echo '<li><a href="'.Routing::getUrlFor(array('module' => $module_code)).'">'.$module['name'].'</a></li>'."\n";
  }
}

?>
</ul>

<ul class="actions">
<?php

foreach($g_actions as $action_code => $action)
{
  if ($action_code == $g_current_action)
  {
    echo '<li class="current">'.$action['name'].'</li>'."\n";
  }
  else
  {
    $url = Routing::getUrlFor(array('module' => $g_current_module, 'action' => $action_code));
    echo '<li><a href="'.$url.'">'.$action['name'].'</a></li>'."\n";
  }
}

?>
</ul>