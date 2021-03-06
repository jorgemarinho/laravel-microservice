<?php

namespace Tests\Feature\Models;

use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Ramsey\Uuid\Uuid as RamseyUuid;


class CategoryTest extends TestCase
{

    use DatabaseMigrations;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testList()
    {
        factory(Category::class, 1)->create();
        $categories = Category::all();
        $this->assertCount( 1, $categories);
        $categoryKey = array_keys( $categories->first()->getAttributes() );

        $this->assertEqualsCanonicalizing([
            'id',
            'name',
            'description',
            'is_active',
            'created_at',
            'updated_at',
            'deleted_at'
        ] , $categoryKey );
    }

    public function testCreate()
    {
        $category = Category::create([
            'name' => 'test1'
        ]);

        $category->refresh();

        $this->assertEquals('test1', $category->name );
        $this->assertNull($category->description);
        $this->assertTrue($category->is_active);
        $this->assertTrue( RamseyUuid::isValid($category->id));

        $category = Category::create([
            'name' => 'test1',
            'description' => null
        ]);

        $this->assertNull($category->description);


        $category = Category::create([
            'name' => 'test1',
            'description' => 'test description'
        ]);

        $this->assertEquals('test description',$category->description);
    }

    public function testUpdate()
    {
        $category = factory( Category::class )->create([
            'description' => 'test_description',
            'is_active' => false
        ])->first();

        $data = [
            'name' => 'test_update',
            'description' => 'description_update',
            'is_active' => true
        ];

        $category->update($data);

        foreach($data as $key => $value){
            $this->assertEquals($value,$category->{$key});
        }
    }

    public function testDestroy()
    {
        $category = factory( Category::class )->create([
            'name' => 'test2'
        ])->first();

        $category->delete();

        $this->assertEquals(0, count(Category::all()->toArray()));
    }
}
