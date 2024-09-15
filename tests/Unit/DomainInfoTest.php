<?php

namespace Tests\Unit;

use App\Models\DomainInfo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class DomainInfoTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function assertMassAssignmentPass()
    {
        $data = [
            'name' => 'example.com',
            'rank' => 5
        ];

        $domainInfo = DomainInfo::create($data);

        $this->assertEquals('example.com', $domainInfo->name);
        $this->assertEquals(5, $domainInfo->rank);
    }

    /** @test */
    public function assertMassAssignmentFail()
    {
        // Arrange: Create data including a non-fillable attribute
        $data = [
            'name' => 'example.com',
            'rank' => 5,
            'non_fillable' => 'This should not be mass assigned'
        ];


        $domainInfo = DomainInfo::create($data);

        $this->assertNull($domainInfo->non_fillable); // Should not be set
        $this->assertEquals('example.com', $domainInfo->name);
        $this->assertEquals(5, $domainInfo->rank);
    }

    /** @test */
    public function assertDirectAssignmentPass()
    {
        $data = [
            'name' => 'example.com',
            'rank' => 5
        ];

        $domainInfo = new DomainInfo();

        $domainInfo->name = $data['name'];
        $domainInfo->rank = $data['rank'];

        $domainInfo->save();

        $this->assertEquals('example.com', $domainInfo->name);
        $this->assertEquals(5, $domainInfo->rank);
    }
}
