<?php

namespace plainview\sdk\wordpress\table\bulkactions;

use \plainview\sdk\collections\collection;

/**
	@brief		Bulk actions controller.

	@details

	Used to add bulk actions above the table.
	@since		20131015
**/
class controller
{
	use \plainview\sdk\traits\method_chaining;

	public $bulk_actions_button;
	public $bulk_actions_input;
	public $checkboxes;
	public $form;
	public $table;

	public function __construct( $table )
	{
		$this->checkboxes = new collection;
		$this->table = $table;
	}

	public function __toString()
	{
		return sprintf( '<div class="tablenav top"><div class="alignleft actions"><div class="screen-reader-text">%s</div>%s%s</div></div>',
			$this->bulk_actions_input->display_label(),
			$this->bulk_actions_input->display_input(),
			$this->bulk_actions_button->display_input()
		);
	}

	/**
		@brief		Add a bulk action to the select box of bulk actions.
		@param		string		$label		Label of new select option.
		@param		string		$value		The HTML value of the select option.
		@since		20131015
	**/
	public function add( $label, $value )
	{
		$this->bulk_actions_input->option( $label, $value );
		return $this;
	}

	/**
		@brief		Create a checkbox column in the table header or the body.
		@details	If the $row is in the body section, the $id parameter must also be given.
		@param		row			$row		Row in the table. Automatically detects if the row is in the head or the body.
		@param		mixed		$id			The ID of this row. String or int.
		@since		20131015
	**/
	public function cb( $row, $id = null )
	{
		$section = get_class( $row->section );
		if ( $section == 'plainview\\sdk\\table\\head' )
		{
			// Create a temporary form in order to create a checkbox that is only used by javascript.
			$temp_form = clone( $this->form );
			// Create the temporary checkbox.
			$select = $temp_form->checkbox( 'check' );
			$text = $select->display_input() . '<span class="screen-reader-text">Selected</span>';
			$row->th( 'check_column_' . $row->id )->css_class( 'check-column' )->text( $text );
		}

		if ( $section == 'plainview\\sdk\\table\\body' )
		{
			// Create the row checkbox.
			$cb = $this->form->checkbox( $id )
				->prefix( 'cb' );

			$text = $cb->display_input() . '<span class="screen-reader-text">' . $cb->display_label() . '</span>';
			$row->th( 'check_column_' . $row->id )->css_class( 'check-column' )->set_attribute( 'scope', 'row' )->text( $text );

			// Add the checkbox to a quick lookup table
			$this->checkboxes->append( $cb );
		}
	}

	/**
		@brief		Set the form object to be used with the actions.
		@details	The form is cloned as to not interfere with the other inputs in the form.
		@since		20131015
	**/
	public function form( $form )
	{
		$form = clone( $form );

		$this->bulk_actions_button = $form->secondary_button( 'bulk_actions_apply' )
			->value( _( 'Apply' ) );
		$this->bulk_actions_input = $form->select( 'bulk_actions' )
			->label( _( 'Bulk actions' ) )
			->option( _( 'Bulk Actions' ), '' );

		return $this->set_key( 'form', $form );
	}

	/**
		@brief		Get which action was selected.
		@since		20131015
	**/
	public function get_action()
	{
		return $this->bulk_actions_input->get_post_value();
	}

	/**
		@brief		Return an array of select row values.
		@details	The values are the $id parameter given to cb().
		@since		20131015
	**/
	public function get_rows()
	{
		if ( isset( $_POST[ 'cb' ] ) )
			return array_keys( $_POST[ 'cb' ] );
		else
			return [];
	}

	/**
		@brief		Was the Apply button pressed?
		@since		20131015
	**/
	public function pressed()
	{
		if ( ! $this->form->is_posting() )
			return false;
		$this->form->post();
		return $this->bulk_actions_button->pressed();
	}
}
