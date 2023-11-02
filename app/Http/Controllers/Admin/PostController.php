<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post; //Includem modelul Post
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\AddPostRequest;
use Illuminate\Support\Facades\File;
use App\Models\Category;

class PostController extends Controller
{
    public function showPosts() {
        $categories = Category::select('id', 'title')->orderBy('title')->get(); //Am declarat și inițializat variabila.
        $nameOfSelectedCategory = null; //Declarăm o variabilă și o inițializăm cu null.
        $authorName = null;
        $postsStatus = null; 
        $searchedPost = null; //Declarăm o variabilă și o inițializăm cu null.
        // Cod pentru obținere postări după autor
        if (request('author')) {
            $posts = Post::where('user_id', request('author'))->sortable(['created_at' => 'desc'])->paginate(6)->withQueryString();
            $authorName = User::findOrFail(request('author'))->name; //Obținem numele autorului
        } else {
            $posts = Post::sortable(['created_at' => 'desc'])->paginate(6)->withQueryString(); //Implicit 15 pagini
        }
        // Cod pentru obținere postări publicate
        if (request('published') == 'public') {
            $posts = Post::where('published_at', '<>', null)->sortable(['created_at' => 'desc'])->paginate(6)->withQueryString();
            $postsStatus = "publicate"; //Se va stoca 'publicate': 
        }
        // Cod pentru obținere postări nepublicate
        if (request('published') == 'private') {
            $posts = Post::where('published_at', null)->sortable(['created_at' => 'desc'])->paginate(6)->withQueryString();
            $postsStatus = "nepublicate"; //Se va stoca 'nepublicate': 
        }
        // Cod pentru căutare postări
        if (request('searchPostTerm')) {
            $searchedPost = request('searchPostTerm');
            $posts = Post::where('title', 'LIKE', "%{$searchedPost}%")->orWhere('meta_description', 'LIKE', "%{$searchedPost}%")->sortable(['created_at' => 'desc'])->paginate(6)->withQueryString();
        }
        // Cod pentru afișare pagini după categorie
        if (request('category')) {
            $category = Category::findOrFail(request('category'));
            $posts = $category->posts()->sortable(['created_at' => 'desc'])->paginate(6)->withQueryString();
            $nameOfSelectedCategory = $category->title;
        }
        return view('admin.posts.posts')->with('posts', $posts)->with('authorName', $authorName)->with('postsStatus', $postsStatus)->with('searchedPost', $searchedPost)->with('categories', $categories)->with('nameOfSelectedCategory', $nameOfSelectedCategory); // Și am pus-o la dizpoziție pt vedere.
    }

    public function newPostForm() {
        $authors = null;
        if (auth()->user()->role == 'admin') {
            $authors = User::select('id', 'name')->where('role', 'author')->orderBy('name')->get();
        }
        return view('admin.posts.new-post-form')->with('authors', $authors);
    }

    public function createNewPost(AddPostRequest $request) {
        if (! Gate::allows('only-admin-and-author-have-rights')) {
            return redirect(route('admin.posts'))->with('error', 'Nu aveți dreptul să executați această acțiune!');
        }

        $this->validate(
            $request, 
            [
                'slug' => 'unique:posts,slug'
            ],
            [
                'slug.unique' => 'Acest slug este deja înregistrat!'
            ],
        );
        $post = new Post;

        $post->title = $request->title;
        $post->slug = Str::slug($request->slug);
        $post->subtitle = $request->subtitle;
        $post->presentation = $request->presentation;
        $post->content = $request->content;
        //Dacă avem bifat butonul Public, să se adauge data publicării:
        if ($request->published == 1) {
            $post->published_at = $request->published_at;
        }
        //Dacă utilizatorul autentificat are rolul de author, coloana user_id va fi ocupată cu id-ul utilizatorului cu rol de author autentificat:
        if(auth()->user()->role == 'author') {
            $post->user_id = auth()->id();
        }
        //Dacă utilizatorul autentificat are rolul de admin, coloana user_id va fi ocupată cu id-ul utilizatorului cu rol de author selectat de Administrator:
        if(auth()->user()->role == 'admin') {
            $post->user_id = $request->post_author;
        }

        $post->meta_title = $request->meta_title;
        $post->meta_description = $request->meta_description;
        $post->meta_keywords = $request->meta_keywords;
        
        if($request->hasFile('image')) {
            $photoExtension = $request->file('image')->getClientOriginalExtension();
            $photoName = str_replace(' ', '_', $request->title) . '_' . time() . '.' . $photoExtension;
            $request->file('image')->move('images/posts', $photoName);

            $post->image = $photoName;
        }

        $confirmationAddMessage = "Postarea " . '<strong>' . $request->title . '</strong>' . " a fost adăugată cu succes!";
        
        $post->save();
        
        return redirect(route('admin.posts'))->with('success', $confirmationAddMessage);
    }

