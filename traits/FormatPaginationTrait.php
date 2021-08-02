<?php


namespace yii2\traits;


use yii\data\ActiveDataProvider;

trait FormatPaginationTrait
{

    /**
     * @param $query
     * @param $format
     * @param int $page
     * @param int $pageSize
     * @return array
     */
    protected static function formatPagination($query, $format, $page = 1, $pageSize = 10)
    {
        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $pageSize,
                'page' => --$page
            ]
        ]);

        $items = collect($provider->getModels())->map($format)->toArray();

        $pagination = [
            'totalCount' => $provider->totalCount,
            'pageCount' => $provider->pagination->pageCount,
            'page' => ++$provider->pagination->page,
            'pageSize' => $provider->pagination->pageSize
        ];

        return [$items, $pagination];
    }
}
