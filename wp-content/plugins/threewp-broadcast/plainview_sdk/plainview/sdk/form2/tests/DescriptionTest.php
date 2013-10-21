<?php

namespace plainview\sdk\form2\tests;

class DescriptionTest extends TestCase
{
	public function input()
	{
		return $this->form()->text( 'testtext' )
			->label( 'With description' );
	}

	public function test_with_description()
	{
		$description = 'This is a good looking description';
		$input = $this->input()
			->description( $description );
		$this->assertFalse( $input->description->is_empty() );
		$this->assertStringContainsRegExp( '/.*class="description.*' . $description . '.*/', $input );
	}

	public function test_without_description()
	{
		$description = 'This is a good looking description';
		$input = $this->input();
		$this->assertTrue( $input->description->is_empty() );
		$this->assertStringDoesNotContainRegexp( '/.*class="description/', $input );
	}
}

