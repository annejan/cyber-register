<?php
namespace Tests\Unit;
use App\PcePoint;
use App\User;
use App\Expertise;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Assert user might have a relation with multiple App\PcePoint(s)
     */
    public function testUserHasPcePointHasRelation() {
        $pcePoint = new PcePoint;
        $user = factory(User::class)->create();
        $this->assertEmpty($user->pcePoints);
        $pcePoint->user()->associate($user);
        $pcePoint->points = 1;
        $pcePoint->save();
        $user = User::find($user->id);
        $this->assertCount(1, $user->pcePoints);
        $pcePoint = new PcePoint;
        $pcePoint->user()->associate($user);
        $pcePoint->points = 1;
        $pcePoint->save();
        $user = User::find($user->id);
        $this->assertCount(2, $user->pcePoints);
    }

    /**
     * Assert user might have a relation with multiple App\Expertise(s)
     */
    public function testUserHasExpertiseRelation() {
        $expertise = factory(Expertise::class)->create();
        $user = factory(User::class)->create();
        $this->assertEmpty($user->expertises);
        $expertise->user()->associate($user);
        $expertise->save();
        $user = User::find($user->id);
        $this->assertCount(1, $user->expertises);
        $expertise = factory(Expertise::class)->create();
        $expertise->user()->associate($user);
        $expertise->save();
        $user = User::find($user->id);
        $this->assertCount(2, $user->expertises);
    }

    /**
     * Assert user might have a relation with multiple App\CyberExpertise(s)
     * via the Expertise relation
     */
    public function testUserHasCodesViaRelations() {
        $expertise = factory(Expertise::class)->create();
        $user = factory(User::class)->create();
        $this->assertEmpty($user->codes);
        $expertise->user()->associate($user);
        $expertise->save();
        $user = User::find($user->id);
        $this->assertCount(1, $user->codes);
        $expertise = factory(Expertise::class)->create();
        $expertise->user()->associate($user);
        $expertise->save();
        $user = User::find($user->id);
        $this->assertCount(2, $user->codes);
    }

}