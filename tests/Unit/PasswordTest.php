<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Rules\StrongPassword;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PasswordTest extends TestCase
{
    /** @test */
    public function a_strong_password_is_accepted()
    {
        $rule = ['password' => [new StrongPassword]];

        $this->assertFalse(validator(['password' => '1'], $rule)->passes());
        $this->assertFalse(validator(['password' => '1!'], $rule)->passes());
        $this->assertFalse(validator(['password' => 'wef1!'], $rule)->passes());
        $this->assertFalse(validator(['password' => 'ergWEF1!'], $rule)->passes());
        $this->assertFalse(validator(['password' => 'FG585erg!'], $rule)->passes());

        $this->assertTrue(validator(['password' => '::This pa55word !s very $trong'], $rule)->passes());
    }
}
