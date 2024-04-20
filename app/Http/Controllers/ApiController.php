<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    // Subscribe user to a website
    public function subscribe(Request $request, $websiteId)
    {
        Log::info('Attempting to subscribe user', ['user_id' => $request->user_id, 'website_id' => $websiteId]);

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            Log::warning('Validation failed during subscription', ['errors' => $validator->errors()]);
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $user = User::find($request->user_id);
        if (!$user) {
            Log::error('User not found during subscription', ['user_id' => $request->user_id]);
            return response()->json(['message' => 'User not found'], 404);
        }

        $website = Website::find($websiteId);
        if (!$website) {
            Log::error('Website not found during subscription', ['website_id' => $websiteId]);
            return response()->json(['message' => 'Website not found'], 404);
        }

        $user->websites()->syncWithoutDetaching([$websiteId]);
        Log::info('Subscription successful', ['user_id' => $request->user_id, 'website_id' => $websiteId]);

        return response()->json(['message' => 'Subscription successful'], 200);
    }

    // Create a post for a particular website
    public function createPost(Request $request, $websiteId)
    {
        Log::info('Attempting to create a post', ['website_id' => $websiteId]);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        if ($validator->fails()) {
            Log::warning('Validation failed during post creation', ['errors' => $validator->errors()]);
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $website = Website::find($websiteId);
        if (!$website) {
            Log::error('Website not found during post creation', ['website_id' => $websiteId]);
            return response()->json(['message' => 'Website not found'], 404);
        }

        $post = $website->posts()->create([
            'title' => $request->title,
            'description' => $request->description,
            'email_sent' => false
        ]);

        Log::info('Post created successfully', ['post_id' => $post->id, 'website_id' => $websiteId]);
        return response()->json(['message' => 'Post created successfully', 'post' => $post], 201);
    }
}
