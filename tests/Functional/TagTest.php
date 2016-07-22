<?php

/**
 * Class TagTest
 *
 * Test the application's tag CRUD.
 */
class TagTest extends TestCase
{
    use InteractsWithDatabase;

    /**
     * The user model.
     *
     * @var App\Models\User
     */
    private $user;

    /**
     * Create the user model test subject.
     *
     * @before
     * @return void
     */
    public function createUser()
    {
        $this->user = factory(App\Models\User::class)->create();
    }

    public function testItCreatesTag()
    {
        $this->actingAs($this->user)->post('admin/tag', [
            'tag'               => 'example',
            'title'             => 'foo',
            'subtitle'          => 'bar',
            'meta_description'  => 'FooBar',
            'layout'            => 'frontend.blog.index',
            'reverse_direction' => 0
        ]);

        $this->seeInDatabase('tags', [
            'tag'               => 'example',
            'title'             => 'foo',
            'subtitle'          => 'bar',
            'meta_description'  => 'FooBar',
            'layout'            => 'frontend.blog.index',
            'reverse_direction' => 0
        ]);

        $this->assertSessionHas('_new-tag', trans('messages.create_success', ['entity' => 'tag']));
        $this->assertRedirectedTo('admin/tag');
    }

    public function testItValidatesTagCreation()
    {
        $this->actingAs($this->user)->post('admin/tag', ['title' => 'example']);
        $this->assertSessionHasErrors();
    }
}
