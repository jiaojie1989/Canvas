<?php

/**
 * Class PostTest
 *
 * Test the application's post CRUD.
 */
class PostTest extends TestCase
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

    public function testItCreatesPost()
    {
        $this->actingAs($this->user)->post('admin/post', [
            'title'         => 'example',
            'slug'          => 'foo',
            'subtitle'      => 'bar',
            'content'       => 'FooBar',
            'published_at'  => Carbon\Carbon::now(),
            'layout'        => 'frontend.blog.post'
        ]);

        $this->seeInDatabase('posts', [
            'title'         => 'example',
            'slug'          => 'foo',
            'subtitle'      => 'bar',
            'content_raw'   => 'FooBar',
            'content_html'  => '<p>FooBar</p>',
            'published_at'  => Carbon\Carbon::now(),
            'layout'        => 'frontend.blog.post'
        ]);

        $this->assertSessionHas('_new-post', trans('messages.create_success', ['entity' => 'post']));
        $this->assertRedirectedTo('admin/post');
    }

    public function testItValidatesPostCreation()
    {
        $this->actingAs($this->user)->post('admin/post', ['title' => 'example']);
        $this->assertSessionHasErrors();
    }
}
