<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;

class FrontEndController extends Controller
{
    public function showAllCategories() {
        $categories = Category::all()->sortBy('title')->sortBy('position')->where('published', '1');
        return view('front.all-categories')->with('categories', $categories);
    }

    public function showCurrentCategory(Category $category) {
        if ($category->published == 1) {
            $category->views++;
            $category->save();
            return view('front.current-category')->with('category', $category);
        }
        return redirect(route('front.all-categories'))->with('error', 'Această pagină nu există.');
    }

    public function showAllPosts() {
        if (request('posts')) {
            $posts = Post::where('published_at', '!=', 'null')->orderByDesc('published_at')->paginate(6)->withQueryString();
            return view('front.all-posts')->with('posts', $posts)->with('allPostsTitle', 'Toate postările');
        }
        //Cod pentru afișare postările unui autor:
        if (request('author')) {
            $author = User::findOrFail(request('author'));
            $posts = $author->publicPosts();
            return view('front.all-posts')->with('posts', $posts)->with('author', 'Postările autorului: ' . $author->name . ' ');
        }
        //Cod adăugat acum:
        if (request('searchPostTerm')) {
            $searchPostTerm = request('searchPostTerm');
            // where (published_at not null) and where (title or subtile or presentation == term):
            $posts = Post::whereNotNull('published_at')
                ->where(function ($query) use ($searchPostTerm) {
                    return $query
                    ->where('title', 'LIKE', "%{$searchPostTerm}%")
                    ->orWhere('subtitle', 'LIKE', "%{$searchPostTerm}%")
                    ->orWhere('presentation', 'LIKE', "%{$searchPostTerm}%");
                })
                ->orderByDesc('published_at')
                ->paginate(6)
                ->withQueryString();
            return view('front.all-posts')->with('posts', $posts)->with('searchPostTerm', 'Articole găsite pentru: ' . $searchPostTerm);
        }
    }

    public function showCurrentPost(Post $post) {
        $post->views++;
        $post->save();
        return view('front.current-post')->with('post', $post);
    }
}
