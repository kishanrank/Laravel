<?php

namespace App\Repositories\Admin\Posts;

interface PostRepositoryInterface
{
	public function all();

	public function getAllPublishedPost();

	public function getAllTrashedPost();

	public function store(array $validatesPostData);

	public function update($post, array $validatesPostData);
	
	public function find($id);

	public function destroy($id);
	
	public function publishPost($id);

	public function unPublishPost($id);

	public function kill($id);

	public function restore($id);
}