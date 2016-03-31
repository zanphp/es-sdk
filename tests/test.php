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

    $index = array (
        'id' => 48,
        'index' => 'fenxiao_goods_online',
        'type' => 'goods',
        'body' =>
            array (
                'id' => 48,
                'kdt_goods_id' => 1312849,
                'kdt_id' => 1,
                'sold_status' => 1,
                'stock_num' => 2122,
                'sold_num' => 0,
                'price' => 15000,
                'price_upper' => 15000,
                'price_lower' => 15000,
                'fx_price' => 11100,
                'fx_price_lower' => 11100,
                'fx_price_upper' => 11100,
                'min_retail_price' => 15000,
                'max_retail_price' => 18000,
                'min_retail_price_lower' => 15000,
                'max_retail_price_lower' => 18000,
                'min_retail_price_upper' => 15000,
                'max_retail_price_upper' => 18000,
                'is_display' => 0,
                'created_at' => 1417850308,
                'class1' => 2,
                'fx_display_order' => 0,
                'review_status' => 10,
                'sample_status' => 0,
                'recommend_level' => 20,
                'fx_count' => 2,
                'brand_review_status' => 0,
                'report_status' => 0,
                'last_reported_at' => 0,
                'review_submit_time' => 0,
                'brand_submit_time' => 0,
                'display_order' => 0,
                'level_discount_auth' => 3,
                'alias' => '1a3o9bfqw',
                'title' => '分销 同步下架1206-1 空谷 ',
                'business' => 18,
                'is_review_passed' => 1,
                'min_profit' => 3900,
                'max_profit' => 6900,
                'average_profit' => 3900,
                'fx_auth' => 3,
                'is_enterprise_goods' => 0,
                'image_url' => 'http://dn-kdt-img-test.qbox.me/upload_files/no_pic.png',
                'activity_tag' => '',
                'is_free_delivery' => 0,
                'closest_expire_time' => 0,
                'brand_closest_expire_time' => 0,
            ),
    );

    $get = array (
        'index' => 'fenxiao_goods_online',
        'type' => 'goods',
        'id' => 48,
    );
    $client = new Elasticsearch\Client($params);

    $client->ping(function($data){
        var_dump($data);exit;
       var_dump(array_keys($data));
    });
}

test();