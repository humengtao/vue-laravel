<?php
/**
 * Created by PhpStorm.
 * User: humengtao
 * Date: 2017/3/6
 * Time: 21:51
 */

namespace App\Repositories;


use App\Models\Collection;

class CollectionRepository
{
    public function getByAsc()
    {
        return Collection::orderBy('id', 'asc')->get();
    }

    public function getActiveByAsc()
    {
        return Collection::where('is_active', 1)->orderBy('id', 'asc')->get();
    }

    public function getName($collection_id)
    {
        return Collection::where('id', $collection_id)->value('name');
    }

    public function getAllNames()
    {
        return Collection::orderBy('id', 'asc')->get()->pluck('name');
    }

    //admin function
    public function toggleStatus($collection_id, $status)
    {
        if (Collection::where(['id' => $collection_id])->update(['is_active' => $status]))
            return true;
        return false;
    }

    public function save($name, $url)
    {
        if (Collection::where('name', $name)->get()->isEmpty()) {
            Collection::create([
                'name' => $name,
                'image' => $url,
                'created_at' => gmdate('Y-m-d H:i:s'),
                'updated_at' => gmdate('Y-m-d H:i:s')
            ]);
        } else {
            Collection::where('name', $name)->update(['image' => $url]);
        }
    }
}