<?php

$to = $useremail;
$from = 'noreply@shufflestv.com'; 
$fromName = 'ShufflesTV'; 
 
$subject = "Password request on shufflestv.com"; 
 
$htmlContent = ' 
        <table cellspacing="0" style="width: 100%;align:left;"> 
            <tr> 
                <td > Hi '.$fname.', <br>

Your new password is - <b>'.$code.'</b>
</td> 
            </tr> 
            
        </table> 
  '; 
 
// Set content-type header for sending HTML email 
$headers = "MIME-Version: 1.0" . "\r\n"; 
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n"; 
 
// Additional headers 
$headers .= 'From: '.$fromName.'<'.$from.'>' . "\r\n"; 
/*$headers .= 'Cc: welcome@example.com' . "\r\n"; 
$headers .= 'Bcc: welcome2@example.com' . "\r\n"; 
 */
// Send email 

$send=mail($to, $subject, $htmlContent, $headers);


