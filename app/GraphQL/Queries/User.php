<?php

namespace App\GraphQL\Queries;

use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Support\Facades\Log;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class User
{
    /**
     * Return a value for the field.
     *
     * @param null                                                $rootValue   Usually contains the result returned from the parent field. In this case, it is always `null`.
     * @param mixed[]                                             $args        The arguments that were passed into the field.
     * @param \Nuwave\Lighthouse\Support\Contracts\GraphQLContext $context     Arbitrary data that is shared between all fields of a single query.
     * @param \GraphQL\Type\Definition\ResolveInfo                $resolveInfo Information about the query itself, such as the execution state, the field name, path to the field from the root, and more.
     *
     * @return mixed
     */
    public function resolve($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        // TODO implement the resolver
        $client = new \GuzzleHttp\Client();

        $bar = $client->get('https://jsonblob.com/api/4947d44b-7c76-11e9-8e48-31658d025df1', ['accept-encoding' => 'application/json']);

        $users = collect((json_decode($bar->getBody()->getContents()))->data->users);

        $user = $users->first(function ($item, $key) use ($args) {
            $user_id = $args['id'];

            return $item->id == $user_id;
        });

        // TODO implement the resolver

//        Log::info('show resolve info '.var_dump($resolveInfo));

//        foreach ($resolveInfo->getFieldSelection(1) as $field) {
//            if($field === "posts"){
//                $queryPosts = true;
//            }
//        }

        $bar = $client->get('https://jsonblob.com/api/7d0df1f3-7c7e-11e9-8e48-9f486a70afbc', ['accept-encoding' => 'application/json']);

        $posts = collect((json_decode($bar->getBody()->getContents()))->data->posts);

        $posts = $posts->filter(function ($item, $key) use ($args) {
            $user_id = $args['id'];

            return $item->user_id == $user_id;
        });

        $user->posts = $posts->toArray();

        return $user;
    }
}
