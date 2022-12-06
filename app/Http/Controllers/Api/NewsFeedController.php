<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Newsfeed;
use App\Models\NewsfeedLike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NewsFeedController extends Controller
{
    public function index(Request $request){
        $newsfeeds = Newsfeed::with(['project', 'donation', 'user'])
            ->withCount('likes')
            ->withCount(['likes as is_liked' => function ($query) use ($request){
                if($user = $request->user('sanctum')){
                    $query->where('user_id', $user->id);
                }
                else{
                    $query->where('user_id', 0);
                }
            }])
            ->orderByDesc('created_at')
            ->paginate(10);

        $urls['urls'] = [
            'next_url' => $newsfeeds->nextPageUrl(),
            'prev_url' => $newsfeeds->previousPageUrl(),
        ];

        $urls['total'] = $newsfeeds->total();

        return $this->respondWithAdditionalData("newsfeeds", array_merge(['newsfeeds' => $newsfeeds->items()], $urls), 'success');
    }

    public function likeNewsFeed(Request $request, Newsfeed $newsfeed){
        $like = NewsfeedLike::where([
            'user_id' => $request->user()->id,
            'feed_id' => $newsfeed->id
        ])->first();

        if($like){
            $like->delete();
            return $this->respondSuccess("Unliked");
        }

        $like = new NewsfeedLike();
        $like->user_id = $request->user()->id;
        $like->feed_id = $newsfeed->id;
        $like->save();
        return $this->respondSuccess("Liked");
    }
}
