<?php

namespace App\Repositories\Admin\Tag;

interface TagRepositoryInterface
{
	public function all();

	public function store(array $validatesTagData);

	public function find($id);

	public function destroy($id);

	public function update($post, array $validatesTagData);	

	public function massDelete(array $tagsId);
}