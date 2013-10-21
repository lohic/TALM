<?php

namespace plainview\sdk\form2\inputs;

/**
	@brief		Text input with e-mail formatting.
	@author		Edward Plainview <edward@plainview.se>
	@copyright	GPL v3
	@version	20130524
**/
class email
	extends text
{
	public $type = 'email';

	public function _construct()
	{
		$this->add_validation_method( 'email' );
	}

	public function validate_email()
	{
		$value = $this->get_post_value();
		// Check the email address only if (1) it is required or (2) there is something there.
		if ( $value == '' && ! $this->is_required() )
			return;
		if ( ! \plainview\sdk\base::is_email( $value ) )
		{
			$text = $this->form()->_( 'The e-mail address in %s is not valid!', '<em>' . $this->get_label()->content . '</em>' );
			$this->validation_error()->set_unfiltered_label_( $text );
		}
	}
}

