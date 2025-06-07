<?php
    $params = array('friends' => $friends, 'members' => $members, 'gallery_id' => $gallery_id, 'gallery_type' => $gallery_type);
    e($this->element('gallerypermissionusers', $params));
?>
