<?php

namespace App\Traits\Admin\Post\Attribute;

trait PostAttributeTrait
{
    public function getActionAttributes($data)
    {
        return '<a class="btn btn-info btn-xs"  href="' . route('post.show', $data->id) . '"><i class="fa fa-eye"></i></a>&nbsp;<a class="btn btn-primary btn-xs"  href="' . route('post.edit', $data->id) . '"><i class="fa fa-edit"></i></a>&nbsp;<a class="btn btn-danger btn-xs"  href="' . route('post.delete', $data->id) . '"><i class="fa fa-trash"></i></a>';
    }

    public function getFeaturedAttribute($data)
    {
        $url = asset($data->featured);
        return '<img src="' . $url . '"  width="70" height="40" alt="' . $data->title . '"" />';
    }

    public function getPostStatusAttribute($data)
    {
        if ($data->published) {
            return '<label class="badge badge-success">Published</label>';
        }
        return '<label class="badge badge-danger">Draft</label>';
    }

    public function getPublishActionAttribute($data)
    {
        if ($data->published == 0) {
            return '<a class="btn btn-success btn-xs"  href="' . route('post.make.published', $data->id) . '"><i class="fas fa-share-square"> Publish</i></a>';
        }
        return '<a class="btn btn-danger btn-xs"  href="' . route('post.make.unpublished', $data->id) . '"><i class="fa fa-undo"> Un Publish</i></a>';
    }

    public function getUnpublishActionAttribute($data)
    {
        return '<a class="btn btn-danger btn-xs"  href="' . route('post.make.unpublished', $data->id) . '"><i class="fa fa-undo"> Un Publish</i></a>';
    }

    public function getKillActionAttribute($data){
        return '<a class="btn btn-primary btn-xs"  href="' . route('post.restore', $data->id) . '">Restore</a>';
    }

    public function getRestoreActionAttribute($data) {
        return '<a class="btn btn-danger btn-xs"  href="' . route('post.kill', $data->id) . '">Permanent Delete</a>';
    }
}
