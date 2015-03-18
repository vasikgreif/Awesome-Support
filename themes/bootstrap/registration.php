<?php
/**
 * This is a built-in template file. If you need to customize it, please,
 * DO NOT modify this file directly. Instead, copy it to your theme's directory
 * and then modify the code. If you modify this file directly, your changes
 * will be overwritten during next update of the plugin.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Make the post data and the pre-form message global
 */
global $post, $wpas_notification;

$submit = get_permalink( wpas_get_option( 'ticket_list' ) );

/**
 * If there is a message to display we show a bootstrap info box
 */
if ( isset( $param ) && $param['msg'] && $param['type'] ):

	$wpas_notification->notification( $param['type'], $param['msg'] );

endif;

$registration  = boolval( wpas_get_option( 'allow_registrations', true ) ); // Make sure registrations are open
$redirect_to   = get_permalink( $post->ID );
?>

<div class="row">

	<?php
	/* Registrations are not allowed. */
	if ( false === $registration ) {
		wpas_notification( 'failure', __( 'Registrations are currently not allowed.', 'wpas' ) );
	}
	?>

	<form class="col-lg-6 col-md-6" method="post" role="form" action="<?php echo wpas_get_login_url(); ?>">
		<h3><?php _e( 'Login' ); ?></h3>	

		<div class="form-group">
			<label class="sr-only"><?php _e( 'E-mail or username', 'wpas' ); ?></label>
			<input class="form-control" type="text" name="log" placeholder="<?php _e( 'E-mail or username', 'wpas' ); ?>" required>
		</div>

		<div class="form-group">
			<label class="sr-only"><?php _e( 'Password', 'wpas' ); ?></label>
			<input class="form-control" type="password" name="pwd" placeholder="<?php _e( 'Password', 'wpas' ); ?>" required>
		</div>

		<?php do_action( 'wpas_after_login_fields' ); ?>

		<div class="checkbox">
			<label>
				<input type="checkbox" name="rememberme"> <?php echo _x( 'Remember me', 'Login form', 'wpas' ); ?>
			</label>
		</div>

		<input type="hidden" name="redirect_to" value="<?php echo $redirect_to; ?>">
		<input type="hidden" name="wpas_login" value="1">

		<button type="submit" class="btn btn-default" data-onsubmit="<?php _e( 'Logging In...', 'wpas' ); ?>"><?php _e( 'Login', 'wpas' ); ?></button>
	</form>

	<?php if ( true === $registration ): ?>

	<form class="col-lg-6 col-md-6" method="post" action="<?php echo get_permalink( $post->ID ); ?>">
		<h3><?php _e( 'Register', 'wpas' ); ?></h3>

		<div class="form-group">
			<label class="sr-only"><?php _e( 'First Name', 'wpas' ); ?></label>
			<input class="form-control" type="text" placeholder="<?php _e( 'First Name', 'wpas' ); ?>" name="first_name" value="<?php echo wpas_get_registration_field_value( 'first_name' ); ?>" required>
		</div>

		<div class="form-group">
			<label class="sr-only"><?php _e( 'Last Name', 'wpas' ); ?></label>
			<input class="form-control" type="text" placeholder="<?php _e( 'Last Name', 'wpas' ); ?>" name="last_name" value="<?php echo wpas_get_registration_field_value( 'last_name' ); ?>" required>
		</div>

		<div class="form-group">
			<label class="sr-only"><?php _e( 'Email', 'wpas' ); ?></label>
			<input class="form-control" type="email" placeholder="<?php _e( 'Email', 'wpas' ); ?>" name="email" value="<?php echo wpas_get_registration_field_value( 'email' ); ?>" required>
			<small class="help-block" id="email-validation" style="display: none;"></small>
		</div>

		<div class="form-group">
			<label class="sr-only"><?php _e( 'Enter a password', 'wpas' ); ?></label>
			<input class="form-control" type="password" placeholder="<?php _e( 'Password', 'wpas' ); ?>" id="password" name="pwd" required>
		</div>

		<div class="checkbox">
			<label>
				<input type="checkbox" name="pwdshow"> <?php echo _x( 'Show Password', 'Login form', 'wpas' ); ?>
			</label>
		</div>

		<?php do_action( 'wpas_after_registration_fields' ); ?>

		<input type="hidden" name="wpas_registration" value="true">

		<?php wp_nonce_field( 'register', 'user_registration', false, true ); ?>

		<button type="submit" class="btn btn-default" data-onsubmit="<?php _e( 'Creating Account...', 'wpas' ); ?>"><?php _e( 'Create Account', 'wpas' ); ?></button>
	</form>
<?php endif; ?>
</div>