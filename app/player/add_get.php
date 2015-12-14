<?php

$form_url = Routing::getUrlFor(array('module' => $g_current_module, 'action' => $g_current_action));

?>
<h2>Ajouter un joueur</h2>

<form action="<?php echo $form_url; ?>" method="post">

  <table>
  <tr>
    <th>Prénom</th>
    <td>
      <input type="text" name="first_name" />
    </td>
  </tr>
  <tr>
    <th>Nom</th>
    <td>
      <input type="text" name="last_name" />
    </td>
  </tr>
  </table>
  
  <input type="submit" value="Ajouter" />

</form>
