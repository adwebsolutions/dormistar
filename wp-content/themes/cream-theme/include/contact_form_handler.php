<?php
/**
 * File Name: contact_form_handler.php
 *
 * Send message function to process contact form submission
 *
 */


if( !function_exists( 'inspiry_mail_from_name' ) ) :
	/**
	 * Override 'WordPress' as from name in emails sent by wp_mail function
	 * @return string
	 */
	function inspiry_mail_from_name() {
		// The blogname option is escaped with esc_html on the way into the database in sanitize_option
		// we want to reverse this for the plain text arena of emails.
		$blogname = wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );

		return $blogname;
	}
	add_filter( 'wp_mail_from_name', 'inspiry_mail_from_name' );
endif;


if ( ! function_exists( 'send_message' ) ) {
	/**
	 * Handler for Contact form on contact page template
	 */
	function send_message() {


		if ( isset( $_POST[ 'email' ] ) ):

			/* Verify Nonce */
			$nonce = $_POST[ 'nonce' ];
			if ( ! wp_verify_nonce( $nonce, 'send_message_nonce' ) )
				die ( __( 'Busted!', 'framework' ) );


			global $theme_options;

			/* Sanitize and Validate Target email address that will be configured from theme options */
			$to_email = sanitize_email( $theme_options[ 'contact_email' ] );
			$to_email = is_email( $to_email );
			if ( ! $to_email ) {
				die ( __( 'Target Email address is not properly configured!', 'framework' ) );
			}

			/* Sanitize and Validate contact form input data */
			$from_name = sanitize_text_field( $_POST[ 'name' ] );
			$phone_number = sanitize_text_field( $_POST[ 'number' ] );
			$message = stripslashes( $_POST[ 'message' ] );
			$from_email = sanitize_email( $_POST[ 'email' ] );
			$from_email = is_email( $from_email );
			if ( ! $from_email ) {
				die ( __( 'Provided Email address is invalid!', 'framework' ) );
			}

			$email_subject = __( 'New message sent by', 'framework' ) . ' ' . $from_name . ' ' . __( 'using contact form at', 'framework' ) . ' ' . get_bloginfo( 'name' );

			$email_body = __( "You have received a message from: ", 'framework' ) . $from_name . " <br/>";

			if ( ! empty( $phone_number ) ) {
				$email_body .= __( "Phone Number : ", 'framework' ) . $phone_number . " <br/>";
			}

			$email_body .= __( "Their additional message is as follows.", 'framework' ) . " <br/>";
			$email_body .= wpautop( $message ) . " <br/>";
			$email_body .= __( "You can contact ", 'framework' ) . $from_name . __( " via email, ", 'framework' ) . $from_email;

			/*
			 * Email Headers ( Reply To and Content Type )
			 */
			$headers = array();
			$headers[] = "Reply-To: $from_name <$from_email>";
			$headers[] = "Content-Type: text/html; charset=UTF-8";
			$headers = apply_filters( "inspiry_contact_mail_header", $headers );    // just in case if you want to modify the header in child theme

			if ( wp_mail( $to_email, $email_subject, $email_body, $headers ) ) {
				_e( "Message Sent Successfully!", 'framework' );
			} else {
				_e( "Server Error: WordPress mail method failed!", 'framework' );
			}

		else:
			_e( "Invalid Request !", 'framework' );
		endif;

		die;
	}

	add_action( 'wp_ajax_nopriv_send_message', 'send_message' );
	add_action( 'wp_ajax_send_message', 'send_message' );
}
