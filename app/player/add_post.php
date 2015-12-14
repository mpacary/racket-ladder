<?php

Database::insert(array(
    'table' => 'bad_player',
    'row' => array(
        'first_name' => "'".Database::escape($_POST['first_name'])."'",
        'last_name' => "'".Database::escape($_POST['last_name'])."'",
      )
  ));

Message::add(array('type' => 'success', 'text' => 'Joueur ajouté avec succès.'));

Routing::redirect(array('module' => $g_current_module, 'action' => $g_current_action));