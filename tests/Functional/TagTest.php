<?php

/**
 * Class TagTest.
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
            'reverse_direction' => 0,
        ]);

        $this->seeInDatabase('tags', [
            'tag'               => 'example',
            'title'             => 'foo',
            'subtitle'          => 'bar',
            'meta_description'  => 'FooBar',
            'layout'            => 'frontend.blog.index',
            'reverse_direction' => 0,
        ]);

        $this->assertSessionHas('_new-tag', trans('messages.create_success', ['entity' => 'tag']));
        $this->assertRedirectedTo('admin/tag');
    }

    public function testItValidatesTagCreation()
    {
        $this->actingAs($this->user)->post('admin/tag', ['title' => 'example']);
        $this->assertSessionHasErrors();
    }

    public function testTagsCanBeEdited()
    {
        $this->actingAs($this->user)
            ->visit(route('admin.tag.edit', 1))
            ->type('Foo', 'title')
            ->press('Save')
            ->see('Success! Tag has been updated.')
            ->see('Foo')
            ->seeInDatabase('tags', ['title' => 'Foo']);
    }

    public function testTagsCanBeDeleted()
    {
        $this->actingAs($this->user)
            ->visit(route('admin.tag.edit', 1))
            ->press('Delete')
            ->dontSee('Success! Tag has been deleted.')
            ->press('Delete Tag')
            ->see('Success! Tag has been deleted.')
            ->dontSeeInDatabase('tags', ['id' => 1]);
    }
}
