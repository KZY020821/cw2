<?php
// array for extension of image
$img = array('jpeg', 'jpg', 'png', 'gif', 'tiff', 'psg', 'ai', 'pdf', 'eps', 'indd', 'raw');
// array for extension of video
$vid = array('mp4', 'mov', 'avi', 'wmv', 'avchd', 'flv', 'f4v', 'swf', 'mkv', 'webm', 'html5', 'mpeg-2');
// array for extension of audio
$aud = array('m4a', 'flac', 'mp3', 'wav', 'wma', 'aac');
// combine all extension into one array
$allfiletype = array_merge($img, $vid, $aud);

?>