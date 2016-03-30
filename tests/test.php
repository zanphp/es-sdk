<?php

require __DIR__ . '/bootstrap.php';

function test ()
{
    $params = array (
        'hosts' =>
            array (
                0 => '10.6.1.219:8082',
            ),
    );

    $search = array (
        'index' => 'fenxiao_goods_online',
        'type' => 'goods',
        'body' =>
            array (
                'filter' =>
                    array (
                        'bool' =>
                            array (
                                'must' =>
                                    array (
                                        0 =>
                                            array (
                                                'terms' =>
                                                    array (
                                                        'fx_auth' =>
                                                            array (
                                                                0 => 1,
                                                                1 => 3,
                                                            ),
                                                    ),
                                            ),
                                        1 =>
                                            array (
                                                'terms' =>
                                                    array (
                                                        'recommend_level' =>
                                                            array (
                                                                0 => 20,
                                                                1 => 30,
                                                            ),
                                                    ),
                                            ),
                                        2 =>
                                            array (
                                                'terms' =>
                                                    array (
                                                        'sold_status' =>
                                                            array (
                                                                0 => 1,
                                                                1 => 3,
                                                            ),
                                                    ),
                                            ),
                                        3 =>
                                            array (
                                                'term' =>
                                                    array (
                                                        'is_display' => 1,
                                                    ),
                                            ),
                                        4 =>
                                            array (
                                                'missing' =>
                                                    array (
                                                        'field' => 'kdt_id_fake:1',
                                                    ),
                                            ),
                                    ),
                            ),
                    ),
                'size' => 20,
                'sort' =>
                    array (
                        0 =>
                            array (
                                'fx_display_order' =>
                                    array (
                                        'order' => 'desc',
                                    ),
                            ),
                        1 =>
                            array (
                                'sold_num' =>
                                    array (
                                        'order' => 'desc',
                                    ),
                            ),
                        2 => '_score',
                    ),
                'query' =>
                    array (
                        'boosting' =>
                            array (
                                'positive' =>
                                    array (
                                        'bool' =>
                                            array (
                                                'should' =>
                                                    array (
                                                        0 =>
                                                            array (
                                                                'match' =>
                                                                    array (
                                                                        'title' =>
                                                                            array (
                                                                                'query' => '分销',
                                                                                'minimum_should_match' => '100%',
                                                                                'boost' => 2,
                                                                            ),
                                                                    ),
                                                            ),
                                                        1 =>
                                                            array (
                                                                'match' =>
                                                                    array (
                                                                        'title' =>
                                                                            array (
                                                                                'query' => '分销',
                                                                                'minimum_should_match' => '75%',
                                                                            ),
                                                                    ),
                                                            ),
                                                    ),
                                            ),
                                    ),
                                'negative' =>
                                    array (
                                        'bool' =>
                                            array (
                                                'should' =>
                                                    array (
                                                        0 =>
                                                            array (
                                                                'term' =>
                                                                    array (
                                                                        'is_review_passed' => 0,
                                                                    ),
                                                            ),
                                                    ),
                                            ),
                                    ),
                                'negative_boost' => 0.59999999999999998,
                            ),
                    ),
            ),
    );

    $client = new Elasticsearch\Client($params);

    $client->search($search, function($data){
       var_dump(array_keys($data));
    });
}

test();