    public function editPostForm($postId) {
        $authors = null;
        $post = Post::findOrFail($postId);
        if (auth()->user()->role == 'admin') {
            $authors = User::select('id', 'name')->where('role', 'author')->orderBy('name')->get();
        }
        return view('admin.posts.edit-post-form')->with('post', $post)->with('authors', $authors);
    }

    public function updatePost(AddPostRequest $request, $postId) {
        $this->validate(
            $request, 
            [
                'slug' => 'unique:posts,slug,' . $postId
            ],
            [
                'slug.unique' => 'Acest slug este deja înregistrat!'
            ],
        );
        $post = Post::findOrFail($postId);

        $post->title = $request->title;
        $post->slug = Str::slug($request->slug);
        $post->subtitle = $request->subtitle;
        $post->presentation = $request->presentation;
        $post->content = $request->content;
        //Dacă avem bifat butonul Public, să se adauge data publicării:
        if ($request->published == 1) {
            $post->published_at = $request->published_at;
        } else {
            $post->published_at = null;
        }
        //Dacă utilizatorul autentificat are rolul de admin, coloana user_id va fi ocupată cu id-ul utilizatorului cu rol de author selectat de Administrator:
        if(auth()->user()->role == 'admin') {
            $post->user_id = $request->post_author;
        }

        $post->meta_title = $request->meta_title;
        $post->meta_description = $request->meta_description;
        $post->meta_keywords = $request->meta_keywords;
        
        if($request->hasFile('image')) {
            if ($post->image != 'post.png') {
                File::delete('images/posts/' . $post->image);
            }
            $photoExtension = $request->file('image')->getClientOriginalExtension();
            $photoName = str_replace(' ', '_', $request->title) . '_' . time() . '.' . $photoExtension;
            $request->file('image')->move('images/posts', $photoName);

            $post->image = $photoName;
        }

        $confirmationAddMessage = "Postarea " . '<strong>' . $request->title . '</strong>' . " a fost actualizată cu succes!";
        
        $post->save();
        
        return redirect(route('admin.posts'))->with('success', $confirmationAddMessage);
    }

    public function showChangeCategoriesForm($postId) {
        $post = Post::findOrFail($postId);
        $categories = Category::select('id','title')->orderBy('title')->get();
        return view('admin.posts.change-categories-form')->with('post', $post)->with('categories', $categories);
    }

    public function changeCategories(Request $request, $postId) {
        $post = Post::findOrFail($postId);
        $post->categories()->sync($request->categories);
        $confirmationAddMessage = "Categoriile pentru postarea " . '<strong>' . $post->title . '</strong>' . " au fost schimbate cu succes!";
        return redirect(route('admin.posts'))->with('success', $confirmationAddMessage);
    }

    public function deletePost($postId) {
        if (! Gate::allows('only-admin-and-author-have-rights')) {
            return redirect(route('admin.posts'))->with('error', 'Nu aveți dreptul să executați această acțiune!');
        }
        $post = Post::findOrFail($postId);
        if ($post->image != 'post.png') {
            File::delete('images/posts/' . $post->image);
        }
        $post->categories()->detach(); //Detașăm pagina de toate categoriile.
        $post->delete();
        return redirect(route('admin.posts'))->with('success', 'Postarea ' . '<strong>' . $post->title . '</strong>' . ' a fost stearsă definitiv din baza de date!');
    }
}
