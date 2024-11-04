<?php

namespace Tests\Unit\Application\Spy\Commands;

use App\Application\Spy\Commands\CreateSpyCommand;
use App\Application\Spy\DTOs\CreateSpyData;
use PHPUnit\Framework\TestCase;

class CreateSpyCommandTest extends TestCase
{
    public function testCreateSpyCommandInitialization(): void
    {
        $spyData = CreateSpyData::make([
            'name' => 'James',
            'surname' => 'Bond',
            'agency' => 'MI6',
            'country' => 'England',
            'date_of_birth' => '1920-11-11',
        ]);

        $command = new CreateSpyCommand($spyData);

        $this->assertSame($spyData, $command->spyData);
        $this->assertEquals('James', $command->spyData->name->value());
        $this->assertEquals('Bond', $command->spyData->surname->value());
        $this->assertEquals('MI6', $command->spyData->agency->value);
        $this->assertEquals('England', $command->spyData->country->value());
        $this->assertEquals('1920-11-11', $command->spyData->dateOfBirth->value());
        $this->assertNull($command->spyData->dateOfDeath);
    }
}
