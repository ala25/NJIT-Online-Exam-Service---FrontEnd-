<?php
$form = file_get_contents('php://input');
$curl = curl_init();
  // You can also set the URL you want to communicate with by doing this:
  // $curl = curl_init('http://localhost/echoservice');
curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

  // We POST the data
  curl_setopt($curl, CURLOPT_POST, 1);
  // Set the url path we want to call
  curl_setopt($curl, CURLOPT_URL, 'https://web.njit.edu/~srm56/cs490/exam.php');
  // Make it so the data coming back is put into a string
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  // Insert the data
  curl_setopt($curl, CURLOPT_POSTFIELDS, $form);

  // You can also bunch the above commands into an array if you choose using: curl_setopt_array

  // Send the request
  $result = curl_exec($curl);
  // Get some cURL session information back
  $info = curl_getinfo($curl);


  http_response_code($info['http_code']);

  // Free up the resources $curl is using
  curl_close($curl); 
?>