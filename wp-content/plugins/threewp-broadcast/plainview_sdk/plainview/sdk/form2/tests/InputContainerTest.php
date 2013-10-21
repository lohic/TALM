<?php

namespace plainview\sdk\form2\tests;

class InputContainerTest extends TestCase
{
	/**
		@brief		Testing adding of inputs to input collections.
	**/
	public function test_add()
	{
		// Add two inputs and set unique values
		$fieldset = $this->form()->fieldset( 'fieldsettest' );
		$fieldset->text( 'text1' )->value( 'text 1' );
		$fieldset->text( 'text2' )->value( 'text 2' );

		// Retrieve the inputs and make sure they have the correct values.
		$this->assertEquals( $fieldset->text( 'text1' )->get_value(), 'text 1' );
		$this->assertNotEquals( $fieldset->text( 'text1' )->get_value(), 'text 2' );
		$this->assertEquals( $fieldset->text( 'text2' )->get_value(), 'text 2' );
		$this->assertNotEquals( $fieldset->text( 'text1' )->get_value(), 'text 2' );
	}

	/**
		@brief		hidden() for containers is the same as hidden() for inputs.
	**/
	public function test_hidden()
	{
		$form = $this->form();
		$this->assertNotEquals( $form->get_attribute( 'hidden' ), 'hidden' );
		$this->assertFalse( $form->is_hidden() );
		$form->hidden();
		$this->assertEquals( $form->get_attribute( 'hidden' ), 'hidden' );
		$this->assertTrue( $form->is_hidden() );
	}

	/**
		@brief		Input containers must be able to generate hidden inputs.
	**/
	public function test_hidden_input()
	{
		$form = $this->form();
		$hidden_input = $form->hidden_input( 'hidden_input' )->value( 'very hidden' );

		// The input should be of the correct type.
		$this->assertInstanceOf( '\\plainview\\sdk\\form2\\inputs\\hidden', $hidden_input );
		// Form should NOT be hidden just because we've created a hidden input.
		$this->assertFalse( $form->is_hidden() );
	}
}
