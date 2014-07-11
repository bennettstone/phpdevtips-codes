<?php
/**
 * index.php
 * Loads form to send message
 * Includes phpmailer
 *
 * @author Bennett Stone
 * @link phpdevtips.com
 * @version 1.0
 * @date 10-Jul-2014
 * @package PHPMailer Demo
 **/

//If the form was submitted, process the email
if( isset( $_POST ) && !empty( $_POST ) )
{
    //Handle some basic validation
    $errors = array();
    
    //Validate that we HAVE an email to send to, it isn't empty, and matches regex for email
    if( !isset( $_POST['email'] ) || empty( $_POST['email'] ) || !filter_var( trim( $_POST['email'] ), FILTER_VALIDATE_EMAIL ) )
    {
        $errors[] = 'Please enter a valid email address';
    }
    
    //Validate that we HAVE an email to send FROM, it isn't empty, and matches regex for email
    if( !isset( $_POST['sender'] ) || empty( $_POST['sender'] ) || !filter_var( trim( $_POST['sender'] ), FILTER_VALIDATE_EMAIL ) )
    {
        $errors[] = 'Please enter a valid sender email address';
    }
    
    //Validate that we have a subject line
    if( !isset( $_POST['subject'] ) || empty( $_POST['subject'] ) )
    {
        $errors[] = 'Please enter a subject for your email';
    }
    
    //And validate that we actually have a message
    if( !isset( $_POST['message'] ) || empty( $_POST['message'] ) )
    {
        $errors[] = 'A message is required to send anything';
    }
    //End basic validation
    
    
    //If we have no errors, process the message
    if( empty( $errors ) )
    {
        //Include the phpmailer functions
        require_once( 'phpmailer-config.php' );
        
        //Assigning a picture for {logo} replacement
        $logo = 'http://www.phpdevtips.com/wp-content/uploads/2013/06/dev_tips-2.png';
        
        //Send the message assigned to a var so we can output
        $status = send_message( $_POST['sender'], $_POST['email'], $_POST['subject'], $_POST['message'], $logo );
    }
    //Otherwise return the errors below in the body
}
?>
<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
    </head>
    <body>
        
        <?php
        if( isset( $errors ) && !empty( $errors ) )
        {
            foreach( $errors as $e )
            {
                echo '<strong>'. $e .'</strong><br />';
            }
        }
        ?>
        <form action="" method="post">
        
            <p>
                <label for="email">Recipient Email Address</label><br />
                
                <input type="text" name="email" value="<?php if( isset( $_POST['email'] ) ) echo $_POST['email']; ?>" />
            </p>
            <p>
                <label for="sender">YOUR Email Address</label><br />
                
                <input type="text" name="sender" value="<?php if( isset( $_POST['sender'] ) ) echo $_POST['sender']; ?>" />
            </p>
            <p>
                <label for="subject">Message Subject</label><br />
                
                <input type="text" name="subject" value="<?php if( isset( $_POST['subject'] ) ) echo $_POST['subject']; ?>" />
            </p>
            <p>
                <label for="message">Message</label><br />
                
                <textarea name="message" rows="10" cols="50"><?php if( isset( $_POST['message'] ) ) echo stripslashes( $_POST['message'] ); ?></textarea>

            </p>
            <p>
                <input type="submit" name="send" value="Send Message" />
            </p>
        </form>
        
        <?php
        /**
         * Output the status from successful sending if applicable
         */
        if( isset( $status ) )
        {
            echo $status;
        }
        ?>

    </body>
</html>