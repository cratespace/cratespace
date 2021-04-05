<?php

namespace Tests\Unit\Orders;

use Tests\TestCase;
use App\Orders\GenerateConfirmationNumber;
use App\Orders\ValidateConfirmationNumber;
use App\Orders\Validators\LengthValidator;
use App\Orders\Validators\AmbiguityValidator;
use App\Orders\Validators\CharacterValidator;
use App\Orders\Validators\UniquenessValidator;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ValidateConfirmationNumberTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->number = (new GenerateConfirmationNumber())->generate();
    }

    public function testValidateConfirmationNumber()
    {
        $validator = new ValidateConfirmationNumber();

        $this->assertTrue($validator->validate($this->number));
    }

    public function testMustBe24CharactersLong()
    {
        $validator = new ValidateConfirmationNumber();

        ValidateConfirmationNumber::setValidators([new LengthValidator()]);

        $this->assertTrue($validator->validate($this->number));
    }

    public function testCanOnlyContainUppercaseLettersAndNumbers()
    {
        $validator = new ValidateConfirmationNumber();

        ValidateConfirmationNumber::setValidators([new CharacterValidator()]);

        $this->assertTrue($validator->validate($this->number));
    }

    public function testCannotContainAmbiguousCharacters()
    {
        $validator = new ValidateConfirmationNumber();

        ValidateConfirmationNumber::setValidators([new AmbiguityValidator()]);

        $this->assertTrue($validator->validate($this->number));
    }

    public function testConfirmationNumbersMustBeUnique()
    {
        $validator = new ValidateConfirmationNumber();

        ValidateConfirmationNumber::setValidators([new UniquenessValidator()]);

        $this->assertTrue($validator->validate($this->number));
    }
}
