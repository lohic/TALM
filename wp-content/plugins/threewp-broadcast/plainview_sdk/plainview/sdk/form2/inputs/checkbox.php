<?php

namespace plainview\sdk\form2\inputs;

/**
	@brief		A checkbox input.
	@author		Edward Plainview <edward@plainview.se>
	@copyright	GPL v3
	@version	20130524
**/
class checkbox
	extends option
{
	use traits\checked;

	public $self_closing = true;
	public $tag = 'input';
	public $type = 'checkbox';

	public function _construct()
	{
		// A checkbox needs a value, else it won't exist in the POST array even if checked.
		$this->value( 'on' );
	}

	/**
		@brief		Input before label.
	**/
	public function assemble_input_string( $o )
	{
		$r = '';
		$r .= $o->indent . $o->input . "\n";
		$r .= $o->indent . $o->label . "\n";
		if ( isset( $o->description ) )
			$r .= $o->indent . $o->description . "\n";
		return $r;
	}

	public function check( $check = true)
	{
		$check = $check ? 'checked' : '';
		return $this->checked( $check );
	}

	public function use_post_value()
	{
		// It is checked if the name exists in the post AND the value there is the same as this one.
		$value = $this->get_post_value();
		$this->check( $value == $this->get_value() );
		return $this;
	}
}

