<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Language;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LanguageTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_language_list_page(): void
    {
        $response = $this->get(route('languages.index'));
        $response->assertStatus(200);
    }

    /**
     * test validation errors
     *
     * @return void
     */
    public function test_validation()
    {
        $response = $this->post(route('languages.store'), [
            'name' => 'Bangla',
            'code' => 'bn'
        ]);
        $response->assertStatus(302)->assertSessionHasErrors(['name', 'code']);

        $response = $this->post(route('languages.store'), [
            'name' => '',
            'code' => ''
        ]);
        $response->assertStatus(302)->assertSessionHasErrors(['name', 'code']);
    }

    /**
     * test language creation
     *
     * @return void
     */
    public function test_language_create() {
        DB::beginTransaction();
        $response = $this->post(route('languages.store'), [
            'name' => 'Arabic',
            'code' => 'ar'
        ]);

        $response->assertStatus(302);

        $language = Language::where('name','Arabic')->first();
        $this->assertNotNull($language);
        $this->assertEquals('Arabic',$language->name);

        DB::rollBack();
    }

    /**
     * test language update
     *
     * @return void
     */
    public function test_language_update() {
        DB::beginTransaction();
        $response = $this->post(route('languages.update'),[
            'id'=>11,
            'name'=>"Arabic2",
            'code'=>'ar'
        ]);

        $response->assertStatus(302);

        $language = Language::find(11);

        $this->assertNotNull($language);
        $this->assertEquals('Arabic2',$language->name);
        DB::rollBack();
    }

    public function test_language_delete() {
        
    }
}
