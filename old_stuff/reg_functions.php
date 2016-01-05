<?php

// configuration
$DATA_FILE = "/web/homepage/events/elisalpf2014/admin/participations.data";

// gets stored data in order to supply it to disp_mask()
function get_data()
{
  global $DATA_FILE;
  $data = unserialize( file_get_contents( $DATA_FILE ) );
  if(is_array($data))  return $data;
  else return array();
}

// stores the input mask in a file
function store_data( $data )
{
  global $DATA_FILE;
  $handle = fopen( $DATA_FILE, 'w' );
  if(!$handle) print("warning: no write access to $DATA_FILE!");
  fwrite( $handle, serialize( $data ) );
  fclose( $handle );
}

// sends an email          
function mail_utf8($to, $subject = '(No subject)', $message = '')
{
  $header = 'MIME-Version: 1.0' . "\r\n" . 'Content-type: text/plain; charset=UTF-8' . "\r\n" . 'From: =?UTF-8?B?' . base64_encode("eLISA Consortium Meeting Registration System") . '?= <me@larynx.ch>' . "\r\n"; 
  return mail(utf8_encode($to), '=?UTF-8?B?' . base64_encode($subject) . '?=', $message, $header, "-r me@larynx.ch");
}

// counts the number of participants
function count_participants()
{
  $data = get_data();
  $attendees = count( $data );
  
  foreach( $data as $item )
  {
    if( $item[mond] == "on" ) $mond++;
    if( $item[elisa] == "on" ) $elisa++;
    if( $item[dinner] == "on" ) $dinner++;
  }

  return array( $attendees, $mond, $elisa, $dinner );
}

// make a string out of all email addresses
function emailstr()
{
  $data = get_data();
  $mailstr = "";
  
  foreach( $data as $item )
  {
    $mailstr .= $item[email] . ",";
  }

  return substr( $mailstr, 0, -1 );
}

// delete a data entry
function delete_data( $id )
{
  $data = get_data();
  unset($data[$id]);
  $data = array_values($data);
  store_data( $data );
}


?>