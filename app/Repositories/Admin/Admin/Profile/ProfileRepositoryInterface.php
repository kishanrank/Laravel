<?php

namespace App\Repositories\Admin\Admin\Profile;

interface ProfileRepositoryInterface
{
    public function all();

    public function store(array $validatesPostData);

    public function find($id);

    public function destroy($id);

    public function update($post, array $validatesPostData);
}
